<?php
	/**
	 * this class is the default controller of our application,
	 * 
	*/
	class login extends controller{
		
		public function __construct(){
		}


		public function index(){
			HeadersControl::guest('holder');

			$postdata = file_get_contents("php://input");
			$request = json_decode($postdata);

			$userUnique = $request->user; //'info@johndoe1111.com.ng'; 
			$password = $request->password; //'123456';

            $seller = Seller::where('email', $userUnique)->orWhere('phone', $userUnique)->first();
            if($seller) {
            	if($seller->status == 'Blocked' || $seller->status == 'Rejected') {

            		$result = 'This account has been Blocked, Contact support if you think its an error!';
           			self::printResult(Helper::actionResponse(null, null, $result));

            	} elseif(User::verifyPass($password, $seller->password)) {
            		$getBus = SellerBussinessInfo::singleBySellerID($seller->seller_id);
            		$getBank = SellerBankInfo::getForSeller($seller->seller_id);
		            $auth = Helper::sellerHandler($seller);
            		$auth['biz_info'] = $getBus;
            		$auth['bank_info'] = $getBank;
		            self::printResult(Helper::actionResponse(null, $auth));
		        }
		        else {
		        	$result = 'Oops! Password and Email does not match, please try it again.';
		        	self::printResult(Helper::actionResponse(null, null, $result));
		        }
            }
            else {
            	$result = 'Oops! No record found with your entry.';
            	self::printResult(Helper::actionResponse(null, null, $result));
            }
		}

	    private function printResult($result){
	    	//print_r(json_encode($this->auth()));
            print_r(json_encode($result, JSON_PRETTY_PRINT));
            exit();      
	    }

	}

?>