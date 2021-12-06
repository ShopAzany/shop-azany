<?php
     

	

	class register extends controller {

		

		public function __construct(){

		}



		public function index(){

			HeadersControl::guest('holder');


			$postdata = file_get_contents("php://input");

			$request = json_decode($postdata);

			$data = json_decode($request->data);



			$email = str_replace(' ', '', trim($data->email));

			$phone = $data->phone;

			$sellerEmail = Seller::select('email')->where('email', $email)->first()->email;

			$sellerPhone = Seller::select('phone')->where('phone', $phone)->first()->phone;



			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

				$result = 'Oops! Invalid email entered.';

			}

			elseif($sellerEmail && $sellerEmail == $email){

				$result = 'Email already taken';

			} 

			elseif($sellerPhone && $sellerPhone == $phone){

				$result = 'Phone number already taken';

			}

			else{

				$seller = Seller::createRecord($data);



				if($seller){

				 	//create login log record

				 	//SellerLoginActivity::insertRow($seller->seller_id);

                    EmailNote::signupVerification($seller);

				 	$auth = Helper::sellerHandler($seller);
					 

				 	self::printResult(Helper::actionResponse(null, $auth));

					 

				}			 	

			}



			self::printResult(Helper::actionResponse(null, null, $result));

		}


	
	  

      public function get_vendor_countries(){
		$all_data = CurrencyTbl::getAll();//
		self::printResult(Helper::actionResponse(null, $all_data));//return json response
	  }


	  public function load_payment_plan_settings_all(){
		$all_data = PaymentPlanSettings::AllPlans();//parse the arguement (country)	
		self::printResult(Helper::actionResponse(null, $all_data));//return json response
	  }

	  public function load_payment_plan_settings_by_country(){
		  //require 'models/PaymentPlanSettings.php';
		  HeadersControl::guest('holder');


		  $postdata = file_get_contents("php://input");

		  $request = json_decode($postdata);

		  $data = json_decode($request->data);
		$all_data = PaymentPlanSettings::singleCountry($data->country);//parse the arguement (country)	
		self::printResult(Helper::actionResponse(null, $all_data));//return json response
	}



		private function printResult($result){

	    	//print_r(json_encode($this->auth()));

            print_r(json_encode($result));

            exit();      

	    }


	
		public static function validate_signup_email($email) {

			//HeadersControl::guest('holder');



			//$postdata = file_get_contents("php://input");

			//$request = json_decode($postdata);

			//$data = json_decode($request->data);



            $seller = Seller::where('email', $email)->first();



            if($seller){

            	EmailNote::email_verification($seller);   

            	$result = 'success';       	

            	self::printResult(Helper::actionResponse(null, $result));

            } else {

            	$result = 'Oops! Email does not exist.';

            	self::printResult(Helper::actionResponse(null, null, $result));

            }



            self::printResult($result);      

	    }


		public function verify_token() {

			HeadersControl::guest('holder');



			$postdata = file_get_contents("php://input");

			$request = json_decode($postdata);

			$data = json_decode($request->data);



			$seller = Seller::where('email', $data->email)->first();

			$getToken = SellerVerification::getSingleEmailCode($seller->seller_id, $data->token);



			if (!$getToken) {

				$result = 'Oops! Incorrect token';

            	self::printResult(Helper::actionResponse(null, null, $result));

			} else if($getToken && CustomDateTime::currentTime() > $getToken->email_token_time){

				$result = 'Oops! Token expired';

            	self::printResult(Helper::actionResponse(null, null, $result));

			} else {

				$update = User_verification::updateToken($user->login_id, $data->token);
				$update_seller = Seller::where('seller_id', $seller->seller_id)->update(['status' => 'Active']);
				$result = 'success';

            	self::printResult(Helper::actionResponse(null, $result));

			}   

	    }


	
	public function make_reg_payment($sellerId){
		HeadersControl::guest('holder');

		if ($sellerID && is_numeric($sellerID)) {
			//$sellerID = $isAuth['sellerID'];

			$postdata = file_get_contents("php://input");
			$request = json_decode($postdata);
			$data = json_decode($request->data);
           

			$result = Paystack::validate($data);

			if($result->data->status == 'success'){
              SellerPaymentSubscription::create(
                //'seller_id' => $sellerID,
				 // 'plan' => $data->payment_plan,
				  //'expire' => ''
			  );
			}else{
				//$result = $sellerID." failed";
				self::printResult($result->data->status);
			}
		}
	}
    

	}







 

// $default = array(

// 	'email' => 'info@johndoe.com.ng', 

// 	'first_name' => 'johndoe', 

// 	'last_name' => 'johndoe', 

// 	'phone' => '56782882811', 

// 	'password' => '111111', 

// 	'date_of_birth' => '2021:05:10', 

// );



// $ed = json_encode($default);

// $data = json_decode($ed);



?>

