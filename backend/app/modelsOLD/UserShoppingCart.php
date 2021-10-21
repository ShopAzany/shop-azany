<?php
	use Illuminate\Database\Eloquent\Model as Eloquent;
	class UserShoppingCart extends Eloquent {
		
		protected $fillable = [ 
			'id',
			'cart_id',
			'login_id',
			'pid', 
			'quantity',
			'variation',
			'variation_name',
			'variation_value',
			'created_at',
			'updated_at',
		];
		
		protected $table = 'user_shopping_cart';
		protected $dates = [
	        'created_at',
	        'updated_at',
	    ];

	    public static function getCart($cartID, $loginID=null){
	    	$result = self::cartData($cartID, $loginID);
	    	return array(
	    		'items' => $result['results'],
	    		'sum' => $result['sum'],
	    	);
        }

	    public static function getCart_byAdmin($loginID){
	    	$result = self::cartData(null, $loginID);
	    	return array(
	    		'items' => $result['results'],
	    		'sum' => $result['sum'],
	    	);
        }

	    public static function checkoutSelectedItem($ids=array()){
	    	$allRows = array();
	    	foreach ($ids as $id) {
	    		$row = self::selectRaw("
	    			user_shopping_cart.*,
	    			products.name AS product_name,
	    			products.featured_img,
	    			products.shipping_fee,
	    			products.shipping_method,
	    			products.brand,
	    			products.stock,
	    			product_variations.pid as productID,
	    			product_variations.name,
	    			product_variations.value,
	    			product_variations.regular_price,
	    			product_variations.sales_price,
	    			seller_bussiness_info.biz_name
	    		")
	    		->where('user_shopping_cart.id', $id)
	    		->join('products', 'products.pid', '=', 'user_shopping_cart.pid')
	    		->join('seller_bussiness_info', 'products.seller_id', '=', 'seller_bussiness_info.seller_id')
	    		->leftJoin('product_variations', 'product_variations.pid', 'user_shopping_cart.pid')->first();
	    		
	    		if ($row) {
	    			array_push($allRows, $row);
	    		}
	    	}

	    	$filteredResults = array();
	    	$total = 0;
	    	foreach ($allRows as $key => $result) {
	    		$total+= $result->sales_price * $result->quantity;
    			$result['variation'] = json_decode($result->variation, true);
    			array_push($filteredResults, $result);
	    	}

	    	return array('items' => $filteredResults, 'sum' => $total);
        }


        private function cartData($cartID, $loginID) {
        	if ($loginID) {
        		
        	}
	   		$results = self::selectRaw("
	    			user_shopping_cart.*,
	    			products.name AS product_name,
	    			products.featured_img,
	    			products.shipping_fee,
	    			products.shipping_method,
	    			products.brand,
	    			products.stock,
	    			product_variations.pid as productID,
	    			product_variations.name,
	    			product_variations.value,
	    			product_variations.regular_price,
	    			product_variations.sales_price
	    		")
	    		->whereRaw(($cartID) ? self::queryOpt($cartID, $loginID) : self::queryOptAdmin($loginID))
	    		->join('products', 'products.pid', '=', 'user_shopping_cart.pid')
	    		->leftJoin('product_variations', function($join)
                    {
                        $join->on('product_variations.pid', '=', 'user_shopping_cart.pid');
                        // $join->where('user_shopping_cart.variation_name', '=', 'product_variations.name');
                    }
                )
                // ->groupBy('user_shopping_cart.id')
	    		->orderBy('id', 'DESC')->get();

	    	$filteredResults = array();
	    	$total = 0;
	    	foreach ($results as $key => $result) {
	    		if (
	    			($result->pid == $result->productID AND $result->name == null AND ($result->variation == '' || $result->variation == null  || $result->variation == 'null')) OR
	    			($result->pid == $result->productID AND $result->variation_name == $result->name AND $result->variation_value == $result->value)
	    		) {
	    			$total+= $result->sales_price * $result->quantity;
	    			$result['variation'] = json_decode($result->variation, true);
            		$result['isFavorite'] = SavedProductsTbl::isFavorite($result->productID, $loginID);
	    			array_push($filteredResults, $result);
	    		}
	    	}

	    	return array('results' => $filteredResults, 'sum' => $total);
        }

        private function cartSum($cartID, $loginID) {
	    	// return self::selectRaw("SUM(sales_price * quantity) as Total")
	    	// 	->whereRaw(($cartID) ? self::queryOpt($cartID, $loginID) : self::queryOptAdmin($loginID))->first();
        }

        private function queryOpt($cartID, $loginID) {
        	return "login_id = '$loginID' OR cart_id = '$cartID'";
        }

        private function queryOptAdmin($loginID) {
        	return "login_id = '$loginID'";
        }

        public function addToCart($cartID, $loginID, $data) {
        	$find = $data->variation->value;
        	$variation = ($data->variation != 'null' || $data->variation != null)? json_encode($data->variation) : null;

        	$currItem = self::where('cart_id',$cartID)->where('pid',$data->pid)->where('variation_value', $find)->first();
        	$checkExist = json_decode($currItem->variation);

        	if($currItem) {
        		if ($checkExist->value == $find) {
        			$info = self::where('id', $currItem->id)->update([
						'quantity' => $currItem->quantity + $data->quantity,
						'variation' => $variation ?: json_encode($checkExist)
		        	]);
        		} else if (!$checkExist->value AND !$find) {
        			$info = self::where('id', $currItem->id)->update([
						'quantity' => $currItem->quantity + $data->quantity
		        	]);
        		}
        	}
        	else {
        		$info = self::create([
	        		'cart_id' => $cartID,
					'login_id' => $loginID ?: null,
					'pid' => $data->pid, 
					'quantity' => $data->quantity, 
					'variation' => $variation,
					'variation_name' => $data->variation->name,
					'variation_value' => $data->variation->value
	        	]);
        	}
        	
        	return self::getCart($cartID, $loginID);
        }

        public function removeItem($cartID, $id, $loginID) {
        	self::where('id', $id)->delete();
        	return self::getCart($cartID, $loginID);
        }

        public function removeItemByID($id) {
        	return self::where('id', $id)->delete();
        }

        public function updateQty($cartID, $id, $qty) {
        	$info = self::checkUpdate($cartID, $id);
        	if ($info->quantity <= 1) {
        		self::removeItem($cartID, $id);
        	}
        	self::where('cart_id', $cartID)->where('id', $id)->update([
        		'quantity' => $info->quantity -1
        	]);

        	return self::getCart($cartID);
        }

        private function checkUpdate($cartID, $id) {
        	return self::where('cart_id', $cartID)->where('id', $id)->first();
        }

	}
?>