<?php
	class account_settings extends controller {

		public function __construct(){
		}

		private function printResult($result) {
			print_r(json_encode($result, JSON_PRETTY_PRINT));
			exit();
		}


		public function business_info($token){
			$isAuth = HeadersControl::seller($token);
			if (isset($isAuth['sellerID']) && is_numeric($isAuth['sellerID'])) {
				$sellerID = $isAuth['sellerID'];
				
				$info = SellerBussinessInfo::singleBySellerID($sellerID);	

				self::printResult($info);
			}
			else {
				self::printResult($isAuth);
			}
		}

		public function dashboard_info($token, $duration='days'){
			$isAuth = HeadersControl::seller($token);
			if (isset($isAuth['sellerID']) && is_numeric($isAuth['sellerID'])) {
				$sellerID = $isAuth['sellerID'];

				$result = array(
					'lastSevenDayOrder' => OrdersTbl::lastSevenDayChart($sellerID, $duration), 
					'lastSevenDayWish' => SavedProductsTbl::lastSevenDayChart($sellerID, $duration),
					'lastSevenSold' => OrdersTbl::lastSevenDaySold($sellerID, $duration) ,
					'lastSevenWishCount' => SavedProductsTbl::lastSevenDayChart($sellerID, $duration)->count(),
					'totalRevenue' => OrdersTbl::sumLast30Days($sellerID),
					'last30DaySold' => OrdersTbl::last30DaySold($sellerID),
					'totalSold' => OrdersTbl::totalSoldByQty($sellerID),

					'totalProductInactive' => ProductVariation::totalProductByQtyInactive($sellerID),
					'totalProductActive' => ProductVariation::totalProductByQtyActive($sellerID),

					'last30DayProductSold' => OrdersTbl::last30DayProductSold($sellerID),
					'totalCustomer' => count(OrdersTbl::listOfCustomers($sellerID)),
					'listOfCustomers' => OrdersTbl::listOfCustomers($sellerID),
				);
				
				self::printResult($result);
			}
			else {
				self::printResult($isAuth);
			}
		}


		public function register_business_info($token){
			$isAuth = HeadersControl::seller($token);
			if (isset($isAuth['sellerID']) && is_numeric($isAuth['sellerID'])) {
				$sellerID = $isAuth['sellerID'];
				$postdata = file_get_contents("php://input");
				$request = json_decode($postdata);
				$data = json_decode($request->data);

				$result = SellerBussinessInfo::createRow($sellerID, $data);

				self::printResult(Helper::actionResponse(null, $result));
			}
			else {
				self::printResult($isAuth);
			}
		}


		public function update_business_info($token){
			$isAuth = HeadersControl::seller($token);
			if (isset($isAuth['sellerID']) && is_numeric($isAuth['sellerID'])) {
				$sellerID = $isAuth['sellerID'];
				$postdata = file_get_contents("php://input");
				$request = json_decode($postdata);
				$data = json_decode($request->data);

				foreach ($data as $key => $value) {
					SellerBussinessInfo::where('seller_id', $sellerID)->update([
						$key => $value
					]);
				}

				$result = SellerBussinessInfo::singleBySellerID($sellerID);
				self::printResult(Helper::actionResponse(null, $result));
			}
			else {
				self::printResult($isAuth);
			}
		}



		public function bank_info($token){
			$isAuth = HeadersControl::seller($token);
			if (isset($isAuth['sellerID']) && is_numeric($isAuth['sellerID'])) {
				$sellerID = $isAuth['sellerID'];
				
				// $info = SellerBankInfo::getForSeller($sellerID);	

				$result = SellerBankInfo::getForSeller($sellerID);
				self::printResult(Helper::actionResponse(null, $result));
			}
			else {
				self::printResult($isAuth);
			}
		}

		public function bank_info_single($token, $id){
			$isAuth = HeadersControl::seller($token);
			if (isset($isAuth['sellerID']) && is_numeric($isAuth['sellerID'])) {
				$sellerID = $isAuth['sellerID'];
				
				$info = SellerBankInfo::singleBank($id);	

				self::printResult($info);
			}
			else {
				self::printResult($isAuth);
			}
		}


		public function update_bank_info($token){
			$isAuth = HeadersControl::seller($token);
			if (isset($isAuth['sellerID']) && is_numeric($isAuth['sellerID'])) {
				$sellerID = $isAuth['sellerID'];

				$postdata = file_get_contents("php://input");
				$request = json_decode($postdata);
				$data = json_decode($request->data);
				
				$info = SellerBankInfo::updateRecord($sellerID, $data);	

				$info = array(
					'status' => 'success', 
					'data' => SellerBankInfo::getForSeller($sellerID)
				);

				self::printResult(Helper::actionResponse($info));
			}
			else {
				self::printResult($isAuth);
			}
		}


		public function delete_bank_info($token, $id){
			$isAuth = HeadersControl::seller($token);
			if (isset($isAuth['sellerID']) && is_numeric($isAuth['sellerID'])) {
				$sellerID = $isAuth['sellerID'];
				
				$info = SellerBankInfo::deleteBank($id);	

				$info = array(
					'status' => 'success', 
					'data' => SellerBankInfo::getForSeller($sellerID)
				);

				self::printResult($info);
			}
			else {
				self::printResult($isAuth);
			}
		}

		public function updateProfile($token){
			$isAuth = HeadersControl::seller($token);
			if (isset($isAuth['sellerID']) && is_numeric($isAuth['sellerID'])) {
				$sellerID = $isAuth['sellerID'];

				$postdata = file_get_contents("php://input");
				$request = json_decode($postdata);
				$data = json_decode($request->data);

				foreach ($data as $key => $value) {
					Seller::where('seller_id', $sellerID)->update([
						$key => $value
					]);
				}

				$seller = Seller::where('seller_id', $sellerID)->first();

				$getBus = SellerBussinessInfo::singleBySellerID($sellerID);
				$getBank = SellerBankInfo::getForSeller($sellerID);
				$auth = Helper::sellerHandler($seller);	            
        		$auth['biz_info'] = $getBus;
        		$auth['bank_info'] = $getBank;
			
				// $info = self::printResult(Helper::actionResponse(null, $auth));

				self::printResult(Helper::actionResponse(null, $auth));
			}
			else {
				self::printResult($isAuth);
			}
		}


		public function change_password($token){
			$isAuth = HeadersControl::seller($token);
			if (isset($isAuth['sellerID']) && is_numeric($isAuth['sellerID'])) {
				$sellerID = $isAuth['sellerID'];

				$postdata = file_get_contents("php://input");
				$request = json_decode($postdata);
				$data = json_decode($request->data);

				$seller = Seller::sellerID($sellerID);

				if(User::verifyPass($data->old_pwd, $seller->password)){
					Seller::changePassword($sellerID, $data->new_pwd);

					$seller = Seller::where('seller_id', $sellerID)->first();

					$getBus = SellerBussinessInfo::singleBySellerID($sellerID);
					$getBank = SellerBankInfo::getForSeller($sellerID);
					$auth = Helper::sellerHandler($seller);	            
	        		$auth['biz_info'] = $getBus;
	        		$auth['bank_info'] = $getBank;

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