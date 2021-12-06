<?php
	/**
	 * this class is the default controller of our application,
	 * 
	*/ 
	class seller_manager extends controller{
		public function __construct(){
			$this->middleware('administrator')->mustbe_loggedin();
		}

		public function index($role = null){
			if ($role) {
				$allSellers = Seller::where('status', ucwords($role))->orderBy('seller_id', 'DESC')->get();
			} else {
				$allSellers = Seller::orderBy('seller_id', 'DESC')->get();
			}
			$this->view('administrator/seller-list', [
				'sellers' => $allSellers,
				'role' => $role
			]);
		}


		public function details($sellerID){
			$getSeller = Seller::singleSeller($sellerID);

			// print_r($getSeller);
			// exit();

			if ($getSeller && $getSeller->seller_id == $sellerID) {
				$this->view("administrator/seller-details", [
					'seller' => $getSeller,
					'bus_info' => SellerBussinessInfo::singleBySellerID($sellerID),
					'bank_info' => SellerBankInfo::singleBySellerID($sellerID),
					'allProducts' => Products::productBySeller($sellerID),
					'countries' => Countries::getAll()
				]);
			}
		}



		public function update_seller_profile(){
			$sellerID = Input::get('sellerID');
			$first_name = Input::get('first_name');
			$last_name = Input::get('last_name');
			$email = Input::get('email');
			$phone = Input::get('phone');
			$date_of_birth = Input::get('date_of_birth');
			$photo = Input::get('default_photo');
			if ($_FILES['photo']['name']) {
				$photo = Images::profileImgUpload($_FILES['photo'], 'users/', $first_name);
			} 

			$gonow = Seller::where('seller_id', $sellerID)->update([
				'first_name' 	=> $first_name, 
				'last_name' 	=> $last_name, 
				'email' 		=> $email, 
				'phone' 		=> $phone, 
				'date_of_birth' 		=> $date_of_birth, 
				'photo' 		=> $photo, 
			]);

			if ($gonow) {
				Redirect::to(Config::ADMIN_BASE_URL().'seller_manager/details/'.$sellerID.'?update=success');
			} else {
				Redirect::to(Config::ADMIN_BASE_URL().'seller_manager/details/'.$sellerID.'?update=failed');
			}
		}



		public function update_bank_info(){
			$sellerID = Input::get('sellerID');
			$account_name = Input::get('account_name');
			$account_number = Input::get('account_number');
			$bank_name = Input::get('bank_name');
			$account_type = Input::get('account_type');

			$gonow = SellerBankInfo::where('seller_id', $sellerID)->update([
				'account_name' 	=> $account_name, 
				'account_number' 	=> $account_number, 
				'bank_name' 		=> $bank_name, 
				'account_type' 		=> $account_type, 
			]);

			if ($gonow) {
				Redirect::to(Config::ADMIN_BASE_URL().'seller_manager/details/'.$sellerID.'?bank=success');
			} else {
				Redirect::to(Config::ADMIN_BASE_URL().'seller_manager/details/'.$sellerID.'?bank=failed');
			}
		}



		public function update_business_info(){
			$sellerID = Input::get("sellerID");
			$id = Input::get("busID");
			$biz_name = Input::get("biz_name");
			$biz_type = Input::get("biz_type");
			$biz_address = Input::get("biz_address");
			$alternative_address = Input::get("alternative_address");
			$country = Input::get("country");
			$zip_code = Input::get("zip_code");
			$city = Input::get("city");
			$biz_reg_number = Input::get("biz_reg_number");

			$biz_certificate = Input::get("defcartificate");
			if ($_FILES['biz_certificate']['name']) {
				$options = array(
					'folder' => 'biz_certificate/', 
					'name'   => $sellerID.'-'.$biz_name
				);
	        	$biz_certificate = Images::fileUpload($_FILES['biz_certificate'], $options)['original'];
			}

			$send = array(
				'biz_name' => $biz_name,
		        'biz_type' => $biz_type,
		        'biz_type' => $biz_type,
		        'biz_address' => $biz_address,    
		        'alternative_address' => $alternative_address,    
		        'country' => $country,    
		        'zip_code' => $zip_code,    
		        'city' => $city,  
		        'biz_reg_number' => $biz_reg_number,  
		        'biz_certificate' => $biz_certificate
		    );

		    // $update = SellerBussinessInfo::updateRecord($sellerID, $send);

			$update = SellerBussinessInfo::where('seller_id', $sellerID)->update([
		        'biz_name' => $biz_name,
		        'biz_type' => $biz_type,
		        'biz_type' => $biz_type,
		        'biz_address' => $biz_address,    
		        'alternative_address' => $alternative_address,    
		        'country' => $country,    
		        'zip_code' => $zip_code,    
		        'city' => $city,  
		        'biz_reg_number' => $biz_reg_number,  
		        'biz_certificate' => $biz_certificate
			]);
			if ($update) {
				Redirect::to(Config::ADMIN_BASE_URL().'seller_manager/details/'.$sellerID.'?business-info=success');
			} else {
				Redirect::to(Config::ADMIN_BASE_URL().'seller_manager/details/'.$sellerID.'?business-info=failed');
			}
		}


		


		public function set_action(){
			$theRole = Input::get("theRole");
			$sellerID = Input::get("sellerID");

			// echo $theRole;
			// echo $sellerID;
			// exit();

			if ($theRole == "Delete") {
				$del = Seller::where('seller_id', $sellerID)->delete();
				if ($del) {
					Redirect::to(Config::ADMIN_BASE_URL().'seller_manager/?delete=success');
				}
			} else {
				$update = Seller::where('seller_id', $sellerID)->update([
					'status' => $theRole
				]);
				if ($update) {
					Redirect::to(Config::ADMIN_BASE_URL().'seller_manager/details/'.$sellerID.'?action='.strtolower($theRole));
				}
			}
		}


		public function approve_product(){
			$pid = Input::get("pid");
			$sellerID = Input::get("sellerID");

			$delete = Products::where('pid', $pid)->update([
				'status' => 'Active'
			]);
			if ($delete) {
				Redirect::to(Config::ADMIN_BASE_URL().'seller_manager/details/'.$sellerID.'?approve=success');
			}
		}

		public function deleteProduct(){
			$pid = Input::get("pid");
			$sellerID = Input::get("sellerID");

			$delete = Products::where('pid', $pid)->delete();
			if ($delete) {
				Redirect::to(Config::ADMIN_BASE_URL().'seller_manager/details/'.$sellerID.'?delete=success');
			}
		}



	}

?>