<?php
    use Illuminate\Database\Eloquent\Model as Eloquent;

    class OrdersTblOLD extends Eloquent {
        
        protected $fillable = [ 
            'order_id', 
            'invoice_id',   
            'login_id',
            'seller_id',
            'pid',
            'order_number',
            'product_price',
            'quantity',
            'sub_total',
            'shipping_cost',
            'total',
            'shipping_addr',
            'shipping_method',
            'rate',
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
            'date_completed',
            'created_at',
            'updated_at',
        ];



        public static function countOrder($role){
            return self::where('status', $role)->count();
        }

        public static function allOrderNum($orderNum){
            return self::where('order_number', $orderNum)->get();
        }

        public static function allOrderNumSingle($orderNum){
            return self::where('order_number', $orderNum)->first();
        }

        public static function singleOrder($id){
            return self::where('order_id', $id)->first();
        }

        public static function singleOrders($orderNumber, $loginID){
            return self::where('order_number', $orderNumber)->where('orders.login_id', $loginID)->get();
        }


        public function getOrdersForSeller($take, $offset, $sellerID){
            return self::take($take)->offset($offset)
                ->select('orders.order_number', 'orders.product_json', 'orders.created_at', 'orders.status', 'orders.pid', 'orders.status', 'orders.total')
                ->where('orders.seller_id', $sellerID)
                ->join('invoices', 'invoices.id', '=', 'orders.invoice_id')
                ->groupBy('orders.order_number')
                ->orderBy('orders.order_id', 'DESC')->get();
        }

        public static function countProduct($sellerID, $orderNumber){
            return self::where('order_number', $orderNumber)->where('seller_id', $sellerID)->count();
        }

        public function getOrderForSellerCnts($sellerID) {
            return count(
                self::where('orders.seller_id', $sellerID)
                ->join('invoices', 'invoices.id', '=', 'orders.invoice_id')
                ->groupBy('orders.order_number')->get()
            );
        }


        public function getOrdersForSellerPages($take, $offset, $sellerID, $otherPages){
            return self::take($take)->offset($offset)
                ->select('orders.order_number', 'orders.product_json', 'orders.created_at', 'orders.status', 'orders.pid', 'orders.status', 'orders.total')
                ->where('orders.seller_id', $sellerID)->where('orders.status', strtolower($otherPages))
                ->join('invoices', 'invoices.id', '=', 'orders.invoice_id')
                ->groupBy('orders.order_number')
                ->orderBy('orders.order_id', 'DESC')->get();
        }

        public function getOrderForSellerCntsPages($sellerID, $otherPages) {
            return count(
                self::where('orders.seller_id', $sellerID)->where('orders.status', strtolower($otherPages))
                ->join('invoices', 'invoices.id', '=', 'orders.invoice_id')
                ->groupBy('orders.order_number')->get()
            );
        }

        public function getAllOrders($take, $offset){
            return self::take($take)->offset($offset)->orderBy('order_id', 'DESC')->get();
        }



        public static function sumOrdersubTotal($orderNumber){
            return self::where('order_number', $orderNumber)->sum('sub_total');
        }

        public static function singlebByOrderID($orderID){
            return self::where('order_id', $orderID)->first();
        }

        public static function singlebByInvoice($invoiceID){
            return self::where('invoice_id', $invoiceID)->first();
        }

        

        public function singleOrderDetails($orderNumber, $loginID){
            return self::where('orders.order_number', $orderNumber)->where('orders.login_id', $loginID)
                ->selectRaw("orders.*, SUM(orders.sub_total) as sub_total, invoices.status as invoice_status, invoices.payment_method, invoices.date_paid, invoices.coupon_code")
                ->join('invoices', 'invoices.id', '=', 'orders.invoice_id')->first();
        }


        public static  function createOrder($invoiceID, $loginID, $sellerID, $pid, $orderNumber, $price, $qty, $subTotal, $shipCost, $total, $ShipAddr, $ShipMethod, $note, $variation, $productJSON=null){
            return self::create([
                'invoice_id' => $invoiceID,   
                'login_id' => $loginID,
                'seller_id' => $sellerID,
                'pid' => $pid,
                'order_number' => $orderNumber,
                'product_price' => $price,
                'quantity' => $qty,
                'sub_total' => $subTotal,
                'shipping_cost' => $shipCost,
                'total' => $total,
                'shipping_addr' => $ShipAddr,
                'shipping_method' => $ShipMethod,
                'note' => $note,
                'product_json' => $productJSON,
                'variation' => $variation,
            ]);      
        }
       

        //USER ORDER
        public function getOrdersForUser($take, $offset, $loginID){
            return self::take($take)->offset($offset)
                ->select('orders.order_number', 'orders.seller_id', 'orders.product_json', 'orders.created_at', 'orders.status', 'orders.pid', 'orders.status', 'orders.total')
                ->where('orders.login_id', $loginID)
                ->join('invoices', 'invoices.id', '=', 'orders.invoice_id')
                ->groupBy('orders.order_number')
                ->orderBy('orders.order_id', 'DESC')->get();
        }

        public function getOrdersForUserCancel($take, $offset, $loginID){
            return self::take($take)->offset($offset)
                ->select('orders.order_number', 'orders.seller_id', 'orders.product_json', 'orders.created_at', 'orders.status', 'orders.pid', 'orders.status', 'orders.total')
                ->where('orders.login_id', $loginID)
                ->where('orders.status', 'Cancelled')
                ->join('invoices', 'invoices.id', '=', 'orders.invoice_id')
                ->groupBy('orders.order_number')
                ->orderBy('orders.order_id', 'DESC')->get();
        }

        public function getOrderForUserCntsCancel($loginID) {
            return count(
                self::where('orders.login_id', $loginID)->where('orders.status', 'Cancelled')
                ->join('invoices', 'invoices.id', '=', 'orders.invoice_id')
                ->groupBy('orders.order_number')->get()
            );
        }

        public function getOrderForUserCnts($loginID) {
            return count(
                self::where('orders.login_id', $loginID)
                ->join('invoices', 'invoices.id', '=', 'orders.invoice_id')
                ->groupBy('orders.order_number')->get()
            );
        }

        public static function countByOrderNumber($orderNum){
            return self::where('order_number', $orderNum)->count();
        }

        public static function sumOrderTotal($orderNum){
            return self::where('order_number', $orderNum)->sum("total");
        }

        public function cancelMyOrder($orderNum){
            return self::where('order_number', $orderNum)->update([
                'status' => 'Cancelled'
            ]);
        }

        //USER ORDERS




        //Admin - all orders
        public function allOrders($take, $offset){
            return self::take($take)->offset($offset)
                ->select('orders.order_number', 'orders.product_json', 'orders.created_at', 'orders.status', 'orders.pid', 'orders.status', 'orders.total')
                ->join('invoices', 'invoices.id', '=', 'orders.invoice_id')
                ->groupBy('orders.order_number')
                ->orderBy('orders.order_id', 'DESC')->get();
        }

        public function allOrderCounts() {
            return count(
                self::join('invoices', 'invoices.id', '=', 'orders.invoice_id')
                ->groupBy('orders.order_number')->get()
            );
        }

        public function allOrdersPages($take, $offset, $otherPages){
            return self::take($take)->offset($offset)->where('orders.status', ucwords($otherPages))
                ->select('orders.order_number', 'orders.product_json', 'orders.created_at', 'orders.status', 'orders.pid', 'orders.status', 'orders.total')
                ->join('invoices', 'invoices.id', '=', 'orders.invoice_id')
                ->groupBy('orders.order_number')
                ->orderBy('orders.order_id', 'DESC')->get();
        }

        public function allOrderCountsPages($otherPages) {
            return count(
                self::where('orders.status', ucwords($otherPages))->join('invoices', 'invoices.id', '=', 'orders.invoice_id')
                ->groupBy('orders.order_number')->get()
            );
        }


        // public static function allOrders($role, $take=12, $offset=1){
        //     if(strtolower($role) == 'all'){
        //         return self::take($take)->offset($offset)
        //             ->select('products.name', 'products.featured_img', 'orders.order_number', 'orders.created_at', 'orders.status', 'orders.pid', 'orders.status')
        //             ->join('products', 'products.pid', '=', 'orders.pid')
        //             ->groupBy('orders.order_number')->orderBy('order_id', 'DESC')->get();
        //     }
        //     else{
        //         return self::take($take)->offset($offset)
        //             ->select('products.name', 'products.featured_img', 'orders.order_number', 'orders.created_at', 'orders.status', 'orders.pid', 'orders.status')
        //             ->where('orders.status', $role)
        //             ->join('products', 'products.pid', '=', 'orders.pid')
        //             ->groupBy('orders.order_number')->orderBy('order_id', 'DESC')->get();
        //     }
        // }

        // public static function allOrderCounts($role){
        //     if(strtolower($role) == 'all'){
        //         return count(
        //             self::select("order_id")->groupBy('order_number')->get()
        //         );
        //     }
        //     else{
        //         return count(
        //             self::select("order_id")->where('status', $role)->groupBy('order_number')->get()
        //         );
        //     }
        // }

        // public function singleOrders_admin($orderNumber){
        //     return self::where('orders.order_number', $orderNumber)
        //         ->select('orders.*', 'invoices.status as invoice_status', 'invoices.payment_method', 'invoices.date_paid')
        //         ->join('invoices', 'invoices.id', '=', 'orders.invoice_id')->get();
        // }

        public static function singleOrders_admin($orderNumber){
            return self::where('orders.order_number', $orderNumber)
                ->select('orders.*', 'invoices.status as invoice_status', 'invoices.payment_method', 'invoices.date_paid')
                ->join('invoices', 'invoices.id', '=', 'orders.invoice_id')->get();
        }

        public static function singleOrderDetails_admin($orderNumber){
            return self::where('orders.order_number', $orderNumber)
                ->selectRaw("orders.*, SUM(orders.sub_total) as sub_total, invoices.status as invoice_status, invoices.payment_method, invoices.date_paid, invoices.coupon_code")
                ->join('invoices', 'invoices.id', '=', 'orders.invoice_id')->first();
        }

        // public function singleOrderDetails_admin($orderNumber){
        //     return self::where('orders.order_number', $orderNumber)
        //         ->selectRaw("orders.*, SUM(orders.sub_total) as sub_total, invoices.status as invoice_status, invoices.payment_method, invoices.date_paid, invoices.coupon_code")
        //         ->join('invoices', 'invoices.id', '=', 'orders.invoice_id')->first();
        // }


        public function markOrder($orderID, $action, $role){
            if ($role == 'payment') {
                $id = self::where('order_id', $orderID)->first()->invoice_id;
                return Invoices::updateStatus($id, $action, 'bank');
            }
            elseif($role == 'delivery') {
                return self::where('order_id', $orderID)->update([
                    'status' => ucfirst($action)
                ]);
            }
        }

        public static function sumAllOrders(){
            // return self::where('orders.status', 'Delivered')
            return self::join('invoices', function ($join) {
               $join->on('invoices.id', '=', 'orders.invoice_id');
               $join->where('invoices.status', '=', 'Paid');
            })
            ->sum('orders.total');
        }

        public static function sumTodayOrders(){
            $today = Settings::dayStartEnd();
            $start = $today['dayStart'];
            $end = $today['dayEnd'];

            return self::whereRaw("invoices.date_paid >= '$start' AND invoices.date_paid <= '$end'")
            ->join('invoices', function ($join) {
               $join->on('invoices.id', '=', 'orders.invoice_id');
               $join->where('invoices.status', '=', 'Paid');
            })
            ->sum('orders.total');
        }

        public static function sumWeekOrders(){
            $week = Settings::weekSartEndDate();
            $start = $week['weekStart'];
            $end = $week['weekEnd'];

            return self::whereRaw("invoices.date_paid >= '$start' AND invoices.date_paid <= '$end'")
            ->join('invoices', function ($join) {
               $join->on('invoices.id', '=', 'orders.invoice_id');
               $join->where('invoices.status', '=', 'Paid');
            })
            ->sum('orders.total');
        }

        public static function sumMonthOrders(){
            $month = Settings::monthSartEndDate();
            $start = $month['monthStart'];
            $end = $month['monthEnd'];

            return self::whereRaw("invoices.date_paid >= '$start' AND invoices.date_paid <= '$end'")
            ->join('invoices', function ($join) {
               $join->on('invoices.id', '=', 'orders.invoice_id');
               $join->where('invoices.status', '=', 'Paid');
            })
            ->sum('orders.total');
        }

        public static function sumYearOrders(){
            $year = Settings::yearSartEndDate();
            $start = $year['yearStart'];
            $end = $year['yearEnd'];

            return self::whereRaw("invoices.date_paid >= '$start' AND invoices.date_paid <= '$end'")
            ->join('invoices', function ($join) {
               $join->on('invoices.id', '=', 'orders.invoice_id');
               $join->where('invoices.status', '=', 'Paid');
            })
            ->sum('orders.total');
        }



        public static function getForUserReview($take, $offset, $loginID){
            return self::take($take)->offset($offset)
                ->whereRaw("login_id = '$loginID' AND status = 'Delivered' AND rate = 0")->get();
        }

        public static function getForUserReviewCount($loginID){
            return self::whereRaw("login_id = '$loginID' AND status = 'Delivered' AND rate = 0")->count();
        }

        public static function countForReview($loginID){
            return self::where('login_id', $loginID)->where('status', 'Delivered')->count();
        }


        public static function singleOrderDetailsSeller($orderNumber, $sellerID){
            return self::where('orders.order_number', $orderNumber)->where('orders.seller_id', $sellerID)
                ->selectRaw("orders.*, SUM(orders.sub_total) as sub_total, invoices.status as invoice_status, invoices.payment_method, invoices.date_paid, invoices.coupon_code")
                ->join('invoices', 'invoices.id', '=', 'orders.invoice_id')->first();
        }

        public static function singleOrdersSeller($orderNumber, $sellerID){
            return self::where('orders.order_number', $orderNumber)->where('orders.seller_id', $sellerID)
                ->select('orders.*', 'invoices.status as invoice_status', 'invoices.payment_method', 'invoices.date_paid')
                ->join('invoices', 'invoices.id', '=', 'orders.invoice_id')->get();
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
            return self::where('created_at', '>=', $lastSeveDay)->where('seller_id', $sellerID)->where('status', 'Delivered')->sum('quantity');
        }

        public static function last30DaySold($sellerID){
            $currentDate = CustomDateTime::currentTime();
            $lastSeveDay = CustomDateTime::addDate('-30 days');
            return self::where('created_at', '>=', $lastSeveDay)->where('seller_id', $sellerID)->where('status', 'Delivered')->sum('quantity');
        }

        public static function totalSoldByQty($sellerID){
            return self::where('seller_id', $sellerID)->where('status', 'Delivered')->sum('quantity');
        }

        public static function last30DayProductSold($sellerID){
            $last30Day = CustomDateTime::addDate('-30 days');
            return self::where('created_at', '>=', $last30Day)->where('seller_id', $sellerID)->where('status', 'Delivered')->get();
        }


        public static function sumLast30Days($sellerID){
            $currentDate = CustomDateTime::currentTime();
            $last30Day = CustomDateTime::addDate('-30 days');
            return self::where('created_at', '>=', $last30Day)->where('seller_id', $sellerID)->where('status', 'Delivered')->sum('total');
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