<?php

/**
 * --
 */
class Images
{
	
	public function __construct() {		
	}

	public static function fileView($filePath){
		$imgFiles = array("jpeg", "JPEG", "jpg", "JPG", "png", "PNG", "gif", "GIF");
		$documentFiles = array("rtf", "RTF", "doc", "DOC", "docx", "DOCX");
		$pdfFiles = array("pdf", "PDF");
		$textFiles = array("txt", "TXT", "sql", "SQL");
		$zipFiles = array("zip", "ZIP", "rar", "RAR", "7-Zip", "7-ZIP", "7-zip");

		return $view;
	}

	private function validateIMGFile($sizeOption, $width, $height) {
		$rMinWidth = $sizeOption['minWidth'];
		$rMinHeight = $sizeOption['minHeight'];
		$rMaxWidth = $sizeOption['maxWidth'];
		$rMaxHeight = $sizeOption['maxHeight'];

		if ($width < $rMinWidth || $height < $rMinHeight) {
			return "Image upload must not below ". $sizeOption['minWidth']."px * ".$sizeOption['minHeight']."px ";
		}
		elseif($width > $rMaxWidth || $height > $rMaxHeight) {
			return "Image upload must not exceed ". $rMaxWidth."px * ".$rMaxHeight."px ";
		} else {
			return null;
		}
	}

	public static function fileSize($filePath, $sizeOption){
		$fileinfo = @getimagesize($filePath["tmp_name"]);
	    $width = $fileinfo[0];
	    $height = $fileinfo[1];
	    $maxSize = $sizeOption['maxSize'] ?: 5000000;
	    $error = null;

	    $fextnImgs = array("jpeg", "JPEG", "jpg", "JPG", "png", "PNG", "gif", "GIF", "tiff", "TIFF", "tif", "TIF");
	    $ext = explode('.', basename($filePath['name'])); 
		$file_extension = end($ext);

		if (!in_array($file_extension, $fextnImgs)) {
			return null;
		} 
		elseif (!$sizeOption['minWidth'] || $sizeOption['minWidth'] == 0) {
			return null;
		}

	    //Validate if its an image file
	    if (self::isImg($filePath) == 'img') {
	    	$error = self::validateIMGFile($sizeOption, $width, $height);
	    }

	    //validate both image and other files
	    if(!$error && $filePath["size"] > $maxSize) {
	    	$error = "Uploaded file exceeded the required file size.";
	    }

		return $error;
	}

	//unlink img
	public static function unlinkImg($imgPath){
		$part = substr($imgPath,0,7);
		if($part == 'http://' || $part == 'https:/'){
			if(self::imgUrlExist($imgPath)){
				$fie = explode('uploads', $imgPath);

				if(strpos($imgPath, 'cloudinary.com') !== false) {
				    $cloudinary = new Cloudinery();
					$cloudinary->delete($imgPath);

					return true;
				}
				elseif(file_exists(Config::uploadPATH().$fie[1])){
					unlink(Config::uploadPATH().$fie[1]);

					return true;
				}
				else{
					return false;
				}
			}
        }
        else{
        	$path = Config::ROOTPATH().str_replace('../', '', $imgPath);			
			if(file_exists($path)){
				unlink($path);

				return true;
			}
        }
		
		return false;
	}

	public static function imgUrlExist($imgUrl){
	    $ch = curl_init($imgUrl);    
	    curl_setopt($ch, CURLOPT_NOBODY, true);
	    curl_exec($ch);
	    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

	    if($code == 200){
	       $status = true;
	    }else{
	      $status = false;
	    }
	    curl_close($ch);

	   return $status;
	}

	public static function isImg($file){
		$fextnImgs = array(
			"jpeg", "JPEG", "jpg", "JPG", "png", "PNG", "gif", "GIF", "tiff", "TIFF", "tif", "TIF"
		);
		$fextnVideos = array(
			"flv", "FLV", "avi", "AVI", "mov", "MOV", "mp4", "MP4", "mp3", "MP3", "mpg", "MPG", "wmv", "WMV", "3gp", "3GP", "asf", "ASF"
		);
		$ext = explode('.', basename($file['name'])); 
		$file_extension = end($ext);

	    if(in_array($file_extension, $fextnImgs)) {
	      	return 'img';
	    }
	    elseif(in_array($file_extension, $fextnVideos)){
	    	return 'video';
	    }
	    else{
	    	return false;
	    }	   
	}

	public static function profileImgUpload($file, $folder, $name){
		if(self::isImg($file) == 'img'){
			//Upload only image & video files by Cloudinary
			//$cloudinary = new Cloudinery();
		    //$uploads = $cloudinary->uploadInputImg($file["tmp_name"], $folder.$name);

		    if($uploads['secure_url']){
		    	return $uploads['secure_url'];
		    }
		    else{
		     	$upldData = array(
			      'fileUpds'      => $file,
			      'resizedPath'   => Config::uploadPATH().$folder,
			      'pName'         => $name,
			      'resized'       => true,
			      'rezWidth'      => 200,
			      'rezHeight'     => 200,
			    );

			   return self::singleUpload($upldData)['resized'];
		    }		    
		}

	   return self::isImg($file);
	}

