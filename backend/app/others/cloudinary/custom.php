<?php	
    require 'autoload.php';
    //require 'Helpers.php'; //optional for using the cl_image_tag and cl_video_tag helper methods



    \Cloudinary::config(array( 
	  "cloud_name" => "oziconnect", 
	  "api_key" => "655365693653244", 
	  "api_secret" => "YOaheSwsMb2HO_UYRofmt_gnN9o" 
	));

	if($_FILES){
		echo "<pre>";
		//print_r($_FILES['file']);
		
		$upload = \Cloudinary\Uploader::upload($_FILES['file']['name']);
		print_r($upload);
		exit();
	}


?>

<form action="" method="post" enctype="multipart/form-data">
	<input type="file" name="file">
	<button type="submit">Submit</button>
</form>