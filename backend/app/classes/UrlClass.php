<?php
	class UrlClass {
		
		public function __construct(){		
		}

		
		public static function basicUrl(){
			return $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		}


		public static function completeUrl(){
			$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

			return str_replace('/', '', $protocol).'/'.self::basicUrl();
		}
		
	}
?>