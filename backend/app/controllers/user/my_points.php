<?php
	class my_points extends controller {
		private $pageLimit = 10;	

		public function __construct(){
			Reward_points::updateExpired();
		}

		private function printResult($result) {
			print_r(json_encode($result, JSON_PRETTY_PRINT));
			exit();
		}

		public function index($token, $limit=100, $page=1){
			$isAuth = HeadersControl::user($token);
			if (isset($isAuth['loginID']) && is_numeric($isAuth['loginID'])) {
				$loginID = $isAuth['loginID'];

				if(!$page){
					$page = 1; $offset = 0;
				}
				else{				
					$offset = $limit * ($page - 1);
				}

				$userData = array(
					'earnings' => Reward_points::earnings($loginID), 
					'balance' => Reward_points::balance($loginID), 
					'expired' => Reward_points::expired($loginID), 
					'used' => Reward_points::used($loginID),
					'unusedCoupon' => Reward_points::unusedCoupon($loginID),
					'hostories' => array(
						'count' => Reward_points::hostoryCounts($loginID), 
						'data' => Reward_points::hostories($loginID, $limit, $offset), 
					)
				);

				self::printResult($userData);
			}
			else {
				self::printResult($isAuth);
			}
		}

		public function generate_coupon($token){
			$isAuth = HeadersControl::user($token);
			if (isset($isAuth['loginID']) && is_numeric($isAuth['loginID'])) {
				$loginID = $isAuth['loginID'];

				$balance = Reward_points::balance($loginID);
				if ($balance >= Configuration::single('point_min')) {
		            $pointValue = Configuration::single('point_value');
		            $amount = $balance * $pointValue;
		            $couponName = $loginID.'GET'.$amount.'_'.date('dMY');
					$result = CouponTbl::create([
		                'login_id' => $loginID,
		                'amount' => $amount,
		                'name' => str_replace(' ', '_', $couponName),
		                'status' => 'valid'
					]);
		            if ($result) {
		            	Reward_points::createdRecord(
		            		$loginID, 
		            		null, 
		            		$couponName, 
		            		$balance, 
		            		'debit', 
		            		'Ponits used to generate coupon code "'.$couponName.'"'
		            	);
		            	Reward_points::updateRecord($loginID);
		            	self::printResult(Helper::actionResponse(null, $result));
		            }
				}
	            self::printResult(Helper::actionResponse(null, null, 'Oops! Something went wrong, we could not generate coupon code for your point'));
			}
			else {
				self::printResult($isAuth);
			}
		}

	}

?>