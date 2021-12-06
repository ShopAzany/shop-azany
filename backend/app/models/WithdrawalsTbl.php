<?php
use Illuminate\Database\Eloquent\Model as Eloquent;

class WithdrawalsTbl extends Eloquent 
{
    
    protected $fillable = [ 
        'id',  
        'wallet_id',
        'seller_id',
        'amount',
        'bank',
        'status',
        'approve_date',
        'created_at',
        'updated_at'
     ];
     
    protected $primaryKey = 'id';
    protected $casts = [ 
        'id' => 'integer', 
        'wallet_id' => 'integer', 
        'seller_id' => 'integer', 
        'amount' => 'double', 
        'status' => 'integer', 
    ];
    protected $table = 'withdrawals';
    protected $dates = [
        'approve_date',
        'created_at',
        'updated_at'
    ];



    public static function createRecorde($sellerID, $data){
        if ($data->amount > 0) {
            $info = WalletTbl::creatRow(
                $sellerID, 
                $data->amount, 
                'Debit', 
                'withdrawal',
                false
            );

            if ($info) {
                $getBank = SellerBankInfo::singleBank($data->bankID);
                self::create([
                    'wallet_id' => $info->id,
                    'seller_id' => $sellerID,
                    'amount' => $data->amount,
                    'bank' => $getBank,
                ]);
            }

            return $info;
        }
        return false;
    }
    


    public static function sellerAllRequest($sellerID){
        return self::where('seller_id', $sellerID)->get();
    }



}

?>