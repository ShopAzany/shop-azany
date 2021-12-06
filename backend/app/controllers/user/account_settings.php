<?php
	class account_settings extends controller {
		private $pageLimit = 10;	

		public function __construct(){
		}

		private function printResult($result) {
			print_r(json_encode($result, JSON_PRETTY_PRINT));
			exit();
		}


		public function updateProfile($token){
			$isAuth = HeadersControl::user($token);
			if (isset($isAuth['loginID']) && is_numeric($isAuth['loginID'])) {
				$loginID = $isAuth['loginID'];
				$user = User::singleUser($loginID);

				$postdata = file_get_contents("php://input");
				$request = json_decode($postdata);
				$data = json_decode($request->data);

				foreach ($data as $key => $value) {
					if ($key == 'email') {
						$check = User::singleEmail($value);
						if ($check) {
							$result = 'This email address have been taken';
							self::printResult(Helper::actionResponse(null, null, $result));
						} else {
							EmailNote::emailRest($user);
							$result = $data->email;
							self::printResult(Helper::actionResponse(null, $result));
						}
					}

					User::where('login_id', $loginID)->update([
						$key => $value
					]);
				}

				$user = User::singleUser($loginID);
				$auth = Helper::loginHandler($user);

				self::printResult(Helper::actionResponse(null, $auth));
			}
			else {
				self::printResult($isAuth);
			}
		}

		public function verifyEmailToken($token){
			$isAuth = HeadersControl::user($token);
			if (isset($isAuth['loginID']) && is_numeric($isAuth['loginID'])) {
				$loginID = $isAuth['loginID'];

				$postdata = file_get_contents("php://input");
				$request = json_decode($postdata);
				$data = json_decode($request->data);

				$getToken = User_verification::getSingleEmailCode($loginID, $data->token);

				if (!$getToken) {
					$result = 'Oops! Incorrect token';
	            	self::printResult(Helper::actionResponse(null, null, $result));
				} else if($getToken && CustomDateTime::currentTime() > $getToken->email_token_time){
					$result = 'Oops! Token expired';
	            	self::printResult(Helper::actionResponse(null, null, $result));
				} else {
					$update = User_verification::updateToken($loginID, $data->token);

					if ($update) {
						User::updateEmail($loginID, $data->tokenEmail);

						$user = User::singleUser($loginID);
						$auth = Helper::loginHandler($user);

						self::printResult(Helper::actionResponse(null, $auth));		
					}
				}   
			}
			else {
				self::printResult($isAuth);
			}
		}

		public function change_password($token){
			$isAuth = HeadersControl::user($token);
			if (isset($isAuth['loginID']) && is_numeric($isAuth['loginID'])) {
				$loginID = $isAuth['loginID'];

				$postdata = file_get_contents("php://input");
				$request = json_decode($postdata);
				$data = json_decode($request->data);

				$user = User::singleUser($loginID);


				if(User::verifyPass($data->old_pwd, $user->password)){
					User::changePassword($loginID, $data->new_pwd);

					$user = User::singleUser($loginID);

					$auth = Helper::sellerHandler($user);	
					self::printResult(Helper::actionResponse(null, $auth));
	        		
				} else {
					$result = 'Old password is wrong';
					self::printResult(Helper::actionResponse(null, null, $result));
				}

				self::printResult(Helper::actionResponse(null, $auth));
			}
			else {
				self::printResult($isAuth);
			}
		}





	}

?>