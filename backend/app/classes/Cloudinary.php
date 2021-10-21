<?php
	class Cloudinery {
		private static $uploadDir;
		private static $clounName;
		private static $apiKey;
		private static $apiSecret;

		public function __construct(){
			self::$uploadDir = 'uploads';
			self::$clounName = 'oziconnect';
			self::$apiKey = '655365693653244';
			self::$apiSecret = 'YOaheSwsMb2HO_UYRofmt_gnN9o';
		}

		public static function delete($publicID){
			include Config::ROOTPATH(). 'app/others/cloudinary/autoload.php';
            
            \Cloudinary::config(array( 
              "cloud_name" => self::$clounName, 
              "api_key" => self::$apiKey, 
              "api_secret" => self::$apiSecret 
            ));
            
			$result = \Cloudinary\Uploader::destroy($publicID);
	        
	        return $result;//return array
	    }

		public static function uploadInputImg($fileTmpName, $folder=null){
			//Update if it has value
			if($folder){
				self::$uploadDir = $folder;
			}
			
            include Config::ROOTPATH(). 'app/others/cloudinary/autoload.php';
            
            \Cloudinary::config(array( 
              "cloud_name" => self::$clounName, 
              "api_key" => self::$apiKey, 
              "api_secret" => self::$apiSecret 
            ));
            
            $upload = \Cloudinary\Uploader::upload($fileTmpName, array("public_id" => $folder));
	        
	        return $upload;//return array
	    }


		public static function uploadHTTPImg($httpUrl, $folder=null){
			//Update if it has value
			if($folder){
				self::$uploadDir = $folder;
			}

		  	include Config::ROOTPATH(). 'app/others/cloudinary/autoload.php';

			\Cloudinary::config(array( 
			  "cloud_name" => self::$clounName, 
			  "api_key" => self::$apiKey, 
			  "api_secret" => self::$apiSecret 
			));

			//
			$upload = \Cloudinary\Uploader::upload($httpUrl, array("public_id" => self::$uploadDir));
	        
	        return $upload;//return array
	    }


		public static function uploadVideo($fileTmpName, $folder=null){
			//Update if it has value
			if($folder){
				self::$uploadDir = $folder;
			}

		  	include Config::ROOTPATH(). 'app/others/cloudinary/autoload.php';

			\Cloudinary::config(array( 
			  "cloud_name" => self::$clounName, 
			  "api_key" => self::$apiKey, 
			  "api_secret" => self::$apiSecret 
			));

			//
			/*$upload = \Cloudinary\Uploader::upload_large($fileTmpName, array(
			  	"resource_type" => "video",
			  	"public_id" => self::$uploadDir,
			  	"chunk_size" => '6_000_000',
			  	"eager" => array(
			    	array("width" => 300, "height" => 300, "crop" => "pad", "audio_codec" => "none"), 
			    	array("width" => 160, "height" => 100, "crop" => "crop", "gravity" => "south", "audio_codec" => "none")
				), 
			  	"eager_async" => TRUE, 
			  	"eager_notification_url" => ""
			  )
			)*/
	        
	        return $upload;//return array
	    }




		public static function imgTags($fileUrl, $options=array()){
			include Config::ROOTPATH(). 'app/others/cloudinary/autoload.php';

			\Cloudinary::config(array( 
			  "cloud_name" => self::$clounName, 
			  "api_key" => self::$apiKey, 
			  "api_secret" => self::$apiSecret 
			));
			
			return cl_image_tag($fileUrl, $options);
	    }

		
	}
?>