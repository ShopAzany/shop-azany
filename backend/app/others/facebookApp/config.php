<?php
if(!session_id()){
	session_start();
}

// Include the autoloader provided in the SDK
require_once __DIR__ . '/facebook-php-sdk/autoload.php';

// Include required libraries
use Facebook\Facebook;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;

/*
 * Configuration and setup Facebook SDK
 */

//Live production
$appId 			= '386849775068180'; //Facebook App ID
$appSecret 		= 'a5ca9cd8fbde93c9413dd26be1c072e3'; //Facebook App Secret
$redirectURL 	= 'https://www.oziconnect.com/login-facebook'; //Callback URL

//localhost test
//$appId 			= '1120232024773835'; //Facebook App ID
//$appSecret 		= 'a744ebb046f37d2550d2fcf10552b106'; //Facebook App Secret
//$redirectURL 	= 'http://localhost/oziconnect/login-facebook'; //Callback URL

$fbPermissions 	= array('email');  //Optional permissions

$fb = new Facebook(array(
	'app_id' => $appId,
	'app_secret' => $appSecret,
	'default_graph_version' => 'v2.10',
));

// Get redirect login helper
$helper = $fb->getRedirectLoginHelper();

// Try to get access token
try {
	if(isset($_SESSION['facebook_access_token'])){
		$accessToken = $_SESSION['facebook_access_token'];
	}else{
  		$accessToken = $helper->getAccessToken();
	}
} catch(FacebookResponseException $e) {
 	echo 'Graph returned an error: ' . $e->getMessage();
  	exit;
} catch(FacebookSDKException $e) {
	echo 'Facebook SDK returned an error: ' . $e->getMessage();
  	exit;
}

?>