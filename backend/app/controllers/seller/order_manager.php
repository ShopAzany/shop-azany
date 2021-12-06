<?php
	class order_manager extends controller {

		private $pageLimit = 10;

		public function __construct(){
		}

		private function printResult($result) {
			print_r(json_encode($result, JSON_PRETTY_PRINT));
			exit();
		}


		public function index($token, $limit=30, $page=1){
			$isAuth = HeadersControl::seller($token);
			if (isset($isAuth['sellerID']) && is_numeric($isAuth['sellerID'])) {
				$sellerID = $isAuth['sellerID'];

				if(!$page){
					$page = 1; $offset = 0;
				}
				else{				
					$offset = $limit * ($page - 1);
				}

				$orders = OrdersTbl::getOrdersForSeller($limit, $offset, $sellerID);	
				$newOrders = array();
				foreach ($orders as $value) {
					$product = json_decode($value->product_json);
					$img = explode(',' , $product->images);
					$value['image'] = $img[0];
					$value['name'] = $product->name;
					$value['countPro'] = OrdersTbl::countProduct($sellerID, $value->order_number);
					$value['sumTotal'] = OrdersTbl::where('order_number', $value->order_number)->sum('total');
					array_push($newOrders, $value);
				}

				$result = array(
					'data' => $newOrders,
					'count' => OrdersTbl::getOrderForSellerCnts($sellerID)
				);

				self::printResult($result);
			}
			else {
				self::printResult($isAuth);
			}
		}



		public function order_details($token, $order_num){
			$isAuth = HeadersControl::seller($token);
			if (isset($isAuth['sellerID']) && is_numeric($isAuth['sellerID'])) {
				$sellerID = $isAuth['sellerID'];
				
				$info = OrdersTbl::singleOrderDetailsSeller($order_num, $sellerID);
				$orders = OrdersTbl::singleOrdersSeller($order_num, $sellerID);

				$ordersNews = array();
				foreach ($orders as $value) {
					$value['product_json'] = json_decode($value['product_json']);
					$value['variation'] = json_decode($value['variation']);
					array_push($ordersNews, $value);
				}

				$result = array(
					'data' => $ordersNews,
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



		public function update_status($token){
			$isAuth = HeadersControl::seller($token);
			if (isset($isAuth['sellerID']) && is_numeric($isAuth['sellerID'])) {
				$sellerID = $isAuth['sellerID'];
				$postdata = file_get_contents("php://input");
				$request = json_decode($postdata);
				$data = json_decode($request->data);

				$orderID = $data->orderID;
				$action = $data->action;
				$role = $data->role;

				$update = OrdersTbl::markOrder($orderID, $action, $role);

				self::printResult(Helper::actionResponse($update));
			}
			else {
				self::printResult($isAuth);
			}
		}


		public function update_status_all($token){
			$isAuth = HeadersControl::seller($token);
			if (isset($isAuth['sellerID']) && is_numeric($isAuth['sellerID'])) {
				$sellerID = $isAuth['sellerID'];
				$postdata = file_get_contents("php://input");
				$request = json_decode($postdata);
				$data = json_decode($request->data);

				$orderNum = $data->orderNum;
				$action = $data->action;
				$role = $data->role;

				$single = OrdersTbl::allOrderNumSingle($orderNum);

				$orders = OrdersTbl::allOrderNum($orderNum);

				$isUpdate = null;				
				foreach ($orders as $order) {
					$info = OrdersTbl::markOrder($order->order_id, $action, $role);
					$isUpdate = $info ?: $isUpdate;
				}

				self::printResult(Helper::actionResponse($update));
			}
			else {
				self::printResult($isAuth);
			}
		}



	}

?>