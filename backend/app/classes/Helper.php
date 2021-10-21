<?php
	class Helper {
		
		public function __construct(){
		}

	    public function changePassword($loginID, $currentPass, $newPass, $confirmPass){
	    	$user = User::uSingle($loginID);

	        if(!User::verifyPass($currentPass, $user->password)){
				$result = 'Current Password does not match';
			}
			elseif($newPass != $confirmPass){
				$result = 'Password does not match';
			}
			elseif(strlen($newPass) < 6 || strlen($newPass) > 16){
				$result = 'Password is too weak, minimum of 6 characters';
			}
			else{
				$info = User::where('login_id', $loginID)->update([
					'password' => User::hashPass($newPass)
				]);

				$result = $info ? 'success' : 'failed';
			}

			return $result;
	    }

	    public function changePassword_admin($admID, $currentPass, $newPass, $confirmPass){
	    	$user = Admin::single_byID($admID);

	        if(!User::verifyPass($currentPass, $user->password)){
				$result = 'Current Password does not match';
			}
			elseif($newPass != $confirmPass){
				$result = 'Password does not match';
			}
			elseif(strlen($newPass) < 6 || strlen($newPass) > 16){
				$result = 'Password is too weak, minimum of 6 characters';
			}
			else{
				$info = Admin::where('id', $admID)->update([
					'password' => User::hashPass($newPass)
				]);

				$result = $info ? 'success' : 'failed';
			}

			return $result;
	    }

	    public function loginHandler($user=array()) {
	    	User::where('login_id', $user->login_id)->update([
		    	'last_seen' => Settings::currentTime()
		    ]);
	    	$payloadArray = array();
            $exp = Settings::addDate('90 days');
            $payloadArray['loginID'] = $user->login_id;
            $payloadArray['expAlt'] = $exp;
            if (isset($nbf)) {$payloadArray['nbf'] = strtotime(Settings::currentTime());}
            if (isset($exp)) {$payloadArray['exp'] = strtotime($exp);}

            $token = JWT::encode($payloadArray, Settings::serverKey());
            $user['token'] = $token;
            $user['exp'] = $exp;
            
            return $user;
	    }


	    public function sellerHandler($seller=array()) {
	    	Seller::where('seller_id', $seller->seller_id)->update([
		    	'last_login' => Settings::currentTime()
		    ]);
	    	$payloadArray = array();
            $exp = Settings::addDate('90 days');
            $payloadArray['sellerID'] = $seller->seller_id;
            $payloadArray['expAlt'] = $exp;
            if (isset($nbf)) {$payloadArray['nbf'] = strtotime(Settings::currentTime());}
            if (isset($exp)) {$payloadArray['exp'] = strtotime($exp);}

            $token = JWT::encode($payloadArray, Settings::serverKey());
            $seller['token'] = $token;
            $seller['exp'] = $exp;
            
            return $seller;
	    }


	    public function adminLoginHandler($admin=array()) {
		    Admin::where('id', $admin->id)->update([
		    	'last_login' 	=> Settings::currentTime(),
		    	'last_login_ip' => Visitor::getIP(),
		    ]);
		    Admin_login_activity::createRecord(null, $admin->username);
	    	$payloadArray = array();
            $exp = Settings::addDate('1 days');
            $payloadArray['adminID'] = $admin->id;
            $payloadArray['expAlt'] = $exp;
            if (isset($nbf)) {$payloadArray['nbf'] = strtotime(Settings::currentTime());}
            if (isset($exp)) {$payloadArray['exp'] = strtotime($exp);}

            $token = JWT::encode($payloadArray, Settings::serverKey());
            $admin['token'] = $token;
            $admin['exp'] = $exp;
            
            return $admin;
	    }

	    public function messagingSpamChecker($loginID, $receiverID) {
	    	$dailyInitLimit = 3;
			//Check for existing record for sender and receiver
			$existing = Messaging::whereRaw("(sender_id=$loginID AND receiver_id=$receiverID) OR (receiver_id=$loginID AND sender_id=$receiverID)")->count();

			if ($existing > 0) {
				//Existing communication
				return false;
			}

			// Now check the message initiated in past 24hr
			$countNewInit = Messaging::whereRaw("sender_id=$loginID AND NOT (receiver_id=$receiverID OR sender_id=$receiverID) AND created_at > DATE_SUB(NOW(), INTERVAL 24 HOUR)")->count();

			//
			if($countNewInit >= $dailyInitLimit) {
				return true;
			} 
			else {
				// Initiate communication
				return false;
			}
	    }

	    public function quoteSpamChecker($loginID) {
	    	$dailyInitLimit = 3;			

			// Check the quotes sent in past 24hr
			$countNewInit = Offers::whereRaw("offer_from=$loginID AND created_at > DATE_SUB(NOW(), INTERVAL 24 HOUR)")->count();

			//
			if($countNewInit >= $dailyInitLimit) {
				return true;
			} 
			else {
				// send quote
				return false;
			}
	    }

	    public function spamResponse() {
			return 'Spam';
	    }

	    public function actionResponse($value, $return=null, $error=null) {
	    	if (!$return && is_array($value)){
	    		return $value;
	    	}
	    	else if($return && !$error){
	    		return array(
	    			'status' => 'success',
	    			'data' => $return
	    		);
	    	}else if($error){
	    		return array(
	    			'status' => 'failed',
	    			'data' => $error
	    		);
	    	}
	    	
			return $value? array('status' => 'success') : array('status' => 'failed');
	    }

	    public function invoice($orderInfo=array(), $orders=array()) {
	    	//Incluse for PDF use
			include Config::ROOTPATH(). 'app/others/FPDF/phpinvoice.php';

		    //Grab single user info
		    $settings = WebsiteSettings::single();
		    $invoiceSingle = Invoices::single($orderInfo->invoice_id);
		    $shippingAddress = json_decode($orderInfo->shipping_addr);   
		    $invoiceNum = $orderInfo->order_number;
		    

		    //Items on order
		    // if (count($orders[0]) > 0 ) {
		    // 	$subtotal = Invoices::sumOrdersubTotal($orderInfo->order_number);
		    // 	$grandTotal = $orderInfo->grand_total;
		    // } else {
		    // 	$subtotal = $orderInfo->sub_total;
		    // 	$orders = array($orderInfo);
		    // 	$grandTotal = $orderInfo->sub_total + $shippingCost;
		    // }	

		    // return count($orders);	

		    if (count($orders) > 1) {
		    	$subtotal = $orderInfo->total;
	    		$shippingCost = Invoices::sumShippingCost($orderInfo->order_number);
	    		$grandTotal = $orderInfo->grand_total;
		    } elseif(count($orders) < 2) {
		    	$subtotal = $orderInfo->sub_total;
		    	$shippingCost = $orderInfo->shipping_cost;
	    		$grandTotal = $orderInfo->sub_total + $shippingCost;
		    }


		    //logo URL
			// if ($settings->logo_url) {
			if (@getimagesize($settings->logo_url)) {
				$logoURL = $settings->logo_url;
			} else {
				$logoURL = 'https://oziconnect.com/assets/images/logo.png';
			}

		    //Biz Name
		    if(isset($settings->biz_name) AND $settings->biz_name != ''){ 
		        $bizName = $settings->biz_name;
		    } elseif(isset($settings->site_name) AND $settings->site_name != ''){
		        $bizName = $settings->site_name;
		    } else { $bizName = 'My Company Name Here'; }


		    //Biz Address
		    if(isset($settings->biz_addr) AND $settings->biz_addr != ''){ 
		        $bizAddr = $settings->biz_addr;
		    }else{ $bizAddr = '12, Olaiwaye Street,'; }

		    //Biz City
		    if(isset($settings->biz_city) AND $settings->biz_city != ''){ 
		        $bizCity = $settings->biz_city;
		    } else { $bizCity = 'Ikeja'; }

		    //Biz State
		    if(isset($settings->biz_state) AND $settings->biz_state != ''){ 
		        $bizState = $settings->biz_state;
		    } else { $bizState = 'Lagos'; } 

		    //Biz Country
		    if(isset($settings->biz_country) AND $settings->biz_country != ''){ 
		        $bizCountry = $settings->biz_country;
		    } else{ $bizCountry = 'Nigeria'; };

		    //invoice status
		    if($invoiceSingle->status == 'Paid'){ 
		        $invoiceStatus = 'Paid';
		        $setColour = "#009966";
		    } else if($invoiceSingle->status == 'Pending'){
		        $invoiceStatus = 'Unpaid';
		        $setColour = "#AA3939";
		    } else {
		        $invoiceStatus = $invoiceSingle->status;
		        $setColour = "#666666";
		    }

		    // return $invoiceStatus;
		    
		    $invoice = new phpinvoice();
		    /* Header Settings */
		    $invoice->setLogo($logoURL);
		    $invoice->setColor($setColour);
		    $invoice->setType("Customer Invoice");
		    $invoice->setReference($invoiceNum);
		    $invoice->setDate(strftime("%B %d, %Y", strtotime($invoiceSingle->created_at)));
		    $invoice->setTime($invoiceStatus);
		    $invoice->setDue(0);
		    
		    //Seller Info
		    $invoice->setFrom(array($bizName, $bizAddr, $bizCity.", ".$bizState, $bizCountry, ''));

		    //Buyer Info
		    $invoice->setTo(
		    	array($shippingAddress->full_name,
		        $shippingAddress->street_addr, 
		        $shippingAddress->city.', '.$shippingAddress->state.' '.$shippingAddress->zip, $shippingAddress->country, "")
		    );
		    //$invoice->flipflop();

		    /* Adding Items in table */
		    if(!empty($orders)){
		        foreach ($orders as $item) {
		        	$product_json = json_decode($item->product_json);
		        	$variation = json_decode($item->variation);
		        	$variationVal = '';
		        	if ($variation->name AND $variation->name != 'none') {
		        		$variationVal = $variation->name . ': '.$variation->value;
		        	}
		            $invoice->addItem(
		            	substr($product_json->name, 0, 47), 
		            	$variationVal, 
		                $item->quantity,
		                false, 
		                $item->product_price, 
		                false, //$item->shipping_cost, 
		                $item->sub_total
		            );
		        }
		    }
		    //calculate vat
		    // $vat = (5 * ($subtotal + $shippingCost)) / 100;
		    /* Add totals */
		    $invoice->addTotal("Subtotal", $subtotal);
		    // $invoice->addTotal("VAT 5%", $vat);
		    $invoice->addTotal("Shipping", $shippingCost);
		    $invoice->addTotal("Grand Total", $grandTotal, true);
		    
		    /* Set badge */ 
		    if($invoiceSingle->status == 'Paid'){
		        $invoice->addBadge("Paid Invoice");
		    } else if($invoiceSingle->status == 'Pending'){
		    	$invoice->addBadge("Unpaid Invoice");
		    } else{
		        $invoice->addBadge($invoiceSingle->status);
		    }
		    
		    
		    /* Add title */
		    //$invoice->addTitle("Important Notice");
		    
		    /* Add Paragraph */
		    /*$invoice->addParagraph("No item will be replaced or refunded if you don't have the invoice with you. You can refund within 2 days of purchase.");*/
		    
		    /* Set footer note */
		    $invoice->setFooternote($bizName);

		    $urlFinal = 'invoice-'.$invoiceNum.'-'.Settings::randomStrgs(12).'.pdf';

		    $newPath = Config::uploadPATH().'invoice';
		    if (!file_exists($newPath)) {
		    	mkdir(Config::uploadPATH().'invoice');
		    }
		    if (file_exists($newPath)) {
		    	$urlFinal = 'invoice/'.$urlFinal;
		    }

		    /* Render */
		    $invoice->render(Config::uploadPATH().$urlFinal,'F'); /* I => Display on browser, D => Force Download, F => local path save, S => return document path */

		    return Config::uploadURL().$urlFinal;
	    }

	}
?>