	//
	private static function fileUpload_Handler($file, $options=array()){
		$upldData = array(
            'fileUpds'     => $file, //Upload file data
            'originalPath' => Config::uploadPATH().$options['folder'],
            'resizedPath'  => Config::uploadPATH().$options['resizedFolder'],
            'pName'        => $options['name'], // name to rename the image file
            'resized'      => $options['isResized'], //boolan
            'rezWidth'     => $options['rezWidth'], // resize image width
            'rezHeight'    => $options['rezHeight'], // resize image height
            'wMarkchk'     => $options['watermark'], // boolan
            'wMarkImg'     => $options['watermarkUrl'], //Add watermark img url
      	);			
		//Call multi-file-upload function, it return multi array
		//You can convert to json data by using json_encode(value) function
		//if you are using a single table column to handle multiple img path
		//otherwise use foreach() loop to insert imgs upload table
     	return self::singleUpload($upldData);
	}

	//Handles all file type upload
	//Uses cloudinary to upload image & video files 
	//cloudinary if failed, custom file upload function is called
	//custom file upload function is called to handle other file type
	public static function fileUpload($file, $options=array()){
		if(self::isImg($file) == 'img'){
			//Upload only image & video files by Cloudinary
			/*$cloudinary = new Cloudinery();
		    $uploads = $cloudinary->uploadInputImg(
		    	$file["tmp_name"], $options['folder'].$options['name']
		    );*/

		    if($uploads['secure_url']){
		    	$singleFile['original'] = $uploads['secure_url'];
		    	$singleFile['resized'] = '';
		    	if($options['resized']){
		    		$singleFile['resized'] = '';//file manaipution url here
		    	}	

		    	return $singleFile;//array
		    }
		    else{
		    	return self::fileUpload_Handler($file, $options);	         	
		    }	    
		}
		elseif(self::isImg($file) == 'video') {
			//Upload only image & video files by Cloudinary
			$cloudinary = new Cloudinery();
		    $uploads = $cloudinary->uploadVideo($file["tmp_name"], $folder);

		    if($uploads['secure_url']){
		    	$singleFile['original'] = $uploads['secure_url'];
			    $singleFile['resized'] = $uploads['secure_url'];
				
				$filePaths[] = $singleFile;

		    	return $filePaths;//array
		    }
		    else{
		    	return self::fileUpload_Handler($file, $options);
		    }
		}
		else{
			return self::fileUpload_Handler($file, $options);	 
		}

	   return false;
	}


	//Handles multi-file uploads
	private static function singleUpload($upldData = array()){
		$pName = Settings::cleanUrl($upldData['pName']);

		// set variables
		if($upldData['originalPath']){
			$dir_dest = (isset($_GET['dir']) ? $_GET['dir'] : ''.$upldData['originalPath']);
			$dir_pics = (isset($_GET['pics']) ? $_GET['pics'] : $dir_dest);
		}
		
		$singleFile = array();
		$filePaths = array();

		//
		$handle = new Upload($upldData['fileUpds']);

		if($upldData['wMarkchk']){
			$waterMark = $handle->image_watermark = $upldData['wMarkImg'];
		}
		else{
			$waterMark = '';
		}

		//get file extention
		$path_info = $upldData['fileUpds']['name'];
		$ext = pathinfo($path_info, PATHINFO_EXTENSION);
		//
		if($handle->uploaded) {
			if($upldData['resized']){
				$resized_path = $handle->file_new_name_body = $pName.'-'.Settings::randomStrgs(20);
				$handle->image_resize          	= true;
				$handle->image_ratio_fill      	= 'C';
				$handle->image_x               	= $upldData['rezWidth'];
				$handle->image_y               	= $upldData['rezHeight'];
				$handle->image_background_color = '#F8F8F8';
				// Add watermark on the resize image
				$waterMark;
				$handle->image_watermark_x     = 20;
				$handle->image_watermark_y     = -3;
				$handle->Process(''.$upldData['resizedPath'].$handle->file_dst_name);
			}

			if($upldData['originalPath']){
				// Add watermark on the original image size
				$original_path = $handle->file_new_name_body = $pName.'-'.Settings::randomStrgs(20);
				$waterMark;
				$handle->image_watermark_x     = 20;
				$handle->image_watermark_y     = -3;
				$handle->Process($dir_dest);
			} 

			$handle-> Clean();
		    
		    //
		    $singleFile['original'] = '';
		    $singleFile['resized'] = '';

		    if($upldData['originalPath']){
			    $singleFile['original'] = str_replace(Config::uploadPATH(), Config::uploadURL(), $upldData['originalPath'].$original_path.'.'.$ext);
			}

		    if($upldData['resized']){
				$singleFile['resized'] = str_replace(Config::uploadPATH(), Config::uploadURL(), $upldData['resizedPath'].$resized_path.'.'.$ext);
			}
			
		}
		
		return $singleFile;		
	}

	
}

?>