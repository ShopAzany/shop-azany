<?php
	class order extends controller {
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

				$orders = OrdersTbl::getOrdersForUser($limit, $offset, $loginID);	
				$newOrders = array();
				foreach ($orders as $value) {
					$value['product_json'] = json_decode($value->product_json);
					$value['seller_name'] = SellerBussinessInfo::sellerBusinessInfo($value->seller_id);
					array_push($newOrders, $value);
				}

				$result = array(
					'data' => $newOrders, 
					'count' => OrdersTbl::getOrderForUserCnts($loginID) 
				);

				self::printResult($result);
			}
			else {
				self::printResult($isAuth);
			}
		}


		public function getCancelledOrder($token, $limit=10, $page=1){
			$isAuth = HeadersControl::user($token);
			if (isset($isAuth['loginID']) && is_numeric($isAuth['loginID'])) {
				$loginID = $isAuth['loginID'];

				if(!$page){
					$page = 1; $offset = 0;
				}
				else{				
					$offset = $limit * ($page - 1);
				}

				$orders = OrdersTbl::getOrdersForUserCancel($limit, $offset, $loginID);	
				$newOrders = array();
				foreach ($orders as $value) {
					$value['product_json'] = json_decode($value->product_json);
					$value['seller_name'] = SellerBussinessInfo::sellerBusinessInfo($value->seller_id);
					array_push($newOrders, $value);
				}

				$result = array(
					'data' => $newOrders, 
					'count' => OrdersTbl::getOrderForUserCntsCancel($loginID) 
				);

				self::printResult($result);
			}
			else {
				self::printResult($isAuth);
			}
		}



		public function single($token, $orderNumber){
			$isAuth = HeadersControl::user($token);
			if (isset($isAuth['loginID']) && is_numeric($isAuth['loginID'])) {
				$loginID = $isAuth['loginID'];				

				$info = OrdersTbl::singleOrderDetails($orderNumber, $loginID);
				$info['allshippingFee'] = Invoices::sumShippingCost($info->order_number);
				$orders = OrdersTbl::singleOrders($orderNumber, $loginID);
				$ordersNews = array();
				foreach ($orders as $value) {
					$value['product_json'] = json_decode($value['product_json']);
					$value['variation'] = json_decode($value['variation']);
					$value['orderInfo'] = Invoices::singleOrder($value->order_id);
					array_push($ordersNews, $value);
				}
					
				$result = array(
					'orders' => $orders, 
					'countOrders' => count($orders), 
					'order' => $info, 
					'shipping_addr' => json_decode($info['shipping_addr']), 
					'variation' => json_decode($info['variation']), 
				);	

				self::printResult($result);
			}
			else {
				self::printResult($isAuth);
			}
		}


		public function cancelOrder($token, $orderNumber){
			$isAuth = HeadersControl::user($token);
			if (isset($isAuth['loginID']) && is_numeric($isAuth['loginID'])) {
				$loginID = $isAuth['loginID'];		

				$cancel = OrdersTbl::cancelMyOrder($orderNumber);	
				
				$info = self::single($token, $orderNumber);

				self::printResult(Helper::actionResponse(null, null, $info));
			}
			else {
				self::printResult($isAuth);
			}
		}


		public function trackOrder($token, $orderID, $orderNum){
			$isAuth = HeadersControl::user($token);
			if (isset($isAuth['loginID']) && is_numeric($isAuth['loginID'])) {
				$loginID = $isAuth['loginID'];		

				$check = OrderTrackingTbl::getOrder($orderID, $orderNum);

				self::printResult(Helper::actionResponse(null, $check));
			}
			else {
				self::printResult($isAuth);
			}
		}

	}

?>