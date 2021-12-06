<?php

	/**

	 * this class contains all configurations for our project

	 * some values are fetched from database while others are hardcoded

	 */

	class Config

	{

		private static $siteInfo;



		public function __construct(){

		}



		public static function project(){

			//Return TRUE on production

			//or return FALSE on development

			return true;

		}



		public static function project_name(){

			return	WebsiteSettings::single()->name;

		}



		public static function isDemo(){

			return	false;

		}



		public static function businessName(){

			return	WebsiteSettings::single()->biz_name;

		}





		public static function directory() {

		    return '/';	    

		}

		

		public static function guest() {

		    return 'guest';   

		}



		public static function userDirectory() {

		    return 'user/';	  

		}



		public static function sellerDirectory() {

		    return 'seller/';	  

		}



		public static function adminDirectory() {

		    return 'administrator/';	    

		}



		public static function templatePath(){

			return 'template/';

		}



		public static function defaultTemplate(){

			return	'default';

		}

		

		/**

		 * returns the domain of this project

		 * @return string

		 */

		public static function domain() {

			if(self::project()){

				//return	self::host().self::directory();

				return	self::host().'/';

			} else {

				// return	'https://localhost:4200/';

				return	'https://localhost/azanyAngular/';

			}



		}



		public static function USER_BASE_URL(){

			return	self::host().self::directory().self::userDirectory();

		}



		public static function USER_BASE_ROOTPATH(){

			return	self::ROOTPATH().self::userDirectory();

		}



		public static function SELLER_BASE_URL(){

			return	self::host().self::directory().self::sellerDirectory();

		}



		public static function SELLER_BASE_ROOTPATH(){

			return	self::ROOTPATH().self::sellerDirectory();

		}



		public static function ADMIN_BASE_URL(){

			return	self::host().self::directory().self::adminDirectory();

		}



		public static function ADMIN_BASE_ROOTPATH(){

			return	self::ROOTPATH().self::adminDirectory();

		}



		public  static function ROOTPATH(){

			return	$_SERVER["DOCUMENT_ROOT"].self::directory();

		}



		//File Uploads path

		public  static function uploadPATH(){

			if(self::project()){

				return	$_SERVER["DOCUMENT_ROOT"].'/uploads/';

			}

			else{

				return	$_SERVER["DOCUMENT_ROOT"].'/creativeCommerceCDN/uploads/';

			}

		}	



		//File Uploads URL

		public  static function uploadURL(){

			if(self::project()){

				return	self::host().'/uploads/';

			}

			else{

				return	self::host().'/creativeCommerceCDN/uploads/';

			}

		}



		public  static function customTemplatePath(){

			return	self::ROOTPATH().self::templatePath().self::defaultTemplate();

		}



		

		/**

		*returns the current template for the views

		*@return string

		*/

		public  static function views_template(){

			return self::templatePath().self::defaultTemplate();

		}





		public  static function siteEmail(){

			return 'noreply@'.self::serverName();

		}



		public static function serverName(){

			if(self::project()){

				return	str_replace('https://', '', str_replace('http://', '', str_replace('www.', '', WebsiteSettings::single()->site_url)));

			}

			else{

				return	$_SERVER['HTTP_HOST'];

			}

		}



		/**

		 * returns the host of this project

		 * @return string

		 */



		public  static function host(){

			$serverHost = "https://".self::serverName();

			// if(self::isSecure() == 'on'){

			// 	$serverHost = "https://".self::serverName();

			// }

			// else{

			// 	$serverHost = "http://".self::serverName();

			// }



			return	$serverHost;

		}



		public static function isSecure() {		    

		    if((isset($_SERVER['HTTPS']) AND $_SERVER['HTTPS'] == "on")) {

		    	return 'on';

		    }

		    else{

		    	return 'off';

		    }

		}



	}

?>