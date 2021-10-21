<?php



/**
* 
*/
class Redirect
{

	public static function to($location = null){
		//Take the first 7 characters from the string
		$part = substr($location,0,7);

		//Check if match is found for external url or full url
		if($part == 'http://' OR $part == 'https:/'){
			$location = $location;	
		}
		else{
	 		$location = Config::domain()."$location";	
		}

		if ($location) {
				if (is_numeric($location)) {
					
					switch ($location) {
						case '404':
							header('HTTP/1.0 404 page not found');
							break;
						
						default:
				
						break;
					}
				}



				
				ob_end_clean();

				header('Location:'. $location);
				exit();
		}


	}

	public static function test($value='')
	{

		$configInfo = ConfigurationSetting::first()->toArray();

		echo $configInfo['level_one'];
	}

}













