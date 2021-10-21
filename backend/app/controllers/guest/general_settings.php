<?php
class general_settings extends controller
{
	public function __construct(){
	}

	public function printResult($result){
		print_r(json_encode($result));
		exit();
	}

	public function index(){
		HeadersControl::guest('holder');
		// Visitors::insertRow();
		$result = WebsiteSettings::single();
		$result['configuration'] = Configuration::first();
		$result['currency'] = CurrencyTbl::getDefault();
		$result['social_link'] = SocialSettingsTbl::getForGuest();
		self::printResult($result);
	}


	public function update($root, $subRoot, $token){
		$isAuth = HeadersControl::admin($token);
		if (isset($isAuth['adminID']) && is_numeric($isAuth['adminID'])) {
			$adminID = $isAuth['adminID'];

			$postdata = file_get_contents("php://input");
    		$request = json_decode($postdata);
    		$data = json_decode($request->data);

    		$info = WebsiteSettings::saveUpdate($adminID, $data);

    		self::printResult(Helper::actionResponse($info));
		}
		else {
			self::printResult($isAuth);
		}
	}

	public function update_social($root, $subRoot, $token){
		$isAuth = HeadersControl::admin($token);
		if (isset($isAuth['adminID']) && is_numeric($isAuth['adminID'])) {
			$adminID = $isAuth['adminID'];

			$postdata = file_get_contents("php://input");
    		$request = json_decode($postdata);
    		$data = json_decode($request->data);

    		$info = WebsiteSettings::updateSocial($adminID, $data);

    		self::printResult(Helper::actionResponse($info));
		}
		else {
			self::printResult($isAuth);
		}
	}

	public function photo_update($root, $subRoot, $token, $folder=null, $name=null){
		$isAuth = HeadersControl::admin($token);
		/*if (isset($isAuth['loginID']) && is_numeric($isAuth['loginID'])) {
			$loginID = $isAuth['loginID'];
			$userdata = User::select('photo')->where('login_id', $loginID)->first();*/
		    $options = array(
            'folder' 		=> $folder.'/',
            'resizedFolder' => $folder.'/resized/',
            'name'        	=> $name,
            'isResized'    	=> true,
            'rezWidth'     	=> 444,
            'rezHeight'    	=> 220,
        );


		$fileUrl = Images::fileUpload($_FILES['upload'], $options);

		self::printResult($fileUrl);
	}

	public function bank_details(){
		$isAuth = HeadersControl::guest('holder');

		$info = Configuration::single('bank_details_obj');
    	self::printResult(Helper::actionResponse(null, json_decode($info)));
	}

	public function updateConfig($root, $subRoot, $token){
		$isAuth = HeadersControl::admin($token);
		if (isset($isAuth['adminID']) && is_numeric($isAuth['adminID'])) {
			$adminID = $isAuth['adminID'];

			$postdata = file_get_contents("php://input");
    		$request = json_decode($postdata);
    		$data = json_decode($request->data);
    		
    		$info = Configuration::updateConfig($data);

    		self::printResult(Helper::actionResponse(null, $info));
		}
		else {
			self::printResult($isAuth);
		}
	}

}
?>