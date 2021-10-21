<?php
class sliders extends controller
{
	public function __construct(){
	}

	public function printResult($result){
		print_r(json_encode($result));
		exit();
	}

	public function index(){
		HeadersControl::guest('holder');
		
		$arrayName = array(
			'slides' => HomeSlider::getAll(),
			'banners' => HomeBanners::bannerWrap()
		);
		self::printResult($arrayName);
	}

	public function all_slides($root, $subRoot, $token){
		HeadersControl::guest('holder');
		
		$arrayName = array(
			'slides' => HomeSlider::allby_admin(),
			'banners' => HomeBanners::bannerWrap()
		);
		self::printResult($arrayName);
	}


	public function addSlide($root, $subRoot, $token){
		$isAuth = HeadersControl::admin($token);
		if (isset($isAuth['adminID']) && is_numeric($isAuth['adminID'])) {
			$adminID = $isAuth['adminID'];

			$postdata = file_get_contents("php://input");
    		$request = json_decode($postdata);
    		$data = json_decode($request->data);

    		$info = HomeSlider::addSlide($data);

    		self::printResult(Helper::actionResponse($info));
		}
		else {
			self::printResult($isAuth);
		}
	}

	public function edit($root, $subRoot, $token){
		$isAuth = HeadersControl::admin($token);
		if (isset($isAuth['adminID']) && is_numeric($isAuth['adminID'])) {
			$adminID = $isAuth['adminID'];

			$postdata = file_get_contents("php://input");
    		$request = json_decode($postdata);
    		$data = json_decode($request->data);

    		$info = HomeSlider::editSlide($data);

    		self::printResult(Helper::actionResponse($info));
		}
		else {
			self::printResult($isAuth);
		}
	}

	public function delete($root, $subRoot, $token, $id){
		$isAuth = HeadersControl::admin($token);
		if (isset($isAuth['adminID']) && is_numeric($isAuth['adminID'])) {
			$adminID = $isAuth['adminID'];
			
    		$info = HomeSlider::deleteRecord($id);

    		self::printResult(Helper::actionResponse($info));
		}
		else {
			self::printResult($isAuth);
		}
	}

	public function slide($root, $subRoot, $token, $id){
		$isAuth = HeadersControl::admin($token);
		if (isset($isAuth['adminID']) && is_numeric($isAuth['adminID'])) {
			$adminID = $isAuth['adminID'];

    		$info = HomeSlider::singleRecord($id);

    		self::printResult(Helper::actionResponse(null, $info));
		}
		else {
			self::printResult($isAuth);
		}
	}


	public function edit_home_banner($root, $subRoot, $token){
		$isAuth = HeadersControl::admin($token);
		if (isset($isAuth['adminID']) && is_numeric($isAuth['adminID'])) {
			$adminID = $isAuth['adminID'];

			$postdata = file_get_contents("php://input");
    		$request = json_decode($postdata);
    		$data = json_decode($request->data);

    		$info = HomeBanners::updateRecord($data);

    		self::printResult(Helper::actionResponse($info));
		}
		else {
			self::printResult($isAuth);
		}
	}

}
?>