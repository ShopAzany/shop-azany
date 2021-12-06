<?php
	/**
	 * this class is the default controller of our application,
	 * 
	*/
	class login extends controller{
		public function __construct(){
			
		}
 
		//Default load function
		public function index(){
			$this->view('administrator/login');
		}
		

		public function authenticate(){
	        $trial = Admin::single(Input::get('admin'));
	        $result = $this->authenticateAdmin_with($trial->email, Input::get('password'));
	        if($result) { 
	        	AdminLoginActivity::create([
            		'admin' => $trial->username,
            		'ip' => Visitor::getIP(),
            		'browser' => Visitor::getBrowser(),
            		'os' => Visitor::getOS(),
            		'last_access' => Settings::currentTime(),
            	]);                
	            Session::putFlash('Info', "Welcome back, " . $result->username).'!';
	            Redirect::to(Config::ADMIN_BASE_URL().'dashboard');
	        }

	        Redirect::to(Config::ADMIN_BASE_URL().'login?error=true');
	    }


	    public function logout(){
			session_destroy();
	        Session::putFlash('Info', "Hope to see you again.");

	        Redirect::to(Config::ADMIN_BASE_URL().'login');
		}

	}

?>