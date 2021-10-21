<?php
class currency extends controller
{
	public function __construct(){
	}

	public function printResult($result){
		print_r(json_encode($result));
		exit();
	}

	public function index(){
		HeadersControl::guest('holder');
		$result = CurrencyTbl::getDefault();
		$result['CurrencyTbl'] = CurrencyTbl::get();
		self::printResult($result);
	}


	public function add($root, $subroot, $token){
		$isAuth = HeadersControl::admin($token);
		if (isset($isAuth['adminID']) && is_numeric($isAuth['adminID'])) {
			$adminID = $isAuth['adminID'];

			$postdata = file_get_contents("php://input");
    		$request = json_decode($postdata);
    		$data = json_decode($request->data);

    		$info = CurrencyTbl::insertTable($data);

    		self::printResult(Helper::actionResponse($info));
		}
		else {
			self::printResult($isAuth);
		}
	}

	public function setDefault($root, $subroot, $token){
		$isAuth = HeadersControl::admin($token);
		if (isset($isAuth['adminID']) && is_numeric($isAuth['adminID'])) {
			$adminID = $isAuth['adminID'];

			$postdata = file_get_contents("php://input");
    		$request = json_decode($postdata);
    		$data = json_decode($request->data);

    		$info = CurrencyTbl::setDefault($data->id);

    		self::printResult(Helper::actionResponse($info));
		}
		else {
			self::printResult($isAuth);
		}
	}

}
?>