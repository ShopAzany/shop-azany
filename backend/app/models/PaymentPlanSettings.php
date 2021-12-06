<?php

use Illuminate\Database\Eloquent\Model as Eloquent;



class PaymentPlanSettings extends Eloquent 

{

	

	protected $fillable = [ 

		'country',

        'code',

        'plan',

        'amount',

		'currency',

        'content',

        'created_at',

        'updated_at'

	 ];

     

	protected $primaryKey = 'id';

    protected $casts = [ 

        'id' => 'integer', 

        'amount' => 'integer', 

    ];

	protected $table = 'payment_plan_settings';

  	protected $dates = [

        'created_at',

        'updated_at'

    ];

    

    public function AllPlans(){
        return self::all();
    }

    public function singleCountry($country){

        return self::where('country', $country)->get();

    }







    public function singlePlan($id){

        return self::where('id', $id)->first();

    }



    public function createRecord($data) {

        $info = self::create([

            'country' => $data->country,

            'plan' => $data->plan,

            'amount' => $data->amount,

            'currency' => $data->currency,

            'content' => $data->content,

        ]);



        return $info;

    }



    public static function updateRecord($id, $data) {
      //update record where id is equals to argument passed
        $info = self::where('id', $id)->update([

            'country' => $data->country,

            'plan' => $data->plan,

            'amount' => $data->amount,

            'currency' => $data->currency,

        ]);



        return $info;

    }





    public static function deleteRecord($id){

        return self::where('id', $id)->delete();//delete record where id is equals to argument

    }



    







}



?>