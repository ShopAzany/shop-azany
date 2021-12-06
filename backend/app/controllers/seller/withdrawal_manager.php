<?php
	class withdrawal_manager extends controller {

		public function __construct(){
		}

		private function printResult($result) {
			print_r(json_encode($result, JSON_PRETTY_PRINT));
			exit();
		}


		public function request($token){
			$isAuth = HeadersControl::seller($token);
			if (isset($isAuth['sellerID']) && is_numeric($isAuth['sellerID'])) {
				$sellerID = $isAuth['sellerID'];

				$postdata = file_get_contents("php://input");
				$request = json_decode($postdata);
				$data = json_decode($request->data);

				$getAvailable = WalletTbl::totalAvailable($sellerID);

				if ($data->amount > $getAvailable) {
					$result = 'Your availabel amount is not up to '. number_format($data->amount);
					self::printResult(Helper::actionResponse(null, null, $result));
				} else {
					$update = WithdrawalsTbl::createRecorde($sellerID, $data);

					if ($update) {
						$info = array(
							'status' => 'success',
							'totalEarnings' => WalletTbl::totalEarnings($sellerID), 
							'totalWithdrawn' => WalletTbl::totalWithdrawn($sellerID), 
							'totalAvailable' => WalletTbl::totalAvailable($sellerID), 
							'walletHiistory' => WalletTbl::walletHiistory($sellerID), 
							'allWIthRequest' => WithdrawalsTbl::sellerAllRequest($sellerID), 
						);	

						self::printResult($info);
					}
				}
			}
			else {
				self::printResult($isAuth);
			}
		}


		public function approveRequest($id){
			return self::where('id', $id)->update([
				'status' => 1,
				'approve_date' => Settings::currentTime()
			]);
		}



	}

?>