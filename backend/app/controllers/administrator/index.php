<?php
	/**
	 * this class is the default controller of our application,
	 * 
	*/
	class index extends controller{
		public function __construct(){
			
		}
 
		//Default load function
		public function index(){
			Redirect::to(Config::ADMIN_BASE_URL().'login');
		}

	}

?>