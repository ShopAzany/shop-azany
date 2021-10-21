<?php


use Illuminate\Database\Eloquent\Model as Eloquent;

class Invoices extends Eloquent 
{
	
	protected $fillable = [ 
		'id',	
        'order_id',
        'order_number',
        'login_id',
        'product_price',
        'quantity',
        'sub_total',
        'total',
        'shipping_cost',
        'grand_total',
        'payment_method',
        'status',
        'date_paid',
        'date_refunded',
        'created_at',
        'updated_at'
	];
	
    protected $table = 'invoices';
    protected $casts = [ 
        'id' => 'integer', 
        'order_id' => 'integer', 
        'login_id' => 'integer', 
        'product_price' => 'double', 
        'quantity' => 'double', 
        'sub_total' => 'double',
        'total' => 'double', 
        'shipping_cost' => 'double', 
        'grand_total' => 'double',
    ];
	protected $primaryKey = 'id';
  	protected $dates = [
        'created_at',
        'updated_at',

    ];

    public static function single($id) {
        return self::where('id', $id)->first();
    }

    public static function singleOrder($orderID) {
        return self::where('order_id', $orderID)->first();
    }

    
    public static  function insertInvoice($loginID, $data){
        if ($data['orderNumber']) {
            return self::create([
                'order_number' => $data['orderNumber'],
                'order_id' => $data['order_id'],
                'login_id' => $loginID,
                'product_price' => $data['productPrice'],
                'quantity' => $data['qty'],
                'sub_total' => $data['subTotal'],
                'total' => $data['total'],
                'shipping_cost' => $data['shippingCost'],
                'grand_total' => $data['grandTotal'],
                'payment_method' => $data['pMethod'],
            ]);
        }

        return null;
    }

    public static  function markPaid($orderID, $pMethod) {
        $isPaid = self::singleOrder($orderID);
        if ($isPaid->status != 'Paid'){
            return self::where('order_id', $orderID)->update([
                'payment_method' => $pMethod,
                'status' => 'Paid',
                'date_paid' => Settings::currentTime()
            ]);
        }

        return false;
    }

    public static function updateStatus($orderID, $action, $pMethod){
        $isPaid = self::singleOrder($orderID);
        if (strtolower($action) == 'paid') {
            return self::markPaid($orderID, $pMethod);
        }
        else if(strtolower($action) == 'refunded' AND $isPaid->status == 'Paid') {
            return self::where('order_id', $orderID)->update([
                'status' => 'Refunded',
                'date_refunded' => Settings::currentTime()
            ]);  
        }

        return null;            
    }


    public static function sumShippingCost($orderNum){
        return self::where('order_number', $orderNum)->sum('shipping_cost');
    }



}
	
?>