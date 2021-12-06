<?php
	class RegisterController extends controller {
		
		public function __construct(){
		}

		public function index(){
			HeadersControl::guest('holder');
			$postdata = file_get_contents("php://input");
			$request = json_decode($postdata);
			$data = json_decode($request->data);

			$email = str_replace(' ', '', trim($data->email));
			$userEmail = User::select('email')->where('email', $email)->first()->email;

			$phone = $data->phone;
			$userPhone = User::select('phone')->where('phone', $phone)->first()->phone;

			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$result = 'Oops! Invalid email entered.';
			}
			elseif($userEmail && $userEmail == $email){
				$result = 'Email already taken';
			} 
			elseif($userPhone && $userPhone == $phone){
				$result = 'Phone number already taken';
			}
			else{
				$user = User::createRecord($data);

				if($user){
					//send email
					EmailNote::welcomeEmail($user);
					EmailNote::email_verification($user);
				 	//create login log record
				 	UserLoginActivity::insertRow($user->login_id);

				 	$auth = Helper::loginHandler($user);
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

?>