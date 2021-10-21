<?php
	class Socials
	{

		private static $googleClentID = '444006937749-kec34a93l436hpn4gse73ptpt7qgi479.apps.googleusercontent.com';
		private static $facebookAppID = '386849775068180';
		private static $facebookAppSecret = 'a5ca9cd8fbde93c9413dd26be1c072e3';
		private static $facebookAppVersion = 'v2.10';

		//Run db connection 
		public function __construct(){
		}

		//Grad rows based on a double condition
		public static function googleLogin(){
			$control = new controller();
			//Include Google client library 
		  	include_once(Config::ROOTPATH(). 'app/others/googleApp/src/Google_Client.php');
		  	include_once(Config::ROOTPATH(). 'app/others/googleApp/src/contrib/Google_Oauth2Service.php');

			/*
			* Configuration and setup Google API
			*/
			//live production
			$clientId = '96388412784-nd5ln7trmus11dfp10gv4971dt9e1f9m.apps.googleusercontent.com';
			$clientSecret = 'm1-G01hEBkAh1wiXFK-tpQRz';
			//$redirectURL = 'https://www.oziconnect.com/login';

			//Localhost test
			/*$clientId = '96388412784-nd5ln7trmus11dfp10gv4971dt9e1f9m.apps.googleusercontent.com';
			$clientSecret = 'm1-G01hEBkAh1wiXFK-tpQRz';*/
			$redirectURL = 'http://localhost/oziconnect/login';
			$redirectURL = 'http://localhost:4200';


			//Call Google API
			$gClient = new Google_Client();
			$gClient->setApplicationName('Oziconnect');
			$gClient->setClientId($clientId);
			$gClient->setClientSecret($clientSecret);
			$gClient->setRedirectUri($redirectURL);

			$google_oauthV2 = new Google_Oauth2Service($gClient);

		  	//===============================================
		  	//$socialt = new SOCIAL();

		 	if(Input::get('code')){
				$gClient->authenticate(Input::get('code'));
				$_SESSION['token'] = $gClient->getAccessToken();
				header('Location: ' . filter_var($redirectURL, FILTER_SANITIZE_URL));
				//'<script> window.location.href = "'.filter_var($redirectURL, FILTER_SANITIZE_URL).'";</script>';
				//exit();
		  	}

		  	if (isset($_SESSION['token'])) {
		   		$gClient->setAccessToken($_SESSION['token']);
		  	}

		  	if($gClient->getAccessToken()) {
				//Get user profile data from google
				$gpUserProfile = $google_oauthV2->userinfo->get();
				$user = User::where('email', $gpUserProfile['email'])->first();

			    if($user){
			    	Session::put($control->auth_user(), $user->login_id, $user->password);
			      	//
			      	User_login_activity::insertRow($user->login_id, $user->username);

			      	Redirect::to(Config::domain());
			    }
			    else{
			      	$username = strtok($gpUserProfile['email'], '@');
			      	$username = strtolower(preg_replace('/[^A-Za-z0-9_\-]/', '', str_replace('-', '', str_replace('.', '', $username))));

			      	$gpUserData = array(
			          	'username'  => $username,
			          	'lastName'  => $gpUserProfile['given_name'],
			          	'firstName' => $gpUserProfile['family_name'],
			          	'email'     => $gpUserProfile['email'],
			          	'gender'    => $gpUserProfile['gender'],
			          	'picture'   => $gpUserProfile['picture'],
			          	'link'      => $gpUserProfile['link'],
			          	'linkType'  => 'google'
			      	);

			      	$_SESSION['signupData'] = $gpUserData;
			      	Redirect::to(Config::domain().'register?social=google');
			    }
		  	} 
		  	else {
		    	$authUrl = $gClient->createAuthUrl();
		    	$googleLoginURL = filter_var($authUrl, FILTER_SANITIZE_URL);
		  	}			
	        
	        //Return login link
	        return $googleLoginURL;
	    }

	    public static function googleLoginJSveryify($idToken) {
	    	//Include Google client library 
		  	include_once(Config::ROOTPATH(). 'app/others/googleApp/src/Google_Client.php');
		  	include_once(Config::ROOTPATH(). 'app/others/googleApp/src/contrib/Google_Oauth2Service.php');
	    	$client = new Google_Client(['client_id' => self::$googleClentID]);
			$gpUserProfile = $client->verifyIdToken($idToken);

			//
			if($gpUserProfile) {
				return $gpUserProfile;
			} 
			else {
			  return 'Failed';
			}
	    }

	    public static function facebookLoginJSveryify() {
	    	$fb = new Facebook\Facebook([
			  'app_id' => self::$facebookAppID,
			  'app_secret' => self::$facebookAppSecret,
			  'default_graph_version' => self::$facebookAppVersion,
			]);

			$helper = $fb->getJavaScriptHelper();

			try {
			  $accessToken = $helper->getAccessToken();
			} 
			catch(Facebook\Exceptions\FacebookResponseException $e) {
			  //$error = 'Graph returned an error: ' . $e->getMessage();
			} 
			catch(Facebook\Exceptions\FacebookSDKException $e) {
			  //$error = 'Facebook SDK returned an error: ' . $e->getMessage();
			}

			if($accessToken->getValue()) {
			  	$fb->setDefaultAccessToken($accessToken->getValue());
				// Getting user facebook profile info
			    try {
			      $profileRequest = $fb->get('/me?fields=name,first_name,last_name,email,link,gender,locale,picture');
			      $fbUserProfile = $profileRequest->getGraphNode()->asArray();
			    } 
			    catch(FacebookResponseException $e) {
			      //$error = 'Graph returned an error: ' . $e->getMessage();
			    } 
			    catch(FacebookSDKException $e) {
			      //$error = 'Facebook SDK returned an error: ' . $e->getMessage();
			    }	
			}
			else{
				//$error = 'No cookie set or no OAuth data could be obtained from cookie.';
			}

			if($fbUserProfile){
				return $fbUserProfile;
			}
			else{
				//return $error;
				return 'Failed';
			}
	    }
		
	}
?>