<?php
	/**
	 * this class is the default controller of our application,
	 * 
	*/ 
	class account_settings extends controller{
		public function __construct(){
			$this->middleware('administrator')->mustbe_loggedin();
		}
		
		//Default load function
		public function edit_profile(){
			$this->view('administrator/edit-profile');
		} 



		public function update_profile(){
			$photo = $this->admin()->photo;
			if ($_FILES['photo']['name']) {
				$photo = Images::profileImgUpload($_FILES['photo'], 'admin/', $this->admin()->username);
			} 
			$id = $this->admin()->id;
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
				Redirect::to(Config::ADMIN_BASE_URL().'account_settings/edit_profile?update=success');
			} else {
				Redirect::to(Config::ADMIN_BASE_URL().'account_settings/edit_profile?update=failed');
			}
		}



		public function change_password(){
			$this->view('administrator/change-password');
		}

		public function change_pwd(){
			$old_pwd = Input::get('old_pwd');
			$new_pwd = Input::get('new_pwd');
			$retype_new_pwd = Input::get('retype_new_pwd');

			if (!User::verifyPass($old_pwd, $this->admin()->password)) {
				Redirect::to(Config::ADMIN_BASE_URL().'admin_manager/change_password?password=wrong_password');
			}

			
			if ($new_pwd != $retype_new_pwd) {
				Redirect::to(Config::ADMIN_BASE_URL().'admin_manager/change_password?password=not_matched');
			} else {
				 $info = Admin::where('id', $this->admin()->id)->update([
				 	'password' 	=>  User::hashPass($new_pwd)
				 ]);

				Redirect::to(Config::ADMIN_BASE_URL().'admin_manager/change_password?password=success');
			}
		}


	}

?>