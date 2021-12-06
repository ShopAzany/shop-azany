<?php
	class home extends controller {
		public function __construct(){
		}

		//Default load function
		public function index(){
			Redirect::to(Config::domain());
		}
	}
?>