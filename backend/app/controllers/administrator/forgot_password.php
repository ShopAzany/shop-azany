<?php
	/**
	 * this class is the default controller of our application,
	 * 
	*/
	class forgot_password extends controller{
		public function __construct(){
			
		}
 
		//Default load function
		public function index(){
			$this->view('administrator/forgot-password');
		}

		public function authenticate(){
	        $trial = Admin::single(Input::get('admin'));
	        $result = $this->authenticateAdmin_with($trial->email, Input::get('password'));

	        if($result) {                
	            Session::putFlash('Info', "Welcome back, " . $result->username).'!';
	            Redirect::to(Config::ADMIN_BASE_URL());
	        }

	        Redirect::to(Config::domain().'admin-login?error=true');
	    }


	    public function logout(){
			session_destroy();
	        Session::putFlash('Info', "Hope to see you again.");

	        Redirect::to(Config::ADMIN_BASE_URL());
		}

	}

?>