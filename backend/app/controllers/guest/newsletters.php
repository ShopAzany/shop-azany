<?php
	class newsletters extends controller
	{
		public function __construct() {		
		}

            private function printResult($result){
                  print_r(json_encode($result));
                  exit();
            }


            public function index($root, $email) {
                  HeadersControl::guest('holder');
            }

		public function subscribe($root, $subRoot, $email) {
			HeadersControl::guest('holder');

                  if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $info = Newsletter::createRecord($email);
                        if ($info == 'exist') {
                              self::printResult(
                                    Helper::actionResponse(null, null, 'Oops! Email already subscribed')
                              );
                        } else {
                              self::printResult(
                                    Helper::actionResponse($info)
                              );
                        }
                  } else {
                        self::printResult(
                              Helper::actionResponse(null, null, 'Oops! Invalid email entered.')
                        );
                  }
		}

	}
?>