<?php
    use Illuminate\Database\Eloquent\Model as Eloquent;
    class UserShoppingCart extends Eloquent {
        
        protected $fillable = [ 
            'id',
            'cart_id',
            'login_id',
            'pid', 
            'quantity',
            'regular_price',
            'sales_price',
            'variation',
            'created_at',
            'updated_at',
        ];
        
        protected $table = 'user_shopping_cart';
        protected $dates = [
            'created_at',
            'updated_at',
        ];


        public static function singleById($id) {
            return self::where('id', $id)->first();
        }

        public static function getCart($cartID, $loginID=null){
            if (!$cartID && !$loginID) return ['items'=> [], 'sum' => 0, 'currency'=>CurrencyTbl::getDefault(),];
            $result = self::cartData($cartID, $loginID);
            $items = array();
            foreach ($result as $value) {
                $value['variation'] = json_decode($value->variation, true);
                array_push($items, $value);
            }

            return array(
                'items' => $items,
                'currency'=> CurrencyTbl::getDefault(),
                'sum' => self::cartSum($cartID, $loginID),
            );
            
        }

        public static function getCart_byAdmin($loginID){
            $result = self::cartData(null, $loginID);
            $items = array();
            foreach ($result as $value) {
                $value['variation'] = json_decode($value->variation, true);
                array_push($items, $value);
            }

            return array(
                'items' => $items,
                'sum' => self::cartSum($cartID, $loginID),
            );
            
        }


        private static function cartData($cartID, $loginID) {
            return self::selectRaw("
                    user_shopping_cart.*,
                    products.name,
                    products.images,
                    user_shopping_cart.sales_price * user_shopping_cart.quantity as subtotal,
                    products.stock,
                    products.warranty
                ")
                ->whereRaw(($cartID) ? self::queryOpt($cartID, $loginID) : self::queryOptAdmin($loginID))
                ->join('products', 'products.pid', '=', 'user_shopping_cart.pid')
                ->orderBy('id', 'DESC')->get();
        }

        private static function cartSum($cartID, $loginID) {
            // return self::selectRaw("SUM(sales_price * quantity) as Total")
            //     ->whereRaw(($cartID) ? self::queryOpt($cartID, $loginID) : self::queryOptAdmin($loginID))->first();
            if ($loginID) {
                return self::selectRaw("SUM(sales_price * quantity) as Total")
                ->whereRaw("login_id = '$loginID'")->first();
            } else {
                return self::selectRaw("SUM(sales_price * quantity) as Total")
                ->whereRaw("cart_id = '$cartID'")->first();
            }

           
        }

        private static function queryOpt($cartID, $loginID) {
            return "cart_id = '$cartID' OR login_id = '$loginID'";
        }

        private static function queryOptAdmin($loginID) {
            return "login_id = '$loginID'";
        }

        public static function addToCart($data) {
            $cartID = $data['cartID'];
            $loginID = $data['login_id'];
            $find = $data['variation']->value->variation; 


            if ($data['variation']) {
                $variation = ($data['variation'] != 'null' || $data['variation'] != null)? json_encode($data['variation']) : null;
                $checkExist = self::whereRaw("cart_id='data['cartID']' AND pid='data['pid']' AND  variation LIKE '%$find%'")->first();

                if($checkExist) {
                    $info = self::whereRaw("cart_id='data['cartID']' AND pid='data['pid']' AND  variation LIKE '%$find%'")->update([
                        'quantity' => $checkExist->quantity + 1,
                        'sales_price' => $data['sales_price'], 
                        'regular_price' => $data['regular_price'], 
                        'variation' => $variation ?: $checkExist->variation
                    ]);
                }
                else {
                    $info = self::create([
                        'cart_id' => $data->cartID,
                        'login_id' => $data->login_id,
                        'pid' => $data->pid, 
                        'quantity' => $data->quantity, 
                        'sales_price' => $data->sales_price, 
                        'regular_price' => $data->regular_price, 
                        'variation' => $variation
                    ]);
                }
            } else {
                $check = self::checkForCartID($data->cartID, $data->pid);
                if ($check) {
                    return self::where('cart_id', $cartID)->where('pid', $data->pid)->update([
                        'quantity' => $check->quantity + $data->quantity
                    ]);
                } else {
                    $getFirstVar = ProductVariation::firstProdID($data->pid);
                    return self::create([
                        'login_id' => $data->login_id,
                        'cart_id' => $data->cartID,
                        'pid' => $data->pid,
                        'quantity' => $data->quantity,
                        'regular_price' => $getFirstVar->regular_price,
                        'sales_price' => $getFirstVar->sale_price,
                    ]);
                }
            }
        }



        public static function checkForCartID($cartId, $pid){
            return self::where('cart_id', $cartId)->where('pid', $pid)->first();
        }

        public static function checkForCartIDWithPid($cartId, $loginID, $pid){
            return self::whereRaw("cart_id = '$cartId' OR login_id = '$loginID' AND pid = '$pid'")->first();
        }

        public static function removeItem($cartID, $id) {
            self::where('cart_id', $cartID)->where('id', $id)->delete();
            return self::getCart($cartID);
        }

        public static function removeItemByID($id) {
            return self::where('id', $id)->delete();
        }

        public static function removeCart($id, $cartID) {
            $delete = self::where('id', $id)->delete();

            if ($delete) {
                return self::getCart($cartID);
            }
        }

        private static function checkUpdate($cartID, $id) {
            return self::where('cart_id', $cartID)->where('id', $id)->first();
        }



        public static function updateMyCart($id, $role, $loginID){
            $get = self::singleById($id);
            if ($role == 'minus') {
                $update = self::where('id', $id)->update([
                    'quantity' => $get->quantity - 1
                ]);
            } else if($role == 'plus') {
                $update = self::where('id', $id)->update([
                    'quantity' => $get->quantity + 1
                ]);
            }

            if ($update) {
                $theUpdated = self::singleById($id);
                return self::getCart($theUpdated->cart_id, $loginID);
            }
        }




    }
