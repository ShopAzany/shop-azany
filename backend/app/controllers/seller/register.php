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
				 	SellerLoginActivity::insertRow($seller->seller_id);

				 	$auth = Helper::sellerHandler($seller);
				 	self::printResult(Helper::actionResponse(null, $auth));
				}			 	
			}

			self::printResult(Helper::actionResponse(null, null, $result));
		}

		private function printResult($result){
	    	//print_r(json_encode($this->auth()));
            print_r(json_encode($result));
            exit();      
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
