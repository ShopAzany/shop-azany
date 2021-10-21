<?php
class shopping_cart extends controller
{
	public function __construct(){
	}

	public function printResult($result){
		print_r(json_encode($result));
		exit();
	}

	public function index($root, $cartID, $token=null){
		$isAuth = HeadersControl::optionRequest($token);
		$loginID = $isAuth['loginID'] ? $isAuth['loginID'] : null;

		$result = UserShoppingCart::getCart($cartID, $loginID);

		self::printResult($result);
	}


	public function add($root, $subRoot, $cartID, $token=null){
		$isAuth = HeadersControl::optionRequest($token);
		$loginID = $isAuth['loginID'] ?: null;

		$postdata = file_get_contents("php://input");
    	$request = json_decode($postdata);

		$result = UserShoppingCart::addToCart($cartID, $loginID, $request);

		self::printResult($result);
	}

	public function remove($root, $subRoot, $cartID, $id, $token=null){
		$isAuth = HeadersControl::optionRequest($token);
		$loginID = $isAuth['loginID'] ? $isAuth['loginID'] : null;

		$result = UserShoppingCart::removeItem($cartID, $id, $loginID);

		self::printResult($result);
	}

	public function reduceItem($root, $subRoot, $cartID, $id, $qty=1, $token=null){
		$isAuth = HeadersControl::optionRequest($token);
		$loginID = $isAuth['loginID'] ? $isAuth['loginID'] : null;

		$result = UserShoppingCart::updateQty($cartID, $id, $qty);

		self::printResult($result);
	}

}
?>