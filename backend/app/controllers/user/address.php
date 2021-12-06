<?php
	class address extends controller {
		private $pageLimit = 10;	

		public function __construct(){
		}

		private function printResult($result) {
			print_r(json_encode($result, JSON_PRETTY_PRINT));
			exit();
		}


		public function index($token){
			$isAuth = HeadersControl::user($token);
			if (isset($isAuth['loginID']) && is_numeric($isAuth['loginID'])) {
				$loginID = $isAuth['loginID'];
				
				$info = UserAddresses::addresses($loginID);	

				self::printResult($info);
			}
			else {
				self::printResult($isAuth);
			}
		}

		public function defaulAdd($token){
			$isAuth = HeadersControl::user($token);
			if (isset($isAuth['loginID']) && is_numeric($isAuth['loginID'])) {
				$loginID = $isAuth['loginID'];
				
				$defaultAddress = UserAddresses::defaultAddress($loginID);

				self::printResult($defaultAddress);
			}
			else {
				self::printResult($isAuth);
			}
		}

		public function single($token, $id){
			self::printResult('fghjmk');
			$isAuth = HeadersControl::user($token);
			if (isset($isAuth['loginID']) && is_numeric($isAuth['loginID'])) {
				$loginID = $isAuth['loginID'];
				
				$info = UserAddresses::single($id);	

				self::printResult($info);
			}
			else {
				self::printResult($isAuth);
			}
		}

		public function add($token){
			$isAuth = HeadersControl::user($token);
			if (isset($isAuth['loginID']) && is_numeric($isAuth['loginID'])) {
				$loginID = $isAuth['loginID'];

				$postdata = file_get_contents("php://input");
				$request = json_decode($postdata);
				$data = json_decode($request->data);
				
				$info = UserAddresses::createRecord($loginID, $data);

				self::printResult(Helper::actionResponse(null, $info));
			}
			else {
				self::printResult($isAuth);
			}
		}

		
		public function edit($token){
			$isAuth = HeadersControl::user($token);
			if (isset($isAuth['loginID']) && is_numeric($isAuth['loginID'])) {
				$loginID = $isAuth['loginID'];

				$postdata = file_get_contents("php://input");
				$request = json_decode($postdata);
				$data = json_decode($request->data);
				
				$info = UserAddresses::updateRecord($loginID, $data);

				$result = UserAddresses::addresses($loginID);	

				self::printResult(Helper::actionResponse(null, $result));
			}
			else {
				self::printResult($isAuth);
			}
		}


		public function delete($token, $id){
			$isAuth = HeadersControl::user($token);
			if (isset($isAuth['loginID']) && is_numeric($isAuth['loginID'])) {
				$loginID = $isAuth['loginID'];

				$info = UserAddresses::deleteAddr($id);	

				$result = UserAddresses::addresses($loginID);	

				self::printResult(Helper::actionResponse(null, $result));
			}
			else {
				self::printResult($isAuth);
			}
		}
		

		public function setDefault($token, $id){
			$isAuth = HeadersControl::user($token);
			if (isset($isAuth['loginID']) && is_numeric($isAuth['loginID'])) {
				$loginID = $isAuth['loginID'];

				$info = UserAddresses::setDefult($id, $loginID);	

				$result = UserAddresses::addresses($loginID);	

				self::printResult(Helper::actionResponse(null, $result));
			}
			else {
				self::printResult($isAuth);
			}
		}
	}

?>