<?php
	//Include Google client library 
	include_once(ROOT_PATH . 'plugins/socials/googleApp/src/Google_Client.php');
	include_once(ROOT_PATH . 'plugins/socials/googleApp/src/contrib/Google_Oauth2Service.php');

	/*
	 * Configuration and setup Google API
	 */
	//live production
	$clientId = '96388412784-u0ogp838dpi2b7eod6j4oj7gh78i3grm.apps.googleusercontent.com';
	$clientSecret = '2SuiFh0mChtXg4gF5KfQPkUp';
	$redirectURL = 'http://www.oziconnect.com/login';

	//Localhost test
	//$clientId = '96388412784-nd5ln7trmus11dfp10gv4971dt9e1f9m.apps.googleusercontent.com';
	//$clientSecret = 'm1-G01hEBkAh1wiXFK-tpQRz';
	//$redirectURL = 'http://localhost/oziconnect/login';


	//Call Google API
	$gClient = new Google_Client();
	$gClient->setApplicationName('Oziconnect');
	$gClient->setClientId($clientId);
	$gClient->setClientSecret($clientSecret);
	$gClient->setRedirectUri($redirectURL);

	$google_oauthV2 = new Google_Oauth2Service($gClient);
?>