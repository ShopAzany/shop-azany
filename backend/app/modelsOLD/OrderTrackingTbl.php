<?php
    use Illuminate\Database\Eloquent\Model as Eloquent;

    class OrderTrackingTbl extends Eloquent {
    	
    	protected $fillable = [ 
            'id', 	
			'order_id',
            'order_number',
            'pending_date',
            'processed_date',
            'shipped_date',
            'delivered_date',
            'returned_date',
            'status',
            'created_at',
            'updated_at'
    	 ];
    	
        protected $table = 'order_tracking';
    	protected $primaryKey = 'id';
      	protected $dates = [
            'pending_date',
            'processed_date',
            'shipped_date',
            'delivered_date',
            'returned_date',
            'created_at',
            'updated_at',
        ];



        public function singleByOrderID($orderID){
            return self::where('order_id', $orderID)->first();
        }


        public function createRow($orderID){
            $getOrder = OrdersTbl::singlebByOrderID($orderID);
            return self::create([
                'order_id' => $orderID,
                'order_number' => $getOrder->order_number,
                'pending_date' => CustomDateTime::currentTime(),
                'status' => 'Pending'
            ]);
        }



        public static function updateRow($orderID, $action){
            $single = self::singleByOrderID($orderID);

            $theDates = array(
                'Processing' => 'processed_date', 
                'Shipped' => 'shipped_date', 
                'Delivered' => 'delivered_date', 
                'Returned' => 'returned_date'
            );

            if ($action == 'Shipped' && $single->processed_date == null) {
                self::updateSingle($orderID, 'processed_date');
            } 

            if ($action == 'Delivered' && $single->processed_date == null) {
                self::updateSingle($orderID, 'processed_date');
            }

            if ($action == 'Delivered' && $single->shipped_date == null) {
                self::updateSingle($orderID, 'shipped_date');
            }

            foreach ($theDates as $key => $value) {
                if ($action == $key) {
                    self::where('order_id', $orderID)->update([
                        $value => CustomDateTime::currentTime(),
                        'status' => $key
                    ]);
                }
            }
        }


        public static function updateSingle($orderID, $theColumn){
            return self::where('order_id', $orderID)->update([
                $theColumn => CustomDateTime::currentTime(),
            ]);
        }


        public static function getOrder($orderID, $orderNum){
            return self::where('order_id', $orderID)->where('order_number', $orderNum)->first();
        }




    }
	
?>