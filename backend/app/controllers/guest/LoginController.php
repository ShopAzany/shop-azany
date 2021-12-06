<?php
	/**
	 * this class is the default controller of our application,
	 * 
	*/
	class LoginController extends controller{
		
		public function __construct(){
		}


		public function index(){
			HeadersControl::guest('holder');

			$postdata = file_get_contents("php://input");
			$request = json_decode($postdata);
			$userUnique = $request->user; //'newbuyer@gmail.com'; 
			$password = $request->password; //'123456'; 

			// $userUnique = $data->email;
			// $password = $data->password;

            $user = User::where('email', $userUnique)->first();
            if($user) {
            	if($user->status == 'Blocked' || $user->status == 'Rejected') {
            		self::printResult(
		        		'This account has been Blocked, Contact support if you think its an error!'
		        	);
            	} elseif(User::verifyPass($password, $user->password)) {
		            $auth = Helper::loginHandler($user);
            		self::printResult($auth);
		        }
		        else {
		        	self::printResult(
		        		'Oops! Password and Email does not match, please try it again.'
		        	);
		        }
            }
            else {
            	self::printResult('Oops! No record found with your entry.');
            }
		}

	    //Handle both facebook and google login
	    public function socialLogin() {
			HeadersControl::guest('holder');
			$postdata = file_get_contents("php://input");
			$request = json_decode($postdata);

            $user = User::socialLogin($request);
            
            if($user) {
            	$auth = Helper::loginHandler($user);
            	self::printResult($auth);
            }
            else {
            	self::printResult(Helper::actionResponse($user));
            }
	    }

	    private function printResult($result){
	    	//print_r(json_encode($this->auth()));
            print_r(json_encode($result, JSON_PRETTY_PRINT));
            exit();      
	    }

	}

?>