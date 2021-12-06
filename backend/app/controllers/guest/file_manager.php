<?php
class file_manager extends controller
{
	public function __construct(){
	}

	public function printResult($result){
		print_r(json_encode($result));
		exit();
	}

	public function index($root, $token, $limit=24, $page=1){
		$isAuth = HeadersControl::admin($token);
		if (isset($isAuth['adminID']) && is_numeric($isAuth['adminID'])) {
			$adminID = $isAuth['adminID'];			

			if(!$page){
				$page = 1; $offset = 0;
			}
			else{				
				$offset = $limit * ($page - 1);
			}

			$result = array(
				'data' => Media_manager::allRecords($limit, $offset),
				'count' => Media_manager::allRecordCnts(),
			);

			self::printResult($result);
		}
		else {
			self::printResult($isAuth);
		}
	}


	public function upload($root, $subRoot, $folder, $name, $resize=0, $width=null, $height=null, $mxWidth=null, $mxHeight=null){
		HeadersControl::guest('holder');

	    $options = array(
            'folder' 		=> $folder.'/',
            'resizedFolder' => $folder.'/resized/',
            'name'        	=> $name,
            'isResized'    	=> $resize ? true : false,
            'rezWidth'     	=> $width,
            'rezHeight'    	=> $height,
        );

	    $sizeOption = array(
            'maxSize' 	=> 5000000,
            'resize' 	=> $resize,
            'minWidth' 	=> $width,
            'minHeight' => $height,
            'maxWidth'  => $mxWidth ?: $width,
            'maxHeight' => $mxHeight ?: $height
        );

        $validate = Images::fileSize($_FILES['upload'], $sizeOption);

        if ($validate) {
        	self::printResult(Helper::actionResponse($info, $fileUrl, $validate));
        	return;
        }

		$fileUrl = Images::fileUpload($_FILES['upload'], $options);
		// $info = Media_manager::createRecord($fileUrl, $name, $folder);

		self::printResult(Helper::actionResponse(null, $fileUrl));
	}

	public function delete($root, $subRoot, $token, $id) {
		$isAuth = HeadersControl::admin($token);
		if (isset($isAuth['adminID']) && is_numeric($isAuth['adminID'])) {
			$adminID = $isAuth['adminID'];

			$info = Media_manager::deleteFile($id);
			self::printResult(Helper::actionResponse($info));
		}
		else {
			self::printResult($isAuth);
		}
	}



	// public function popUpload($root, $subRoot, $folder, $name){
	// 	$options = array(
 //            'folder'      	=> $folder.'/',
 //            'name'      	=> $name,
 //            'resizedFolder' => false
	// 	);
	// 	if ($_FILES['file']['name']) {
	// 		$pop = Images::fileUpload($_FILES['file'], $options)['original'];
	// 	}
	// 	Helper::printResult($pop);
	// }

}
?>