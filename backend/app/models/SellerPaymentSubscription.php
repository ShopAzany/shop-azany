<?php

use Illuminate\Database\Eloquent\Model as Eloquent;



class SellerPaymentSubscription extends Eloquent 

{

	

	protected $fillable = [ 

		'seller_id',	

        'plan',

        'expire',

        'created_at',

        'updated_at'

	 ];

     

	protected $primaryKey = 'id';

    protected $casts = [ 

        'id' => 'integer', 

        'seller_id' => 'integer', 

    ];

	protected $table = 'seller_payment_subscription';

  	protected $dates = [

        'created_at',

        'updated_at'

    ];

    

    

    public function sellerRecord($sellerID){

        return self::where('seller_id', $sellerID)->first();

    }







    public function singleSellerRecord($id){

        return self::where('id', $id)->first();

    }



    public static function createRecord($data) {

        $info = self::create([

            'seller_id' => $data->seller_id,

            'plan' => $data->plan,

            'expire' => $data->expire,

        ]);



        return $info;

    }



    public static function updateRecord($id, $data) {
      //update record where id is equals to argument passed
        $info = self::where('id', $id)->update([

            'seller_id' => $data->seller_id,

            'plan' => $data->plan,

            'expire' => $data->expire,

        ]);



        return $info;

    }





    public static function deleteRecord($id){

        return self::where('id', $id)->delete();//delete record where id is equals to argument

    }



    







}



?>