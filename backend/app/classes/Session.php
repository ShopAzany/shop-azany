<?php
	@session_start();
	/**
	* 
	*/
	class Session {
		public static function flash(){
			if(isset($_SESSION['flash'])){
				$flash = $_SESSION['flash'];

				unset($_SESSION['flash']);
				return $flash ;

			}
		}

		public static function putFlash($title, $message){
			$_SESSION['flash'][]= [	
				'title' => $title,
				'message'=>$message
			];

		}

		public static function hasFlash(){
			if(isset($_SESSION['flash'])){

				return true;
			}else{

				return false;
			}

		}		

		public static function exist($name) {
			return (isset($_SESSION["$name"]))	? true : false;
		}

		public static function put($name, $value, $value2=null) {
			if($value2){
				$_SESSION["$name".'password'] = $value2;
			}
			setcookie($name, $value, time() + (86400 * 90), "/");
			
			return $_SESSION["$name"] = $value;

		}


		public static function setCookiesOnly($name, $value, $duration) {
			return setcookie($name, $value, $duration, "/");
		}

		public static function unSetCookies($name, $value) {
			return setcookie($name, $value, time() - (86400 * 90), "/");
		}


		public static function get($name) {
			return (isset($_SESSION["$name"])) ? $_SESSION["$name"] :'' ;
		}

		public static function delete($name) {
			setcookie($name, $value, time() - (86400 * 90), "/");
			unset($_SESSION["$name"]);
		}

	}
?>