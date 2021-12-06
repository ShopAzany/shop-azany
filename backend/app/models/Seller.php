<?php

use Illuminate\Database\Eloquent\Model as Eloquent;



class Seller extends Eloquent 

{

	

	protected $fillable = [ 

		'seller_id',	

        'email',

        'password',

		'first_name',

        'last_name',

        'phone',

        'store_name',

        'country',

        'country_code',

        'payment_plan',

        'photo',

        'date_of_birth',

        'email_code',

        'email_timer',

        'email_verify',

        'sms_verify',

        'biz_info_status',

        'bank_info_status',

        'status',

        'signup_ip',

        'last_login_ip',

        'last_login',

        'created_at',

        'updated_at'

	 ];

     

	protected $primaryKey = 'seller_id';

    protected $casts = [ 

        'seller_id' => 'integer', 

        'email_verify' => 'integer', 

        'sms_verify' => 'integer', 

        'biz_info_status' => 'integer', 

        'bank_info_status' => 'integer',

    ];

	protected $table = 'seller';

  	protected $dates = [

        'last_login',

        'created_at',

        'updated_at'

    ];

    

    

    public static function singleEmail($email){

        return self::where('email', $email)->first();

    }







    public function singleSeller($sellerID){

        return self::where('seller_id', $sellerID)->first();

    }



    public static function createRecord($data) {

        $info = self::create([

            'email' => $data->email,

            'password' => $data->password ? User::hashPass($data->password) : null,

            'first_name' => $data->first_name,

            'last_name' => $data->last_name ?: $data->first_name,

            'phone' => $data->phone,

            'store_name' => $data->store_name,

            'country' => $data->country,

            'country_code' => $data->country_code,

            'payment_plan' => $data->payment_plan,

            'photo' => $data->photo,

            'biz_info_status' => 0,

            'bank_info_status' => 0,

            'signup_ip' => Visitor::getIP(),

            'last_login' => Settings::currentTime(),

            'last_login_ip' => Visitor::getIP()

        ]);



        return $info;

    }



    public static function updateProfile($sellerID, $data) {

        $info = self::where('seller_id', $sellerID)->update([

            'email' => $data->email,

            'password' => $data->password ? User::hashPass($data->password) : null,

            'first_name' => $data->first_name,

            'last_name' => $data->last_name ?: $data->first_name,

            'phone' => $data->phone,

            'store_name' => $data->store_name,

            'country' => $data->country,

            'country_code' => $data->country_code,

            'payment_plan' => $data->payment_plan,

            'photo' => $data->photo,

            'biz_info_status' => 0,

            'bank_info_status' => 0,

            'signup_ip' => Visitor::getIP(),

            'last_login' => Settings::currentTime(),

            'last_login_ip' => Visitor::getIP()

        ]);



        return $info;

    }





    public static function changePassword($sellerID, $newPwd){

        return self::where('seller_id', $sellerID)->update([

            'password' => User::hashPass($newPwd)

        ]);

    }



    







}



?>