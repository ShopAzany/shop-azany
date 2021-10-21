<?php
	/**
	 * this class is the default controller of our application,
	 * 
	*/ 
	class customer_manager extends controller{
		public function __construct(){
			$this->middleware('administrator')->mustbe_loggedin();
		}

		public function index($role = null){
			if ($role) {
				$allUsers = User::where('status', ucwords($role))->orderBy('login_id', 'DESC')->get();
			} else {
				$allUsers = User::orderBy('login_id', 'DESC')->get();
			}
			$this->view('administrator/customers', [
				'users' => $allUsers,
				'role' => $role
			]);
		}


		public function details($loginID, $page=1){
			$getCus = User::singleUser($loginID);

			$count = OrdersTbl::allOrderCounts();
			$pageLimit = 20;
			$offset = $pageLimit * ($page - 1);
			$linkLimit = 5;

			$orders = OrdersTbl::getOrdersForUser($pageLimit, $offset, $loginID);	
			$newOrders = array();
			foreach ($orders as $value) {
				$value['product_json'] = json_decode($value->product_json);
				$value['seller_name'] = SellerBussinessInfo::sellerBusinessInfo($value->seller_id);
				array_push($newOrders, $value);
			}

			// echo "<pre>";
			// print_r($newOrders);
			// exit();


			if ($getCus && $getCus->login_id == $loginID) {
				$this->view("administrator/customers-details", [
					'user' => $getCus,
					'addresses' => UserAddresses::addresses($loginID),
					'orders' => $newOrders
				]);
			}
		}



		public function update_user_profile(){
			$loginID = Input::get('loginID');
			$full_name = Input::get('full_name');
			$email = Input::get('email');
			$phone = Input::get('phone');
			$gender = Input::get('gender');
			$photo = Input::get('default_photo');
			if ($_FILES['photo']['name']) {
				$photo = Images::profileImgUpload($_FILES['photo'], 'users/', $full_name);
			} 

			$gonow = User::where('login_id', $loginID)->update([
				'full_name' 	=> $full_name, 
				'email' 		=> $email, 
				'phone' 		=> $phone, 
				'gender' 		=> $gender, 
				'photo' 		=> $photo, 
			]);

			if ($gonow) {
				Redirect::to(Config::ADMIN_BASE_URL().'customer_manager/details/'.$loginID.'?update=success');
			} else {
				Redirect::to(Config::ADMIN_BASE_URL().'customer_manager/details/'.$loginID.'?update=failed');
			}
		}



		public function get_user_address($addID) {
			$addInfo = UserAddresses::single($addID);
			$countries = Countries::getAll();

			$options = '';
			foreach ($countries as $country) {
				if ($addInfo->country == $country) {
					$options .= '<option selected value="'.$country.'">'.$country.'</option>';
				} else {
					$options .= '<option '.$opt.' value="'.$country.'">'.$country.'</option>';
				}
				
			}

			if ($addInfo) {
				echo '
					<input type="hidden" name="addrID" value="'.$addInfo->id.'">
					<div class="row">
						<div class="col-xl-6">
						  <div class="form-group">
						    <label>Address</label>
						    <input type="text" name="street_addr" value="'.$addInfo->street_addr.'" class="form-control">
						  </div>
						</div>
						<div class="col-xl-6">
						  <div class="form-group">
						    <label>City</label>
						    <input type="text" name="city" value="'.$addInfo->city.'" class="form-control">
						  </div>
						</div>
						<div class="col-xl-6">
						  <div class="form-group">
						    <label>State</label>
						    <input type="text" name="state" value="'.$addInfo->state.'" class="form-control">
						  </div>
						</div>
						<div class="col-xl-6">
						  <div class="form-group">
						    <label>Country</label>
						    <select class="form-control custom-select" name="country">
						    	'.$options.'
						    </select>
						  </div>
						</div>
						
					</div>
				';
			} else {
				echo 0;
			}
			exit();
		}



		public function update_user_address(){
			$loginID = Input::get("loginID");
			$id = Input::get("addrID");
			$street_addr = Input::get("street_addr");
			$city = Input::get("city");
			$state = Input::get("state");
			$country = Input::get("country");

			$update = UserAddresses::where('id', $id)->update([
				'street_addr' => $street_addr,
				'city' => $city,
				'state' => $state,
				'country' => $country,
			]);
			if ($update) {
				Redirect::to(Config::ADMIN_BASE_URL().'customer_manager/details/'.$loginID.'?address=success');
			}
		}


		public function set_default_address(){
			$addrID = Input::get("addID");
			$loginID = Input::get("loginID");

			$set = UserAddresses::setDefult($addrID, $loginID);
			if ($set) {
				Redirect::to(Config::ADMIN_BASE_URL().'customer_manager/details/'.$loginID.'?default-address=success');
			}
		}


		public function set_action(){
			$theRole = Input::get("theRole");
			$loginID = Input::get("loginID");

			if ($theRole == "Delete") {
				$del = User::where('login_id', $loginID)->delete();
				if ($del) {
					Redirect::to(Config::ADMIN_BASE_URL().'customer_manager/?delete=success');
				}
			} else {
				$update = User::where('login_id', $loginID)->update([
					'status' => $theRole
				]);
				if ($update) {
					Redirect::to(Config::ADMIN_BASE_URL().'customer_manager/details/'.$loginID.'?action='.strtolower($theRole));
				}
			}
		}




	}

?>