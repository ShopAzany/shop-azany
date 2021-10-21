<?php
    use Illuminate\Database\Eloquent\Model as Eloquent;

    class OrdersTbl extends Eloquent {
    	
    	protected $fillable = [ 
            'order_id', 	
			'login_id',
            'seller_id',
            'pid',
            'order_number',
            'shipping_addr',
            'shipping_method',
            'note',
            'variation',
            'product_json',
            'status',
            'created_at',
            'updated_at'
    	 ];
    	
        protected $table = 'orders';
    	protected $primaryKey = 'order_id';
      	protected $dates = [
            'created_at',
            'updated_at',
        ];


        // public static function singleOrder($orderNumber, $loginID){
        //     return self::where('order_number', $orderNumber)->where('orders.login_id', $loginID)->get();
        // }

        public static function singlebByOrderID($orderID){
            return self::where('order_id', $orderID)->first();
        }

        public function generateInvoiceOrder($orderID){
            return self::select('orders.*', 'invoices.status AS invoice_status', 'invoices.payment_method', 'invoices.id AS invoice_id', 'invoices.product_price', 'invoices.quantity', 'invoices.sub_total', 'invoices.total', 'invoices.shipping_cost', 'invoices.grand_total', 'invoices.payment_method')->where('orders.order_id', $orderID)
                ->join('invoices', 'invoices.order_id', '=', 'orders.order_id')->first();
        }

        public function generateInvoiceOrders($orderNumber, $loginID){
            return self::select('orders.*', 'invoices.status AS invoice_status', 'invoices.payment_method', 'invoices.id AS invoice_id', 'invoices.product_price', 'invoices.quantity', 'invoices.sub_total', 'invoices.total', 'invoices.shipping_cost', 'invoices.grand_total', 'invoices.payment_method')->where('invoices.order_number', $orderNumber)->where('invoices.login_id', $loginID)
                ->join('invoices', 'invoices.order_id', '=', 'orders.order_id')->get();
        }

        public function generateInvoiceOrdersSingle($orderID, $loginID){
            return self::select('orders.*', 'invoices.status AS invoice_status', 'invoices.payment_method', 'invoices.id AS invoice_id', 'invoices.product_price', 'invoices.quantity', 'invoices.sub_total', 'invoices.total', 'invoices.shipping_cost', 'invoices.grand_total', 'invoices.payment_method')->where('invoices.order_id', $orderID)->where('invoices.login_id', $loginID)
                ->join('invoices', 'invoices.order_id', '=', 'orders.order_id')->get();
        }


        public static function singleOrder($id){
            return self::where('order_id', $id)->first();
        }

        // public static function singleOrderNumber($orderNumber){
        //     return self::where('order', $id)->first();
        // }


        public static  function createOrder($loginID, $data){
            return self::create([
                'login_id' => $loginID,
                'seller_id' => $data['sellerID'],
                'pid' => $data['pid'],
                'order_number' => $data['orderNumber'],
                'shipping_addr' => $data['shippingAddr'],
                'shipping_method' => $data['shippingMethod'],
                'note' => $data['note'],
                'variation' => $data['variation'],
                'product_json' => $data['productData'],
            ]);      
        }
        
        public function getOrders($loginID, $limit=10, $offset=0) {
            return self::take($limit)->offset($offset)
                ->where('orders.login_id', $loginID)
                ->join('invoices', 'invoices.order_number', '=', 'orders.order_number')
                ->groupBy('orders.order_number')
                ->orderBy('orders.order_id', 'DESC')->get();
        }

        public function getOrderCnts($loginID) {
            return count(
                self::where('orders.login_id', $loginID)
                ->join('invoices', 'invoices.order_number', '=', 'orders.order_number')
                ->groupBy('orders.order_number')->get()
            );
        }

        //Admin - all orders
        public static function allOrders($take=12, $offset=1){
            return self::take($take)->offset($offset)
                    ->join('invoices', 'invoices.order_number', '=', 'orders.order_number')
                    ->groupBy('orders.order_number')->orderBy('invoices.order_id', 'DESC')->get();
        }


        public static function allOrderCounts(){
            return self::select("order_id")->groupBy('order_number')->get()->count();
        }

        public function singleOrder_admin($orderNumber){
            return self::where('orders.order_number', $orderNumber)
                ->join('invoices', 'invoices.order_number', '=', 'orders.order_number')->get();
        }

        public function singleOrderDetails_admin($orderNumber){
            return self::select('orders.*', 'invoices.status AS invoice_status', 'invoices.payment_method', 'invoices.product_price', 'invoices.quantity', 'invoices.sub_total', 'invoices.total', 'invoices.shipping_cost', 'invoices.grand_total', 'invoices.payment_method')->where('orders.order_number', $orderNumber)
                ->join('invoices', 'invoices.order_id', '=', 'orders.order_id')->first();
        }

        public static function singleOrders_admin($orderNumber){
            return self::where('orders.order_number', $orderNumber)
                ->select('orders.*', 'invoices.status as invoice_status', 'invoices.payment_method', 'invoices.date_paid', 'invoices.sub_total', 'invoices.total', 'invoices.grand_total', 'invoices.quantity', 'invoices.product_price')
                ->join('invoices', 'invoices.order_id', '=', 'orders.order_id')->get();
        }

        public function allOrderCountsPages($otherPages) {
            return count(
                self::where('orders.status', ucwords($otherPages))->join('invoices', 'invoices.order_number', '=', 'orders.order_number')
                ->groupBy('orders.order_number')->get()
            );
        }

        public function allOrdersPages($take, $offset, $otherPages){
            return self::take($take)->offset($offset)->where('orders.status', ucwords($otherPages))
                ->select('orders.order_number', 'orders.product_json', 'orders.created_at', 'orders.status', 'orders.pid', 'orders.status', 'orders.total')
                ->join('invoices', 'invoices.order_id', '=', 'orders.order_id')
                ->groupBy('orders.order_number')
                ->orderBy('orders.order_id', 'DESC')->get();
        }


        public function recentAdminOrder(){
            $result = self::take(10)->select('orders.*', 'invoices.sub_total', 'invoices.total')
                ->join('invoices', 'invoices.order_id', '=', 'orders.order_id')
                ->groupBy('orders.order_number')
                ->orderBy('orders.order_id', 'DESC')->get();
            $newOrderDash = array();
            foreach ($result as $value) {
                $value['product_json'] = json_decode($value->product_json);
                array_push($newOrderDash, $value);
            }
            return $newOrderDash;
        }



        public function markOrder($orderID, $action, $role){
            if ($role == 'payment') {
                return Invoices::updateStatus($orderID, $action, 'bank');
            }
            elseif($role == 'delivery') {
                $update = self::where('order_id', $orderID)->update([
                    'status' => ucfirst($action)
                ]);

                if ($update) {
                    $check = OrderTrackingTbl::updateRow($orderID, $action);
                    // return $check;
                }

                if ($action == 'Returned') {
                    $order = self::select('orders.pid', 'invoices.quantity', 'orders.variation')
                        ->where('orders.order_id', $orderID)
                        ->join('invoices', 'invoices.order_id', 'orders.order_id')
                        ->first();


                    $variation = json_decode($order->variation);

                    $pVariation = ProductVariation::where('pid', $order->pid)->where('name', $variation->name)->where('value', $variation->value)->first();
                    
                    return ProductVariation::where('id', $pVariation->id)->update([
                        'order_count' => $pVariation->order_count - $order->quantity
                    ]);
                }

                return $update;
            }
        }


        public static function removeProFromQuantity($orderID){
            $order = self::select('orders.pid', 'invoices.quantity', 'orders.variation')
                ->where('orders.order_id', $orderID)
                ->join('invoices', 'invoices.order_id', 'orders.order_id')
                ->first();

            $variation = json_decode($order->variation);

            $pVariation = ProductVariation::where('pid', $order->pid)->where('name', $variation->name)->where('value', $variation->value)->first();
            
            return ProductVariation::where('id', $pVariation->id)->update([
                'order_count' => $pVariation->order_count + $order->quantity
            ]);
        }



        // START HERE
        public static function allOrderNumSingle($orderNum){
            return self::where('order_number', $orderNum)->first();
        }

        public static function allOrderNum($orderNum){
            return self::where('order_number', $orderNum)->get();
        }

        public static function countByOrderNumber($orderNum){
            return self::where('order_number', $orderNum)->count();
        }

        public function cancelMyOrder($orderNum){
            return self::where('order_number', $orderNum)->update([
                'status' => 'Cancelled'
            ]);
        }




        // SELLER ORDER
        public function getOrdersForSeller($take, $offset, $sellerID){
            return self::take($take)->offset($offset)
                ->select('orders.order_number', 'orders.product_json', 'orders.created_at', 'orders.status', 'orders.pid', 'orders.status', 'orders.total')
                ->where('orders.seller_id', $sellerID)
                ->join('invoices', 'invoices.order_id', '=', 'orders.order_id')
                ->groupBy('orders.order_number')
                ->orderBy('orders.order_id', 'DESC')->get();
        }

        public static function countProduct($sellerID, $orderNumber){
            return self::where('order_number', $orderNumber)->where('seller_id', $sellerID)->count();
        }

        public function getOrderForSellerCnts($sellerID) {
            return count(
                self::where('orders.seller_id', $sellerID)
                ->join('invoices', 'invoices.order_id', '=', 'orders.order_id')
                ->groupBy('orders.order_number')->get()
            );
        }

        public static function singleOrderDetailsSeller($orderNumber, $sellerID){
            return self::where('orders.order_number', $orderNumber)->where('orders.seller_id', $sellerID)
                ->selectRaw("orders.*, SUM(invoices.sub_total) as sub_total, invoices.status as invoice_status, invoices.payment_method, invoices.date_paid")
                ->join('invoices', 'invoices.order_id', '=', 'orders.order_id')->first();
        }

        public static function singleOrdersSeller($orderNumber, $sellerID){
            return self::where('orders.order_number', $orderNumber)->where('orders.seller_id', $sellerID)
                ->select('orders.*', 'invoices.status as invoice_status', 'invoices.payment_method', 'invoices.date_paid')
                ->join('invoices', 'invoices.order_id', '=', 'orders.order_id')->get();
        }

        public static function sellerOrderFulfilment($sellerID){
            $totalOrd = self::where('seller_id', $sellerID)->where('status', 'Delivered')->orWhere('status', 'Returned')->count();
            $totalDeli = self::where('seller_id', $sellerID)->where('status', 'Delivered')->count();
            $totalRet = self::where('seller_id', $sellerID)->where('status', 'Returned')->count();
            
            if ($totalOrd > 0) {
                $perce = (100 * $totalDeli) / $totalOrd;

                if ($perce <= 33) {
                    $result = 'Poor';
                } else if($perce > 33 && $perce <= 66 ){
                    $result = 'Good';
                } else if($perce > 66 ){
                    $result = 'Excellent';
                }

                $arrayName = array(
                    'percentage' => $perce,
                    'result' => $result 
                );
            } else {
                $arrayName = array(
                    'percentage' => 100,
                    'result' => 'Excellent' 
                );
            }

            return $arrayName;
        }



        //USER ORDER
        public function getOrdersForUser($take, $offset, $loginID){
            return self::take($take)->offset($offset)
                ->select('orders.*', 'invoices.sub_total', 'invoices.total')
                ->where('orders.login_id', $loginID)
                ->join('invoices', 'invoices.order_id', '=', 'orders.order_id')
                ->groupBy('orders.order_number')
                ->orderBy('orders.order_id', 'DESC')->get();
        }

        public function getOrderForUserCnts($loginID) {
            return count(
                self::where('orders.login_id', $loginID)
                ->join('invoices', 'invoices.order_id', '=', 'orders.order_id')
                ->groupBy('orders.order_number')->get()
            );
        }

        public function getOrdersForUserCancel($take, $offset, $loginID){
            return self::take($take)->offset($offset)
                ->select('orders.*', 'invoices.sub_total', 'invoices.total')
                ->where('orders.login_id', $loginID)
                ->where('orders.status', 'Cancelled')
                ->join('invoices', 'invoices.order_id', '=', 'orders.order_id')
                ->groupBy('orders.order_number')
                ->orderBy('orders.order_id', 'DESC')->get();
        }

        public function getOrderForUserCntsCancel($loginID) {
            return count(
                self::where('orders.login_id', $loginID)->where('orders.status', 'Cancelled')
                ->join('invoices', 'invoices.order_id', '=', 'orders.order_id')
                ->groupBy('orders.order_number')->get()
            );
        }

        public function singleOrderDetails($orderNumber, $loginID){
            return self::where('orders.order_number', $orderNumber)->where('orders.login_id', $loginID)
                ->selectRaw("orders.*, SUM(invoices.sub_total) as sub_total, invoices.status as invoice_status, invoices.payment_method, invoices.date_paid")
                ->join('invoices', 'invoices.order_id', '=', 'orders.order_id')->first();
        }

        public static function singleOrders($orderNumber, $loginID){
            return self::where('order_number', $orderNumber)->where('orders.login_id', $loginID)->get();
        }

        public static function getForUserReview($take, $offset, $loginID){
            $results = self::take($take)->offset($offset)
                ->select('orders.product_json', 'orders.order_number', 'product_rating.name', 'product_rating.title', 'product_rating.rating', 'product_rating.comment', 'product_rating.status AS rating_status', 'seller_bussiness_info.biz_name')
                ->where("orders.login_id", $loginID)->where('orders.status', 'Delivered')
                ->leftJoin('product_rating', 'orders.pid', 'product_rating.pid')
                ->join('seller_bussiness_info', 'orders.seller_id', 'seller_bussiness_info.seller_id')
                ->orderBy('orders.order_id', 'DESC')->get();

            $newReview = array();
            foreach ($results as $value) {
                $value['product_json'] = json_decode($value->product_json);
                array_push($newReview, $value);
            }

            return $newReview;
        }

        public static function getForUserReviewCount($loginID){
            return self::where("orders.login_id", $loginID)->where('orders.status', 'Delivered')->get()->count();
        }




        // SELLER DASHBOARD INFO

        public static function lastSevenDayChart($sellerID, $duration){
            $currentDate = CustomDateTime::currentTime();
            $lastSeveDay = CustomDateTime::addDate('-6 '.$duration);

            return self::where('created_at', '>=', $lastSeveDay)->where('seller_id', $sellerID)->where('status', 'Delivered')->get();
        }


        public static function lastSevenDaySold($sellerID, $duration){
            $currentDate = CustomDateTime::currentTime();
            $lastSeveDay = CustomDateTime::addDate('-6 '.$duration);
            return self::select('orders.*', 'invoices.quantity')
                ->join('invoices', 'invoices.order_id', 'orders.order_id')->where('orders.created_at', '>=', $lastSeveDay)->where('seller_id', $sellerID)->where('orders.status', 'Delivered')->sum('invoices.quantity');
        }

        public static function last30DaySold($sellerID){
            $currentDate = CustomDateTime::currentTime();
            $lastSeveDay = CustomDateTime::addDate('-30 days');
            return self::select('orders.*', 'invoices.quantity')
                ->join('invoices', 'invoices.order_id', 'orders.order_id')
                ->where('orders.created_at', '>=', $lastSeveDay)
                ->where('seller_id', $sellerID)
                ->where('orders.status', 'Delivered')->sum('invoices.quantity');
        }

        public static function totalSoldByQty($sellerID){
            return self::select('orders.*', 'invoices.quantity')
                ->join('invoices', 'invoices.order_id', 'orders.order_id')
                ->where('seller_id', $sellerID)
                ->where('orders.status', 'Delivered')->sum('invoices.quantity');
        }

        public static function last30DayProductSold($sellerID){
            $last30Day = CustomDateTime::addDate('-30 days');
            return self::where('created_at', '>=', $last30Day)->where('seller_id', $sellerID)->where('status', 'Delivered')->get();
        }


        public static function sumLast30Days($sellerID){
            $currentDate = CustomDateTime::currentTime();
            $last30Day = CustomDateTime::addDate('-30 days');

            return self::select('orders.*', 'invoices.total', 'invoices.sub_total')
                ->leftJoin('invoices', 'invoices.order_id', 'orders.order_id')
                ->where('orders.created_at', '>=', $last30Day)
                ->where('orders.status', 'Delivered')
                ->where('seller_id', $sellerID)->sum('sub_total');
        }

        // public static function last30DayCustomer($sellerID){
        //     $currentDate = CustomDateTime::currentTime();
        //     $last30Day = CustomDateTime::addDate('-30 days');
        //     return self::where('created_at', '>=', $last30Day)->where('seller_id', $sellerID)->where('status', 'Delivered')->groupBy('login_id')->count();
        // }

        public static function listOfCustomers($sellerID){
            $currentDate = CustomDateTime::currentTime();
            $last30Day = CustomDateTime::addDate('-30 days');
            return self::where('created_at', '>=', $last30Day)->where('seller_id', $sellerID)->where('status', 'Delivered')->groupBy('login_id')->get();
        }

        




    }
	
?>