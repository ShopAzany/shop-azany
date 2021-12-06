<?php
use Illuminate\Database\Eloquent\Model as Eloquent;

class SellerBussinessInfo extends Eloquent 
{
	
	protected $fillable = [ 
		'id',
		'seller_id',
        'biz_name',	
        'biz_type', 
        'biz_address',  
        'alternative_address',  
        'country',
        'zip_code',      
        'city',      
        'biz_reg_number',      
        'biz_certificate',  
        'created_at',
        'updated_at'
	 ];
     
	protected $primaryKey = 'id';
	protected $table = 'seller_bussiness_info';
  	protected $dates = [       
        'created_at',
        'updated_at'
    ];


    public static function singleBySellerID($sellerID){
        return self::where('seller_id', $sellerID)->first();
    }


    public function updateRecord($sellerID, $data=array()){
        if (self::singleBySellerID($sellerID)) {
            return self::where('seller_id', $sellerID)->update([
                'biz_name'                  => $data->biz_name,
                'biz_type'                  => $data->biz_type,
                'biz_address'               => $data->biz_address,
                'alternative_address'       => $data->alternative_address,
                'country'                   => $data->country,
                'zip_code'                  => $data->zip_code,
                'city'                      => $data->city,
                'biz_reg_number'            => $data->biz_reg_number,
                'biz_certificate'           => $data->biz_certificate
            ]);
        } else {
            $info = self::create([
                'seller_id'                 => $sellerID,
                'biz_name'                  => $data->biz_name,
                'biz_type'                  => $data->biz_type,
                'biz_address'               => $data->biz_address,
                'alternative_address'       => $data->alternative_address,
                'country'                   => $data->country,
                'zip_code'                  => $data->zip_code,
                'city'                      => $data->city,
                'biz_reg_number'            => $data->biz_reg_number,
                'biz_certificate'           => $data->biz_certificate
            ]);
            if ($info) {
                Seller::where('seller_id', $sellerID)->update([
                    'biz_info_status' => 1
                ]);

                return $info;
            }
        }
    }

    public function createRow($sellerID, $data=array()){
        return self::create([
            'seller_id'                 => $sellerID,
            'biz_name'                  => $data->biz_name,
            'biz_type'                  => $data->biz_type,
            'biz_address'               => $data->biz_address,
            'alternative_address'       => $data->alternative_address,
            'country'                   => $data->country,
            'zip_code'                  => $data->zip_code,
            'city'                      => $data->city,
            'biz_reg_number'            => $data->biz_reg_number,
            'biz_certificate'           => $data->biz_certificate
        ]);
    }


    public static function sellerBusinessInfo($sellerID){
        $seller = self::where('seller_id', $sellerID)->first();
        return $seller->biz_name;
    }


}

?>