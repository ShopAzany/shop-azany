<?php
	class rating extends controller {
		private $pageLimit = 10;	

		public function __construct(){
		}

		// public function index(){
		// 	self::printResult('Invalid');
		// }


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

				$forReview = OrdersTbl::getForUserReview($limit, $offset, $loginID);

				$result = array(
					'data' => $forReview, 
					'count' => OrdersTbl::getForUserReviewCount($loginID) 
				);

				self::printResult($result);
			}
			else {
				self::printResult($isAuth);
			}
		}





		public function rate($token, $orderID){
			$isAuth = HeadersControl::user($token);
			if (isset($isAuth['loginID']) && is_numeric($isAuth['loginID'])) {
				$loginID = $isAuth['loginID'];

				$orderSingle = OrdersTbl::singleOrder($orderID);
				$product = json_decode($orderSingle->product_json);
				$orderSingle['pro_image'] = $product->featured_img;
				$orderSingle['pro_name'] = $product->name;

				$result = array(
					'orderDetail' =>	$orderSingle,
				);
				self::printResult($result);
			}
			else {
				self::printResult($isAuth);
			}
		}


		public function post_rate($token){
			$isAuth = HeadersControl::user($token);
			if (isset($isAuth['loginID']) && is_numeric($isAuth['loginID'])) {
				$loginID = $isAuth['loginID'];	

				$postdata = file_get_contents("php://input");
				$request = json_decode($postdata);
				$data = json_decode($request->data);	

				$post = ProductRatingTbl::createRow($loginID, $data);	

				self::printResult(Helper::actionResponse(null, $post));
			}
			else {
				self::printResult($isAuth);
			}
		}


		private function printResult($result) {
			print_r(json_encode($result, JSON_PRETTY_PRINT));
			exit();
		}
		
	}

?>