
<?php


/**
* 
*/
class Input
{
	



	public static function exists($csrf_field=null){
		if (@$_POST[$csrf_field] ==null) {
			return false;		
		}
		$type = 'post';
		switch ($type) {
				case 'post':
					
					$_SESSION["inputs"] = $_POST;
					return (! empty($_POST) && Token::csrf_field($csrf_field)   === $_POST[$csrf_field])? true : false;

					break;

					case 'get':

					$_SESSION["inputs"] = $_GET;
					return (! empty($_GET)  && Token::csrf_field()   === $_GET['csrf_field'] )? true : false;


					break;
				
				default:
					
					return false;

				break;
			}	
		}

		public static function get($item)
		{
			if (isset($_POST[$item])) {
				return $_POST[$item];
			}elseif (isset($_GET[$item])) {
				return $_GET[$item];
			}

			return '';
		}
			
		public static function all()
		{
		if (isset($_POST)) {
				return $_POST;
			}elseif (isset($_GET)) {
				return $_GET;
			}

			return '';	
		}

		public static function old($item)
		{

			return Session::get('inputs')[$item];
		}

		public static function errors($fieldError = '' )
		{
			if ( $fieldError != '') {
				
			return Session::get('inputs-errors')[$fieldError];

			}
			return Session::get('inputs-errors');
		}

		
}