<?php
	/** 
	 * this class is the default controller of our application,
	 * 
	*/
	class order_manager extends controller{
		public function __construct(){
			$this->middleware('administrator')->mustbe_loggedin();
		}
		

		public function index($page = 1){			
			$count = OrdersTbl::allOrderCounts();
			$pageLimit = 50;
			$offset = $pageLimit * ($page - 1);
			$linkLimit = 5;

			$orders = OrdersTbl::allOrders($pageLimit, $offset);
			// echo "<pre>";
			// print_r($orders);
			// exit();	
			$newOrders = array();
			foreach ($orders as $value) {
				$product = json_decode($value->product_json);
				$img = explode(',' , $product->images);
				$value['image'] = $product->featured_img;
				$value['name'] = $product->name;
				$value['countPro'] = OrdersTbl::where('order_number', $value->order_number)->count();
				// $value['sumTotal'] = OrdersTbl::where('order_number', $value->order_number)->sum('total');
				array_push($newOrders, $value);
			}

			$curr = CurrencyTbl::getDefault();

			$this->view('administrator/orders', [
				'allOrders' => $newOrders,
				'curr' => $curr,
				'pageLinks' => CusPagination::pagination_links($pageLimit, $count, $page, $linkLimit)['links'],
				'currPage' => $page,
				'totalLink' => CusPagination::pagination_links($pageLimit, $count, $page, $linkLimit)['totalLink'],
			  	'page' => 'All'
			]);
		}




		public function order($order_num) {
			$info = OrdersTbl::singleOrderDetails_admin($order_num);
			$orders = OrdersTbl::singleOrders_admin($order_num);

			$info['sum_shipping_fee'] = Invoices::sumShippingCost($order_num);

			$ordersNews = array();
			foreach ($orders as $value) {
				$value['product_json'] = json_decode($value['product_json']);
				$value['variation'] = json_decode($value['variation']);
				array_push($ordersNews, $value);
			}

			$curr = CurrencyTbl::getDefault();
			if ($info && $info->order_number == $order_num) {
				$this->view('administrator/order-details', [
					'orders' => $ordersNews, 
					'order' => $info, 
					'shipping_addr' => json_decode($info['shipping_addr']), 
					'variation' => json_decode($info['variation']), 
					'curr' => $curr->symbol
				]);
			} else {
				Redirect::to(Config::ADMIN_BASE_URL().'order_manager');
			}
		}



		public function orders($otherPages, $page = 1){
			$count = OrdersTbl::allOrderCountsPages($otherPages);
			$pageLimit = 20;
			$offset = $pageLimit * ($page - 1);
			$linkLimit = 5;

			$orders = OrdersTbl::allOrdersPages($pageLimit, $offset, $otherPages);	
			$newOrders = array();
			foreach ($orders as $value) {
				$product = json_decode($value->product_json);
				$img = explode(',' , $product->images);
				$value['image'] = $img[0];
				$value['name'] = $product->name;
				$value['countPro'] = OrdersTbl::where('order_number', $value->order_number)->count();
				$value['sumTotal'] = OrdersTbl::where('order_number', $value->order_number)->sum('total');
				array_push($newOrders, $value);
			}

			$curr = CurrencyTbl::getDefault();

			$this->view('administrator/orders', [
				'allOrders' => $newOrders,
				'curr' => $curr,
				'pageLinks' => CusPagination::pagination_links($pageLimit, $count, $page, $linkLimit)['links'],
			  	'currPage' => $page,
			  	'totalLink' => CusPagination::pagination_links($pageLimit, $count, $page, $linkLimit)['totalLink'],
			  	'page' => $otherPages
			]);
		}


		public function update_status(){
			$orderID = Input::get("orderID");
			$action = Input::get("status");
			$role = Input::get("role");

			$single = OrdersTbl::singleOrder($orderID);

			$update = OrdersTbl::markOrder($orderID, $action, $role);
			// print_r($update);
			// exit();

			// echo "<pre>";
			// print_r($update);
			// exit();

			if ($update) {
				if ($action == 'Delivered' || $action == 'Returned') {
					$invoice = Invoices::singleOrder($single->order_id);
					if ($action == 'Delivered') {
						$status = 'Credit';
						$role = 'delivered';
					} else {
						$status = 'Debit';
						$role = 'returned';
					}

					WalletTbl::creatRow(
						$single->seller_id,  
						$invoice->total,
						$status, 
						$role,
						$single->order_id
					);
				}

				Redirect::to(Config::ADMIN_BASE_URL().'order_manager/order/'.$single->order_number.'?update=success');
			}
		}


		public function update_status_all(){
			$orderNum = Input::get("orderNum");
			$action = Input::get("status");
			$role = Input::get("role");

			$single = OrdersTbl::where('order_number', $orderNum)->first();

			$orders = OrdersTbl::where('order_number', $orderNum)->get();
			$isUpdate = null;				
			foreach ($orders as $order) {
				$info = OrdersTbl::markOrder($order->order_id, $action, $role);
				$isUpdate = $info ?: $isUpdate;

				if ($action == 'Delivered' || $action == 'Returned') {
					$invoice = Invoices::singleOrder($single->order_id);
					if ($action == 'Delivered') {
						$status = 'Credit';
						$role = 'delivered';
					} else {
						$status = 'Debit';
						$role = 'returned';
					}

					WalletTbl::creatRow(
						$single->seller_id,  
						$invoice->total,
						$status, 
						$role,
						$single->order_id
					);
				}
			}



			Redirect::to(Config::ADMIN_BASE_URL().'order_manager/order/'.$single->order_number.'?all_update=success');
		}






		public function generateInvoice($orderID, $orderNumber=null) {
			$orderInfo = OrdersTbl::generateInvoiceOrder($orderID);
			$orders = OrdersTbl::generateInvoiceOrders($orderNumber, $orderInfo->login_id);

			$invoice = null;
			if (!empty($orderInfo)) {
				$invoice = Helper::invoice($orderInfo, $orders);
			}

			$result = array(
				'status' => $invoice ? 'success' : 'failed', 
				'data' => $invoice
			);

			if ($result['status'] == 'success') {
				Redirect::to($result['data']);
			} else {
				Redirect::to(Config::ADMIN_BASE_URL().'order_manager/order/'.$orderID.'?status=error');
			}
		}


		public function generateSingleInvoice($orderID, $orderNumber=null) {

			$orderInfo = OrdersTbl::generateInvoiceOrder($orderID);
			$orders = OrdersTbl::generateInvoiceOrdersSingle($orderID, $orderInfo->login_id);
			
			$invoice = null;
			if (!empty($orderInfo)) {
				$invoice = Helper::invoice($orderInfo, $orders);
			}

			// print_r($invoice);
			// exit();

			$result = array(
				'status' => $invoice ? 'success' : 'failed', 
				'data' => $invoice
			);

			

			if ($result['status'] == 'success') {
				Redirect::to($result['data']);
			} else {
				Redirect::to(Config::ADMIN_BASE_URL().'order_manager/order/'.$orderID.'?status=error');
			}
		}


	}

?>