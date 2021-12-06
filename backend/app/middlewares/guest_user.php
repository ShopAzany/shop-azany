<?php
@session_start();

// use Illuminate\Database\Eloquent\Model as Eloquent;

class guest_user extends controller
{
	

	public function __construct(){

	}


	public function checkCookies(){
		/*if(isset($_COOKIE[$this->auth_user().'NewVisitorGetStarted']) AND !$this->auth()) {
		    Redirect::to(Config::domain().'get-started');
		}
		elseif(isset($_COOKIE[$this->auth_user().'NewVisitorGetStarted'])){
			Session::unSetCookies($this->auth_user().'NewVisitorGetStarted', 'true');
		}*/
	}


}


?>