<?php
	class forget_password extends controller
	{
		public function __construct() {		
		}


		public function index() {
			HeadersControl::guest('holder');

			print_r('invalid');
			exit();
		}

		private function printResult($result) {
			print_r(json_encode($result));
			exit();
		}

		public function validate_email() {
			HeadersControl::guest('holder');

			$postdata = file_get_contents("php://input");
			$request = json_decode($postdata);
			$data = json_decode($request->data);


            $user = User::singleEmail($data->email);

            if($user){
            	EmailNote::passwordResetEmail($user);          	
            	$result = 'success';
            	self::printResult(Helper::actionResponse(null, $result));
            } else {
            	$result = 'Oops! Email does not exist.';
            	self::printResult(Helper::actionResponse(null, null, $result));
            }
	    }

		// public function verify_code($root, $subRoot, $code) {
		// 	HeadersControl::guest('holder');

		// 	$result['status'] = 'failed';
  //           $result['code'] = $code;
  //           $result['auth'] = null;
  //           $user = User_verification::verifyEmail($code);
  //           if($user) {
  //           	$result['status'] = 'success';
  //           	$result['code'] = $code;
  //           	$result['auth'] = $user;
  //           }

  //           self::printResult($result);      
	 //    }


	    public function verify_token() {
			HeadersControl::guest('holder');

			$postdata = file_get_contents("php://input");
			$request = json_decode($postdata);
			$data = json_decode($request->data);

            	// self::printResult($data);

			$user = User::singleEmail($data->email);
			$getToken = User_verification::getSingleEmailCode($user->login_id, $data->token);

			if (!$getToken) {
				$result = 'Oops! Incorrect token';
            	self::printResult(Helper::actionResponse(null, null, $result));
			} else if($getToken && CustomDateTime::currentTime() > $getToken->email_token_time){
				$result = 'Oops! Token expired';
            	self::printResult(Helper::actionResponse(null, null, $result));
			} else {
				$update = User_verification::updateToken($user->login_id, $data->token);
				$result = 'success';
            	self::printResult(Helper::actionResponse(null, $result));
			}   
	    }

		public function change_password() {
			HeadersControl::guest('holder');

			$postdata = file_get_contents("php://input");
			$request = json_decode($postdata);
			$data = json_decode($request->data);

			$info = User::where('email', $data->email)->update([
				'password' => User::hashPass($data->password)
			]);

			$result = 'success';
        	self::printResult(Helper::actionResponse(null, $result));  
	    }

	}
?>