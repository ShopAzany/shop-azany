<?php
use Illuminate\Database\Eloquent\Model as Eloquent;

class SellerBankInfo extends Eloquent 
{
	
	protected $fillable = [ 
		'id',
        'seller_id',	
        'account_name',
        'account_number',
        'account_type',      
        'bank_name',      
        'created_at',
        'updated_at'
	 ];
     
	protected $primaryKey = 'id';
	protected $table = 'seller_bank';
  	protected $dates = [       
        'created_at',
        'updated_at'
    ];


    public static function singleBySellerID($sellerID){
        return self::where('seller_id', $sellerID)->first();
    }


    public function updateRecord($sellerID, $data=array()){
        if ($data->account_name && $data->account_number) {
            if (self::singleBank($data->id)) {
                return self::where('id', $data->id)->update([
                    'account_name'          => $data->account_name,
                    'account_number'               => $data->account_number,
                    'bank_name'                 => $data->bank_name,
                    'account_type'               => $data->account_type
                ]);
            } else {
                $create = self::create([
                    'seller_id'             => $sellerID,
                    'account_name'          => $data->account_name,
                    'account_number'               => $data->account_number,
                    'bank_name'                 => $data->bank_name,
                    'account_type'               => $data->account_type
                ]);

                if ($create) {
                    Seller::where('seller_id', $sellerID)->update([
                        'status' => 'Active',
                        'bank_info_status' => 1
                    ]);
                }

                return $create;
            }
        }

        return null;
    }


    public static function getForSeller($sellerID){
        return self::where('seller_id', $sellerID)->get();
    }

    public static function singleBank($id){
        return self::where('id', $id)->first();
    }

    public static function deleteBank($id){
        return self::where('id', $id)->delete();
    }


}

?>