<?php
	class SMS {
		protected $api_username;
		protected $api_password;
		protected $api_link;
		protected $sender;
		
		public function __construct(){			
			/*$this->api_link = '';
			$this->api_username = 'nsv9-dmc1';
			$this->api_password = 'dmc1234';
			$this->sender = $this->name;*/
		}

		public function phoneValidate($phone, $dailingCode=null){
			$phone = preg_replace('#[^0-9.]#', '', $phone);
			$dailingCode = preg_replace('#[^0-9.]#', '', $dailingCode);
			$dailingLt = strlen($dailingCode);

			$firt = substr($phone,0,1);
			if($firt == "0") {
				$phone = preg_replace("/^".$firt."/", $dailingCode, $phone);
			}

			$part = substr($phone, 0, $dailingLt);
			if($part != $dailingCode){
				$phone = $dailingCode.$phone;
			}

			return $phone;
		}

		public function sendCode($loginID, $phone, $dailCode=null){
			$user = User::uSingle($loginID);
			$phone = self::phoneValidate($phone, $dailCode);
			//Generate Code
			$smsCode = Settings::randomNums(4);
			$info = User::where('login_id', $loginID)->update([
				'phone' => $phone,
				'sms' => $smsCode,
				'sms_verify' => 0,
			]);

			//
			$smsContent = Sms_temp::where('id', 1)->get()->first();
			
			$search = array('{USERNAME}',  '{CODE}');
	        $replace = array(ucwords($user->username), $smsCode);

	        $message = str_replace($search, $replace, $smsContent->sms);

	        self::sendSMS($phone, $message);

			return true;
		}

		public function verifyCode($loginID, $code){
			$user = User::uSingle($loginID);
			//
			if($code == $user->sms){
				$info = User::where('login_id', $loginID)->update([
					'sms_verify' => 1
				]);

				return 1;
			}

			return 0;
		}

		public function sendSMS($phone, $message){
			$message = urlencode($message);
	        $parse_url = "http://rslr.connectbind.com/bulksms/bulksms?username=nsv9-creative&password=dmc1234&type=0&dlr=0&destination=".$phone."&source=ozitech&message=".$message;
	        $parse_url = file($parse_url); 
			//echo $phone;exit();
	        //print_r($parse_url);
	        return true;
		}

	}
?>