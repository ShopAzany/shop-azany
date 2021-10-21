<?php

/**
 * --
 */
class HeadersControl
{
	
	public function __construct() {		
	}

    private function allowedHeaders() {
        // return ['https://oziconnect.com', 'https://www.oziconnect.com'];
        return ['https://localhost:4200', 'https://www.localhost:4200'];
    }

    private function authGeneric() {
        //if (in_array($_SERVER['HTTP_ORIGIN'], self::allowedHeaders())) {
            header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
        //}
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        header("Access-Control-Max-Age: 3600");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");        
    }

	public static function guest($required){
		if($required == null || $required ==''){
			echo 'required!';exit();
		}

		self::authGeneric();
	}

    public function optionRequest($token){
        self::authGeneric();

        if (!is_null($token)) {
            try {
                $payload = JWT::decode($token, Settings::serverKey(), array('HS256'));
                if(!isset($payload->exp) && !isset($payload->expAlt)) {
                    $returnArray = array('error' => 'Expired');
                }
                elseif (
                    isset($payload->exp) && ($payload->exp > strtotime(Settings::currentTime())) || (isset($payload->expAlt) && strtotime($payload->expAlt) > strtotime(Settings::currentTime())) && (is_numeric($payload->loginID) > 0)
                ) {

                    $returnArray = array('loginID' => $payload->loginID) ;
               }
               else {
                    $returnArray = array('error' => 'Expired');
               }
            }
            catch(Exception $e) {
                $returnArray = array('error' => $e->getMessage());
            }
        } 
        else {
            $returnArray = null;
        }

        return $returnArray;
    }
    
	public function user($token){		
		self::authGeneric();

		if (!is_null($token)) {
            try {
                $payload = JWT::decode($token, Settings::serverKey(), array('HS256'));
                if(!isset($payload->exp) && !isset($payload->expAlt)) {
                	$returnArray = array('error' => 'Expired');
                }
                elseif (
                	isset($payload->exp) && ($payload->exp > strtotime(Settings::currentTime())) || (isset($payload->expAlt) && strtotime($payload->expAlt) > strtotime(Settings::currentTime())) && (is_numeric($payload->loginID) > 0)
                ) {

                	$returnArray = array('loginID' => $payload->loginID) ;
               }
               else {
               		$returnArray = array('error' => 'Expired');
               }
            }
            catch(Exception $e) {
                $returnArray = array('error' => $e->getMessage());
            }
        } 
        else {
            $returnArray = array('error' => 'You are not logged in with a valid token.');
        }

		return $returnArray;
	}




    public function seller($token){       
        self::authGeneric();

        if (!is_null($token)) {
            try {
                $payload = JWT::decode($token, Settings::serverKey(), array('HS256'));
                if(!isset($payload->exp) && !isset($payload->expAlt)) {
                    $returnArray = array('error' => 'Expired');
                }
                elseif (
                    isset($payload->exp) && ($payload->exp > strtotime(Settings::currentTime())) || (isset($payload->expAlt) && strtotime($payload->expAlt) > strtotime(Settings::currentTime())) && (is_numeric($payload->sellerID) > 0)
                ) {

                    $returnArray = array('sellerID' => $payload->sellerID) ;
               }
               else {
                    $returnArray = array('error' => 'Expired');
               }
            }
            catch(Exception $e) {
                $returnArray = array('error' => $e->getMessage());
            }
        } 
        else {
            $returnArray = array('error' => 'You are not logged in with a valid token.');
        }

        return $returnArray;
    }




	public function admin($token){		
		self::authGeneric();

		if (!is_null($token)) {
            try {
                $payload = JWT::decode($token, Settings::serverKey(), array('HS256'));
                if(!isset($payload->exp) && !isset($payload->expAlt)) {
                	$returnArray = array('error' => 'Expired');
                }
                elseif (
                	isset($payload->exp) && ($payload->exp > strtotime(Settings::currentTime())) || (isset($payload->expAlt) && strtotime($payload->expAlt) > strtotime(Settings::currentTime())) && (is_numeric($payload->adminID) > 0)
                ) {

                	$returnArray = array('adminID' => $payload->adminID) ;
                    // Admin_login_activity::createRecord($payload->adminID);
               }
               else {
               		$returnArray = array('error' => 'Expired');
               }
            }
            catch(Exception $e) {
                $returnArray = array('error' => $e->getMessage());
            }
        } 
        else {
            $returnArray = array('error' => 'You are not logged in with a valid token.');
        }

		return $returnArray;
	}
	
}

?>