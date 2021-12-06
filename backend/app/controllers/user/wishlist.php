<?php
	class wishlist extends controller {
		private $pageLimit = 10;	

		public function __construct(){
		}

		private function printResult($result) {
			print_r(json_encode($result, JSON_PRETTY_PRINT));
			exit();
		}


		public function index($token, $limit=10, $page=1){
			$isAuth = HeadersControl::user($token);
			if (isset($isAuth['loginID']) && is_numeric($isAuth['loginID'])) {
				$loginID = $isAuth['loginID'];

				if(!$page){
					$page = 1; $offset = 0;
				}
				else{				
					$offset = $limit * ($page - 1);
				}

				$savedItems = SavedProductsTbl::getForUser($loginID, $limit, $offset);

				$newList = array();
				foreach ($savedItems as $value) {
					$value['variation'] = ProductVariation::firstProdID($value->pid);
					$value['rate_number'] = ProductRatingTbl::countRate($value->pid);
					$value['average_rate'] = ProductRatingTbl::starAverageCal($value->pid);
					array_push($newList, $value);
				}

				$result = array(
					'data' => $newList, 
					'count' => SavedProductsTbl::getForUserCount($loginID)
				);

				self::printResult($result);
			}
			else {
				self::printResult($isAuth);
			}
		}


		public function remove_wishlist($token, $pid){
			$isAuth = HeadersControl::user($token);
			if (isset($isAuth['loginID']) && is_numeric($isAuth['loginID'])) {
				$loginID = $isAuth['loginID'];

				$info = SavedProductsTbl::removeRecord($loginID, $pid);

				self::printResult(Helper::actionResponse($info));
			}
			else {
				self::printResult($isAuth);
			}
		}


		public function add_wishlist($token, $pid){
			$isAuth = HeadersControl::user($token);
			if (isset($isAuth['loginID']) && is_numeric($isAuth['loginID'])) {
				$loginID = $isAuth['loginID'];

				$info = SavedProductsTbl::saveProduct($loginID, $pid);

				self::printResult(Helper::actionResponse($info));
			}
			else {
				self::printResult($isAuth);
			}
		}

	}

?>