<?php
use Illuminate\Database\Eloquent\Model as Eloquent;

class WalletTbl extends Eloquent 
{
    
    protected $fillable = [ 
        'id',
        'seller_id',
        'order_id',
        'order_number',
        'amount',
        'status',
        'note',
        'source',
        'created_at',
        'updated_at'
    ];
     
    protected $table = 'wallet';
    protected $dates = [
        'created_at',
        'updated_at'
    ];



    public static function creatRow($sellerID, $amount, $status, $role, $orderID=null) {
        $order = OrdersTbl::singlebByOrderID($orderID);

        if ($order->status == 'Delivered') {
            $note = 'payment of order created on '.$order->created_at;
            $source = 'Payment of deliverd order';
        } else {
            if ($role == 'returned') {
                $note = 'Returned of order created on '.$order->created_at;
                $source = 'debit of returned order';
            } else {
                $note = 'Withdrawal request initiated on '.CustomDateTime::currentTime();
                $source = 'Withdrawal';
            }
        }
        $createWallet = self::create([
            'seller_id' => $sellerID,
            'order_id' => $orderID,
            'order_number' => $order->order_number,
            'amount' => $amount,
            'status' => $status,
            'note' =>  $note,
            'source' => $source
        ]);

        return $createWallet;
    }


    public static function singleOrderID($orderID){
        return self::where('order_id', $orderID)->first();
    }



    public static function totalEarnings($sellerID){
        return self::where('seller_id', $sellerID)->where('status', 'Credit')->sum('amount');
    }

    public static function totalWithdrawn($sellerID){
        return self::where('seller_id', $sellerID)->where('status', 'Debit')->sum('amount');
    }

    public static function totalAvailable($sellerID){
        $credit = self::totalEarnings($sellerID);
        $debit = self::totalWithdrawn($sellerID);
        return $credit - $debit;
    }

    public static function walletHiistory($sellerID){
        return self::where('seller_id', $sellerID)->get();
    }






}

?>

