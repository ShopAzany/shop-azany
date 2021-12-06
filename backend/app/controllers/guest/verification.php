<?php
	class verification extends controller
	{
		public function __construct() {		
		}


		public function index($root, $username, $code, $role=null) {
			HeadersControl::guest('holder');

                  $userInfo = User::where('username', $username)->first();
                  if($userInfo){
                  	$verifyInfo = User_verification::where('login_id', $userInfo->login_id)
                  		->where('email_code', $code)->first();
                  	if($verifyInfo){
                  		User_verification::where('email_code', $code)
                  		->where('login_id', $userInfo->login_id)->update(['email_verify' => 1]);
                              if($role != 'password-reset'){
                                    User::where('login_id', $userInfo->login_id)->update([
                                          'status' => 1,
                                          'status_type' => 'Active',
                                          'status_reasons' => 'Email Verified'
                                    ]);
                              }

                  		print_r(json_encode('success'));
                  		exit();
                  	}
                  }
                  print_r(json_encode('failed'));
                  exit();
		}

	}
?>