<?php
	/**
	 * this class is the default controller of our application,
	 * 
	*/ 
	class admin_manager extends controller{
		public function __construct(){
			$this->middleware('administrator')->mustbe_loggedin();
		}

		public function index(){
			$this->view('administrator/all-admins', [
				'admins' => Admin::get()
			]);
		}

		public function add(){
			$this->view('administrator/add-admin');
		}


		public function add_admin(){
			if ($_FILES['photo']['name']) {
				$photo = Images::profileImgUpload($_FILES['photo'], 'admin/', $this->admin()->username);
			} 
			$full_name = Input::get('full_name');
			$username = Input::get('username');
			$password = Input::get('password');
			$role = Input::get('role');
			$email = Input::get('email');
			$phone = Input::get('phone');
			$address = Input::get('address');
			$city = Input::get('city');
			$state = Input::get('state');
			$country = Input::get('country');
			$bio = Input::get('bio');

			$gonow = Array(
				'full_name' 	=> $full_name, 
				'username' 		=> $username, 
				'password' 		=> $password, 
				'role' 			=> $role, 
				'email' 		=> $email, 
				'phone' 		=> $phone, 
				'address' 		=> $address, 
				'city' 			=> $city, 
				'state' 		=> $state, 
				'country' 		=> $country, 
				'photo' 		=> $photo, 
				'bio' 			=> $bio, 
			);
			
			$notice = Admin::insertTable($gonow);

			if ($notice) {
				Redirect::to(Config::ADMIN_BASE_URL().'admin_manager/add?create=success');
			} else {
				Redirect::to(Config::ADMIN_BASE_URL().'admin_manager/add?create=failed');
			}
		}



		public function delete_admin(){
			$adminID = Input::get("adminID");
			$del = Admin::where('id', $adminID)->delete();
			if ($del) {
				Redirect::to(Config::ADMIN_BASE_URL().'admin_manager?delete=success');
			} else {
				Redirect::to(Config::ADMIN_BASE_URL().'admin_manager?delete=failed');
			}
		}


		public function edit_admin($id){
			$getID = Admin::where('id', $id)->first();

			if ($getID && $getID->id == $id) {
				$this->view("administrator/edit-admin", [
					'admin' => $getID
				]);
			}
		}


		public function update_admin(){
			$photo = Input::get("defImg");
			if ($_FILES['photo']['name']) {
				$photo = Images::profileImgUpload($_FILES['photo'], 'admin/', $this->admin()->username);
			} 
			$id = Input::get('adminID');
			$full_name = Input::get('full_name');
			$role = Input::get('role');
			$email = Input::get('email');
			$phone = Input::get('phone');
			$address = Input::get('address');
			$city = Input::get('city');
			$state = Input::get('state');
			$country = Input::get('country');
			$bio = Input::get('bio');

			$gonow = Array(
				'id' 			=> $id, 
				'full_name' 	=> $full_name, 
				'role' 			=> $role, 
				'email' 		=> $email, 
				'phone' 		=> $phone, 
				'address' 		=> $address, 
				'city' 			=> $city, 
				'state' 		=> $state, 
				'country' 		=> $country, 
				'photo' 		=> $photo, 
				'bio' 			=> $bio, 
			);
			
			$notice = Admin::insertTable($gonow);

			if ($notice) {
				Redirect::to(Config::ADMIN_BASE_URL().'admin_manager/edit_admin/'.$id.'?update=success');
			} else {
				Redirect::to(Config::ADMIN_BASE_URL().'admin_manager/edit_admin/'.$id.'?update=failed');
			}
		}


	}

?>