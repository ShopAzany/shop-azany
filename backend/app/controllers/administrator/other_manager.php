<?php
	/** 
	 * this class is the default controller of our application,
	 * 
	*/
	class other_manager extends controller{
		public function __construct(){
			$this->middleware('administrator')->mustbe_loggedin();
		}

		

		public function bank(){
			print_r($result);
			$this->view('administrator/admin-bank', [
				'banks' => Admin_bank::orderBy('id', "DESC")->get(),
			]);
		}


		public function add_bank(){
			$currency = Input::get("currency");
			$account_name = Input::get("account_name");
			$account_number = Input::get("account_number");
			$bank = Input::get("bank");
			$account_type = Input::get("account_type");

			$addBank = Admin_bank::create([
				'currency' => $currency,
				'account_name' => $account_name,
				'account_number' => $account_number,
				'bank' => $bank,
				'account_type' => $account_type
			]);
			if ($addBank) {
				Redirect::to(Config::ADMIN_BASE_URL().'other_manager/bank?add=success');
			}
		}


		public function delete_bank(){
			$bankID = Input::get("bankID");
			$del = Admin_bank::where('id', $bankID)->delete();
			if ($del) {
				Redirect::to(Config::ADMIN_BASE_URL().'other_manager/bank?delete=success');
			}
		}


		public function get_bank($bankID){
			$bankInfo = Admin_bank::where('id', $bankID)->first();

			if ($bankInfo) {
				echo '
					<input type="hidden" name="id" value="'.$bankInfo->id.'">
					<div class="form-group">
			            <label class="pull-left">Select Currency</label>
			            <input type="text" name="currency" class="form-control" value="'.$bankInfo->currency.'">
			        </div>

			        <div class="form-group">
			            <label class="pull-left">Account Name</label>
			            <input type="text" name="account_name" class="form-control" value="'.$bankInfo->account_name.'">
			        </div>

			        <div class="form-group">
			            <label class="pull-left">Account Number</label>
			            <input type="text" name="account_number" class="form-control" value="'.$bankInfo->account_number.'">
			        </div>

			        <div class="form-group">
			            <label class="pull-left">Bank Name</label>
			            <input type="text" name="bank" class="form-control" value="'.$bankInfo->bank.'">
			        </div>

			        <div class="form-group">
			            <label class="pull-left">Account Type</label>
			            <input type="text" name="account_type" class="form-control" value="'.$bankInfo->account_type.'">
			        </div>
				';
			} else {
				echo 0;
			}
			exit();
		}


		public function update_bank(){
			$id = Input::get("id");
			$currency = Input::get("currency");
			$account_name = Input::get("account_name");
			$account_number = Input::get("account_number");
			$bank = Input::get("bank");
			$account_type = Input::get("account_type");

			$addBank = Admin_bank::where('id', $id)->update([
				'currency' => $currency,
				'account_name' => $account_name,
				'account_number' => $account_number,
				'bank' => $bank,
				'account_type' => $account_type
			]);
			if ($addBank) {
				Redirect::to(Config::ADMIN_BASE_URL().'other_manager/bank?update=success');
			}
		}




		// PAYMENT METHOD
		public function payment_gateway(){
			$this->view('administrator/payment-gateway', [
				'getPayMethod' => PaymentMethod::get()
			]);
		}


		public function add_pay_method(){
			$name = Input::get('name');
			$type = Input::get('type');
			$gateway = Input::get('gateway');
			$mer_id = Input::get('mer_id');
			$mer_code = Input::get('mer_code');
			$bearer = Input::get('bearer');
			$descr = Input::get('descr');

			$options = array(
	            'folder' => 'pay_gateway/',
	            'name'  => $name,
	        );
	        $url = Images::fileUpload($_FILES['gate_icon'], $options)['original'];

	        $create = PaymentMethod::create([
	            'name' => $name,
	        	'type' => $type,
	            'gateway' => $gateway,
	            'mer_id' => $mer_id,
	            'mer_code' => $mer_code,
	            'bearer' => $bearer,
	            'descr' => $descr,
	            'url' => $url
	        ]);
	        if ($create) {
				Redirect::to(Config::ADMIN_BASE_URL().'other_manager/payment_gateway?add=success');
			} else {
				Redirect::to(Config::ADMIN_BASE_URL().'other_manager/payment_gateway?add=failed');
			}
		}


		public function pay_method_action(){
			$payID = Input::get('payID');
			$pay_role = Input::get('pay_role');

			if ($pay_role == 'disable') {
				$action = 0;
			} else if($pay_role == 'activate') {
				$action = 1;
			}

			$update = PaymentMethod::where('id', $payID)->update([
				'status' => $action
			]);
			if ($update) {
				Redirect::to(Config::ADMIN_BASE_URL().'other_manager/payment_gateway?update=success');
			} else {
				Redirect::to(Config::ADMIN_BASE_URL().'other_manager/payment_gateway?update=failed');
			}
		}



		public function delete_pay_method(){
			$payID = Input::get('payID');

			$delete = PaymentMethod::where('id', $payID)->delete();
			if ($delete) {
				Redirect::to(Config::ADMIN_BASE_URL().'other_manager/payment_gateway?delete=success');
			} else {
				Redirect::to(Config::ADMIN_BASE_URL().'other_manager/payment_gateway?delete=failed');
			}
		}


		public function edit_payment_gateway($id){
			$get = PaymentMethod::singleRow($id);

			if ($get) {
				$this->view('administrator/payment-gateway-edit', [
					'method' => $get
				]);
			}
		}

		public function update_pay_method(){
			$id = Input::get('id');
			$name = Input::get('name');
			$type = Input::get('type');
			$gateway = Input::get('gateway');
			$mer_id = Input::get('mer_id');
			$mer_code = Input::get('mer_code');
			$bearer = Input::get('bearer');
			$descr = Input::get('descr');

			$url = Input::get('defGateIcon');
			$options = array(
	            'folder' => 'pay_gateway/',
	            'name'  => $name,
	        );
	        if ($_FILES['gate_icon']['name']) {
	        	$url = Images::fileUpload($_FILES['gate_icon'], $options)['original'];
	        }


	        $create = PaymentMethod::where('id', $id)->update([
	            'name' => $name,
	        	'type' => $type,
	            'gateway' => $gateway,
	            'mer_id' => $mer_id,
	            'mer_code' => $mer_code,
	            'bearer' => $bearer,
	            'descr' => $descr,
	            'url' => $url
	        ]);
	        if ($create) {
				Redirect::to(Config::ADMIN_BASE_URL().'other_manager/edit_payment_gateway/'.$id.'?add=success');
			} else {
				Redirect::to(Config::ADMIN_BASE_URL().'other_manager/edit_payment_gateway/'.$id.'?add=failed');
			}
		}




		// SHIPPING METHOD
		public function shipping_method(){
			$this->view('administrator/shipping-method', [
				'getShipMethod' => ShippingMethods::get(),
				'curr' => CurrencyTbl::getDefault(),
				'countries' => Countries::getAll()
			]);
		}



		public function add_shipping_method(){
			$name = Input::get('name');
			$price = Input::get('price');
			$description = Input::get('description');
			$country = Input::get('country');

			$newCountry = '';

			foreach ($country as $coun) {
				$newCountry .= $coun.', ';
			}

			$options = array(
	            'folder' => 'shipping_method/',
	            'name'  => $name,
	        );
	        $url = Images::fileUpload($_FILES['courierLogo'], $options)['original'];

	        $create = ShippingMethods::create([
	            'name' => $name,
	            'country' => $newCountry,
	        	'price' => $price,
	            'description' => $description,
	            'url' => $url
	        ]);
	        if ($create) {
				Redirect::to(Config::ADMIN_BASE_URL().'other_manager/shipping_method?add=success');
			} else {
				Redirect::to(Config::ADMIN_BASE_URL().'other_manager/shipping_method?add=failed');
			}
		}

		public function delete_shipping_method(){
			$payID = Input::get('payID');

			$delete = ShippingMethods::where('id', $payID)->delete();
			if ($delete) {
				Redirect::to(Config::ADMIN_BASE_URL().'other_manager/shipping_method?delete=success');
			} else {
				Redirect::to(Config::ADMIN_BASE_URL().'other_manager/shipping_method?delete=failed');
			}
		}


		public function edit_shipping_method($id){
			$get = ShippingMethods::singleRow($id);

			if ($get) {
				$this->view('administrator/shipping-method-edit', [
					'method' => $get,
					'countries' => Countries::getAll()
				]);
			}
		} 


		public function update_shipping_method(){
			$id = Input::get('id');
			$name = Input::get('name');
			$price = Input::get('price');
			$description = Input::get('description');

			$url = Input::get('defcourierLogo');
			$options = array(
	            'folder' => 'pay_gateway/',
	            'name'  => $name,
	        );
	        if ($_FILES['courierLogo']['name']) {
	        	$url = Images::fileUpload($_FILES['courierLogo'], $options)['original'];
	        }

	        $country = Input::get('country');
			$newCountry = '';
			foreach ($country as $coun) {
				$newCountry .= $coun.', ';
			}


	        $create = ShippingMethods::where('id', $id)->update([
	            'name' => $name,
	        	'price' => $price,
	        	'country' => $newCountry,
	            'description' => $description,
	            'url' => $url
	        ]);
	        if ($create) {
				Redirect::to(Config::ADMIN_BASE_URL().'other_manager/edit_shipping_method/'.$id.'?update=success');
			} else {
				Redirect::to(Config::ADMIN_BASE_URL().'other_manager/edit_shipping_method/'.$id.'?update=failed');
			}
		}

		



	}

?>