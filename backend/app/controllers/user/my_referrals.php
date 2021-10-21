<?php
	class my_referrals extends controller {
		private $pageLimit = 10;	

		public function __construct(){
			Reward_points::updateExpired();
		}

		private function printResult($result) {
			print_r(json_encode($result, JSON_PRETTY_PRINT));
			exit();
		}

		public function index($token, $limit=12, $page=1){
			$isAuth = HeadersControl::user($token);
			if (isset($isAuth['loginID']) && is_numeric($isAuth['loginID'])) {
				$loginID = $isAuth['loginID'];

				if(!$page){
					$page = 1; $offset = 0;
				}
				else{				
					$offset = $limit * ($page - 1);
				}

				$downlinesTree = array();
				$referral_level = Configuration::single('referral_level');
				for ($i=0; $i < $referral_level; $i++) { 
					$downlines = User::userDownliners($loginID, $i+1, $limit, $offset);
					array_push($downlinesTree, $downlines);
				}				
				
				self::printResult($downlinesTree);
			} else {
				self::printResult($isAuth);
			}
		}

	}

?>