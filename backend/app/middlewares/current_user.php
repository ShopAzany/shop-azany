<?php
@session_start();

// use Illuminate\Database\Eloquent\Model as Eloquent;

class current_user extends controller
{
	

	public function __construct(){

	}


	public function mustbe_loggedin(){
		if($this->auth() && $this->auth()->password == $_SESSION[$this->auth_user().'password']){
			User::where('login_id', $this->auth()->login_id)->update([
				'lastseen_at' => Settings::currentTime(),
				'lastseen_ip' => Visitor::getIP(),
			]);

			return $this;	
		}
		elseif(self::authenticateCookie()){
			return self::authenticateCookie();
		}
		else{
			Redirect::to('login');
		}
	}



	//Authenticate from cookie record
	public function authenticateCookie(){
		if(!$this->auth() && isset($_COOKIE[$this->auth_user()])){
			$authCookie = preg_replace('#[^0-9.]#', '', $_COOKIE[$this->auth_user()]);		
			$user = User::where('login_id', $authCookie)->first();
			
			if($user){
				Session::put($this->auth_user(), $authCookie, $user->password);
			}
			return $this;				
		}

		return false;
	}

}


?>