<?php
	class checkout extends controller {
		private $pageLimit = 10;	

		public function __construct(){
		}

		public function index($token){
			// $isAuth = HeadersControl::user($token);
			// $ids = [3, 4, 5];
			// $result = UserShoppingCart::checkoutSelectedItem($ids);
			// self::printResult($result);

			$isAuth = HeadersControl::user($token);
			if (isset($isAuth['loginID']) && is_numeric($isAuth['loginID'])) {
				$loginID = $isAuth['loginID'];

				$postdata = file_get_contents("php://input");
				$ids = json_decode($postdata);

				// self::printResult($ids);

				$checkoutOptions = array(
					'userAddress' => UserAddresses::defaultAddress($loginID),
					'selectedItems' => UserShoppingCart::checkoutSelectedItem($ids),
					'paymentMethods' => PaymentMethod::getRecords(),
					'orderNumber' => Settings::orderNum(),					
					'payStackKey' => Paystack::$key,
					'payStackBearer' => Paystack::$bearer
				);

				self::printResult($checkoutOptions);
			}
			else {
				self::printResult($isAuth);
			}
		}

		public function place_order($token, $ref=null) {
			$isAuth = HeadersControl::user($token);
			if (isset($isAuth['loginID']) && is_numeric($isAuth['loginID'])) {
				$loginID = $isAuth['loginID'];
				$userInfo = User::where('login_id', $loginID)->first();

				$postdata = file_get_contents("php://input");
				$request = json_decode($postdata);
				$address = json_decode($request->address);
				// $shipMethod = json_decode($request->shipMethod);
				$cartIDs = json_decode($request->cartIDs);
				$payMethod = $request->payMethod;

				$orderNumber = Settings::orderNum();
				$verify = self::verifyPayment($ref);

				$items = UserShoppingCart::checkoutSelectedItem($cartIDs);
				
				// self::printResult($items);
				// $items = UserShoppingCart::getCart($cartID, $loginID);
				$total = $items['sum'];
				$items = $items['items'];

				$shippingTotal = 0;
				// $itemProducts = array();
				foreach ($items as $item) {
					$product = Products::singleProduct($item->pid);
					$shippingTotal += $product->shipping_fee * $item->quantity;
					// array_push($itemProducts, $item);
				}

				foreach ($items as  $key =>  $item) {
					$orderNumber = $verify ? $ref : $orderNumber;
					$product = Products::singleProduct($item->pid);
					$variation = json_encode($item->variation);
					$orderData = array(
						'sellerID' => $product->seller_id, 
						'pid' => $item->pid, 
						'orderNumber' => $orderNumber, 
						'shippingAddr' => json_encode($address), 
						'shippingMethod' => json_encode($shipMethod), 
						'note' => '', 
						'variation' => ($variation != null || null != 'null' || $variation != '[]') ? $variation : null, 
						'productData' => json_encode($product), 
					);
					
					$order = OrdersTbl::createOrder($loginID,  $orderData);

					/**
					 * Create invoice record
					 * and remove items from shopping cart 
					 * once order is successfully created
					 */

					if ($order) {
					    OrderTrackingTbl::createRow($order->order_id);

						$eachShippingCost = $product->shipping_fee * $item->quantity;
						$invoiceData = array(
							'orderNumber' => $orderNumber,
							'order_id' => $order->order_id,
							'productPrice' => $item->sales_price,
							'qty' => $item->quantity,
							'subTotal' => $item->sales_price * $item->quantity, 
							'total' => $total,
							'shippingCost' => $eachShippingCost,
							'grandTotal' => $total + $shippingTotal, 
							'pMethod' => $payMethod 
						);

						$invoice = Invoices::insertInvoice($loginID, $invoiceData);

						if ($verify AND $invoice->id) {
							Invoices::markPaid($invoice->id, $payMethod);
						}
						UserShoppingCart::removeItemByID($item->id);
	                   	
	                   	OrdersTbl::removeProFromQuantity($order->order_id);
					}
				}

				$emailTemp = Email_templates::getById(6);
				$replace = str_replace('{FULL_NAME}', $userInfo->full_name, $emailTemp->content);

				$success = array(
					'status' => 'success',
					'data' => $orderNumber,
					'payMethod' => $payMethod,
					'products' => $items,
					'bankInfo' => Admin_bank::get(),
					'thankYouMsg' => $replace
				);
				$failed = array('status' => 'failed', 'data' => null);

				if ($invoice) {
					$inv = Invoices::where('order_number', $orderNumber)->first();
				
    				$shipCost = Invoices::sumShippingCost($inv->order_number);
                    
    				$orders = OrdersTbl::generateInvoiceOrders($inv->order_number, $loginID);
    
    				$orderInfo = array(
    					'subtotal' => $inv->total,
    					'shipping_cost' => $shipCost,
    					'tax' => 0.0,
    					'total' => $inv->total + $shipCost,
    					'email' => $userInfo->email,
    					'full_name' => $userInfo->full_name,
    					'order_number' => $inv->order_number
    				);
    				
    
    				$rec = Products::take(3)->orderBy('pid', 'DESC')->get();
    				$recommended = array();
    				foreach ($rec as $value) {
    					$value['pro_var'] = ProductVariation::firstProdID($value->pid);
    					array_push($recommended, $value);
    				}
    
    				EmailNote::orderConfirmation($orderInfo, $orders, $recommended);
				}
				self::printResult($invoice ? $success : $failed);
			}
			else {
				self::printResult($isAuth);
			}
		}

		private function verifyPayment($ref) {
			if (!$ref || $ref == 'null' || $ref == null) {
				return false;
			}
			// Validate transaction via Paystack API
		    $paymentCheck = Paystack::validate($ref);
			
 			//If the payment is valid and approved
			if(array_key_exists('data', $paymentCheck) 
				&& array_key_exists('status', $paymentCheck['data']) 
				&& ($paymentCheck['data']['status'] === 'success')) {

				return true;
			}

			return false;
		}

		private function printResult($result) {
			print_r(json_encode($result, JSON_PRETTY_PRINT));
			exit();
		}

		public function verify_coupon($token, $coupon){
			$isAuth = HeadersControl::user($token);
			if (isset($isAuth['loginID']) && is_numeric($isAuth['loginID'])) {
				$loginID = $isAuth['loginID'];

				$verifyCoupon = CouponTbl::verifyUserCoupon($loginID, $coupon);
				if (!$verifyCoupon) {
					$verifyCoupon = CouponTbl::verifyCoupon($loginID, $coupon);
				}				
				
				self::printResult(Helper::actionResponse(null, $verifyCoupon));
			}
			else {
				self::printResult($isAuth);
			}
		}
		
	}

?>