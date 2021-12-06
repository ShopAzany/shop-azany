<?php
	class wallet extends controller {

		public function __construct(){
		}

		private function printResult($result) {
			print_r(json_encode($result, JSON_PRETTY_PRINT));
			exit();
		}


		public function wallet_info($token){
			$isAuth = HeadersControl::seller($token);
			if (isset($isAuth['sellerID']) && is_numeric($isAuth['sellerID'])) {
				$sellerID = $isAuth['sellerID'];

				$info = array(
					'totalEarnings' => WalletTbl::totalEarnings($sellerID), 
					'totalWithdrawn' => WalletTbl::totalWithdrawn($sellerID), 
					'totalAvailable' => WalletTbl::totalAvailable($sellerID), 
					'walletHiistory' => WalletTbl::walletHiistory($sellerID), 
					'allWIthRequest' => WithdrawalsTbl::sellerAllRequest($sellerID), 
				);

				self::printResult($info);
			}
			else {
				self::printResult($isAuth);
			}
		}



	}

?>