<?php
	class product_manager extends controller {

		private $pageLimit = 10;

		public function __construct(){
		}

		private function printResult($result) {
			print_r(json_encode($result, JSON_PRETTY_PRINT));
			exit();
		}


		public function index($token, $limit=30, $page=1){
			$isAuth = HeadersControl::seller($token);
			if (isset($isAuth['sellerID']) && is_numeric($isAuth['sellerID'])) {
				$sellerID = $isAuth['sellerID'];

				if(!$page){
					$page = 1; $offset = 0;
				}
				else{				
					$offset = $limit * ($page - 1);
				}

				$products = Products::sellerProduct($limit, $offset, $sellerID);
				$newProducts = array();
				foreach ($products as $value) {
					$proVar = ProductVariation::where('pid', $value->pid)->first();
					$value['regular_price'] = $proVar->regular_price;
					$value['sale_price'] = $proVar->sale_price;
					$value['rate_number'] = ProductRatingTbl::countRate($value->pid);
					$value['average_rate'] = ProductRatingTbl::starAverageCal($value->pid);
					$value['variation'] = ProductVariation::firstProdID($value->pid);

					array_push($newProducts, $value);
				}

				$result = array(
					'data' => $newProducts,
					'count' => Products::sellerProductCount($sellerID)
				);

				self::printResult($result);
			}
			else {
				self::printResult($isAuth);
			}
		}


		public function index_alt($sellerID, $limit=30, $page=1){
			//$isAuth = HeadersControl::seller($token);
			HeadersControl::guest('holder');
			if ($sellerID && is_numeric($sellerID)) {
				//$sellerID = $isAuth['sellerID'];

				if(!$page){
					$page = 1; $offset = 0;
				}
				else{				
					$offset = $limit * ($page - 1);
				}

				$products = Products::sellerProduct($limit, $offset, $sellerID);
				$newProducts = array();
				foreach ($products as $value) {
					$proVar = ProductVariation::where('pid', $value->pid)->first();
					$value['regular_price'] = $proVar->regular_price;
					$value['sale_price'] = $proVar->sale_price;
					$value['rate_number'] = ProductRatingTbl::countRate($value->pid);
					$value['average_rate'] = ProductRatingTbl::starAverageCal($value->pid);
					$value['variation'] = ProductVariation::firstProdID($value->pid);

					array_push($newProducts, $value);
				}

				$result = array(
					'data' => $newProducts,
					'count' => Products::sellerProductCount($sellerID)
				);
                 
				self::printResult($result);
			}
			else {
				$result = $sellerID." failed";
				self::printResult($result);
			}
		}



		public function add_pro_detail($token){
			$isAuth = HeadersControl::seller($token);
			if (isset($isAuth['sellerID']) && is_numeric($isAuth['sellerID'])) {
				$sellerID = $isAuth['sellerID'];

				$postdata = file_get_contents("php://input");
				$request = json_decode($postdata);
				$data = json_decode($request->data);

				// $default = array(
				// 	'pid'                  =>  23,
				// 	'category'                  =>  'phone, tab, mobile',
	   //              'title'                      =>  'product is here for you alone',
	   //              'sub_title'                 =>  'subtitle is here ooo',
	   //              'brand'                     =>  'tecno',
	   //              'size'                      =>  'xxl',
	   //              'color'                     =>  'red',
	   //              'material'                  =>  'plastic',
	   //              'features'                  =>  'the phone is good',
	   //              'pro_condition'             =>  'Brand New',
	   //              'manufacture_country'       =>  'nigeria',
	   //              'manufacture_state'         =>  'lagos',
	   //              'description'               =>  'my description',
	   //              'status'                    =>  'Draft',
	   //              'featured_img'              =>  'feature img',
	   //              'images'                    =>  'real images'
				// );

				// $ed = json_encode($default);
				// $data = json_decode($ed);

				if ($data->pid != "") {
					$addProduct = Products::updateProduct($sellerID, $data);
				} else {
					//$addProduct = Products::createRow($sellerID, $data);
					$addProduct = Products::createNewRecord($data);
				}

				if ($data->pid != "") {
					$getProduct = Products::singleProduct($data->pid);
				} else {
					$getProduct = Products::lastRow($sellerID);
				}
				
				

				self::printResult(Helper::actionResponse(null, $getProduct));
			}
			else {
				self::printResult($isAuth);
			}
		}


		public function add_pro_detail_alt($sellerID){
			//$isAuth = HeadersControl::seller($token);
			HeadersControl::guest('holder');
			if ($sellerID && is_numeric($sellerID)) {
				//$sellerID = $isAuth['sellerID'];

				$postdata = file_get_contents("php://input");
				$request = json_decode($postdata);
				$data = json_decode($request->data);

				

				if ($data->pid) {
					$addProduct = Products::updateProduct($sellerID, $data);
				} else {
					//$addProduct = Products::createRow($sellerID, $data);
					$addProduct = Products::createRow($sellerID, $data);
				}

				if ($data->pid) {
					$getProduct = Products::singleProduct($data->pid);
				} else {
					$getProduct = Products::lastRow($sellerID);
				}
				
				

				self::printResult(Helper::actionResponse(null, $getProduct));
			}
			else {
				$result = $sellerID." failed";
				self::printResult($result);
			}
		}


		

		public function update_pricing($token){
			$isAuth = HeadersControl::seller($token);
			if (isset($isAuth['sellerID']) && is_numeric($isAuth['sellerID'])) {
				$sellerID = $isAuth['sellerID'];

				$postdata = file_get_contents("php://input");
				$request = json_decode($postdata);
				$data = json_decode($request->data);

				$updateP = Products::updatePricing($data);

				$newP = Products::singleProduct($data->pid);
				self::printResult(Helper::actionResponse(null, $newP));
			}
			else {
				self::printResult($isAuth);
			}
		}


		public function update_pricing_alt($sellerID){
			//$isAuth = HeadersControl::seller($token);
			HeadersControl::guest('holder');
			if ($sellerID && is_numeric($sellerID)) {
				//$sellerID = $isAuth['sellerID'];

				$postdata = file_get_contents("php://input");
				$request = json_decode($postdata);
				$data = json_decode($request->data);

				$updateP = Products::updatePricing($data);

				$newP = Products::singleProduct($data->pid);
				self::printResult(Helper::actionResponse(null, $newP));
			}
			else {
				$result = $sellerID." failed";
				self::printResult($result);
			}
		}


		public function update_shipping($token){
			$isAuth = HeadersControl::seller($token);
			if (isset($isAuth['sellerID']) && is_numeric($isAuth['sellerID'])) {
				$sellerID = $isAuth['sellerID'];

				$postdata = file_get_contents("php://input");
				$request = json_decode($postdata);
				$data = json_decode($request->data);

				$updateP = Products::updateShipping($data);

				$newP = Products::singleProduct($data->pid);
				self::printResult(Helper::actionResponse(null, $newP));
			}
			else {
				self::printResult($isAuth);
			}
		}


		public function update_shipping_alt($sellerID){
			//$isAuth = HeadersControl::seller($token);
			HeadersControl::guest('holder');
			if ($sellerID && is_numeric($sellerID)) {
				//$sellerID = $isAuth['sellerID'];

				$postdata = file_get_contents("php://input");
				$request = json_decode($postdata);
				$data = json_decode($request->data);

				$updateP = Products::updateShipping($data);

				$newP = Products::singleProduct($data->pid);
				self::printResult(Helper::actionResponse(null, $newP));
			}
			else {
				$result = $sellerID." failed";
				self::printResult($result);
			}
		}


		


		public function single($token, $pid, $name=null){
			$isAuth = HeadersControl::seller($token);
			if (isset($isAuth['sellerID']) && is_numeric($isAuth['sellerID'])) {
				$sellerID = $isAuth['sellerID'];

	    		$product = Products::singleProductForSeller($sellerID, $pid);
	    		$category = explode(',', $product->category)[0];
	    		$product['additional_description'] = json_decode($product->additional_description, true);	    		
	    		$product['category_variation'] = CategoryVariation::getCategoryVariations($category);
	    		$product['variation'] = ProductVariation::singleByPid($pid); 
	    		$product['images'] = json_decode($product->images, true);		

	    		self::printResult($product);
			}
			else {
				self::printResult($isAuth);
			}
		}


		public function single_alt($sellerID, $pid, $name=null){
			//$isAuth = HeadersControl::seller($token);
			HeadersControl::guest('holder');
			if ($sellerID && is_numeric($sellerID)) {
				//$sellerID = $isAuth['sellerID'];

	    		$product = Products::singleProductForSeller($sellerID, $pid);
	    		$category = explode(',', $product->category)[0];
	    		$product['additional_description'] = json_decode($product->additional_description, true);	    		
	    		$product['category_variation'] = CategoryVariation::getCategoryVariations($category);
	    		$product['variation'] = ProductVariation::singleByPid($pid); 
	    		$product['images'] = json_decode($product->images, true);		

	    		self::printResult($product);
			}
			else {
				$result = $sellerID." failed";
				self::printResult($result);
			}
		}


		public function priceVariation($token){
			$isAuth = HeadersControl::seller($token);
			if (isset($isAuth['sellerID']) && is_numeric($isAuth['sellerID'])) {
				$sellerID = $isAuth['sellerID'];

				$postdata = file_get_contents("php://input");
	    		$request = json_decode($postdata);
	    		$data = json_decode($request->data, true);
	    		// $variation = json_decode($request->variation, true);

	    		$info = Products::productPriceVariation($sellerID, $data);
	    		// $info = Products::productPriceVariation($data, $variation);
	    		self::printResult(Helper::actionResponse(null, $info));
			}
			else {
				self::printResult($isAuth);
			}
		}



		public function priceVariation_alt($sellerID){
			//$isAuth = HeadersControl::seller($token);
			HeadersControl::guest('holder');
			if ($sellerID && is_numeric($sellerID)) {
				//$sellerID = $isAuth['sellerID'];

				$postdata = file_get_contents("php://input");
	    		$request = json_decode($postdata);
	    		$data = json_decode($request->data, true);
	    		// $variation = json_decode($request->variation, true);

	    		$info = Products::productPriceVariation($sellerID, $data);
	    		// $info = Products::productPriceVariation($data, $variation);
	    		self::printResult(Helper::actionResponse(null, $info));
			}
			else {
				$result = $sellerID." failed";
				self::printResult($result);
			}
		}



		public function remove_product($token, $id){
			$isAuth = HeadersControl::seller($token);
			if (isset($isAuth['sellerID']) && is_numeric($isAuth['sellerID'])) {
				$sellerID = $isAuth['sellerID'];
				
				$info = Products::removeProduct($id);	

				$info = array(
					'status' => 'success', 
					'data' => self::index($token)
				);

				self::printResult($info);
			}
			else {
				self::printResult($isAuth);
			}
		}


		public function remove_product_alt($sellerID, $id){
			//$isAuth = HeadersControl::seller($token);
			HeadersControl::guest('holder');
			if ($sellerID && is_numeric($sellerID)) {
				//$sellerID = $isAuth['sellerID'];
				
				$info = Products::removeProduct($id);	

				$info = array(
					'status' => 'success', 
					'data' => self::index($sellerID)
				);

				self::printResult($info);
			}
			else {
				$result = $sellerID." failed";
				self::printResult($result);
			}
		}




		



	}

?>