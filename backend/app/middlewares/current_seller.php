<?php
@session_start();

// use Illuminate\Database\Eloquent\Model as Eloquent;

class current_seller extends controller
{
	

	public function __construct(){

	}

	public function mustbe_loggedin(){
		
		if($this->authSeller() && $this->authSeller()->password == $_SESSION[$this->auth_seller().'password']) {
			return $this;
		}
		// elseif(self::authenticateCookie()){
		// 	return self::authenticateCookie();
		// }
		else{
			Redirect::to('seller/login');
		}
	}



	//Authenticate from cookie record
	public function authenticateCookie(){
		/*if(!$this->auth() && isset($_COOKIE[$this->auth_user()])){
			$authCookie = preg_replace('#[^0-9.]#', '', $_COOKIE[$this->auth_user()]);		
			$user = User::where('login_id', $authCookie)->first();
			
			Session::put($this->auth_user(), $authCookie);
			return $this;				
		}*/

		return false;
	}

}


?>