<?php
	/** 
	 * this class is the default controller of our application,
	 * 
	*/
	class product_manager extends controller{
		public function __construct(){
			$this->middleware('administrator')->mustbe_loggedin();
		}

		// MANAGING PRODUCT
		public function index($page=1){
			$count = Products::count();
			$pageLimit = 20;
			$offset = $pageLimit * ($page - 1);
			$linkLimit = 5;

			$allProducts = Products::adminProductList($pageLimit, $offset);	

			// print_r(CusPagination::pagination_links($pageLimit, $count, $page, $linkLimit)['totalLink']);
			// exit();
			
			$this->view('administrator/product-list', [
				'products' => $allProducts,
				'pageLinks' => CusPagination::pagination_links($pageLimit, $count, $page, $linkLimit)['links'],
				'currPage' => $page,
				'totalLink' => CusPagination::pagination_links($pageLimit, $count, $page, $linkLimit)['totalLink'],
			]);
		}


		public function edit($id){
			$getPro = Products::where('pid', $id)->first();
			$categories = explode(',', $getPro->category);

			$proVariations = ProductVariation::singleByPid($id);

			// $variation = explode(',', $getPro->category);
			$getVariation = CategoryVariation::getCategory($categories[0]);
			$allVariation = json_decode($getVariation->value_obj);

			if ($getPro && $getPro->pid == $id) {
				$this->view('administrator/edit-product', [
					'product' => $getPro,
					
					'theCat' => $categories['0'],
					'theSub_cat' => str_replace(' ', '', $categories[1]),
					'theSub_sub_cat' => str_replace(' ', '', $categories[2]),

					'categories' => CategoryTbl::get(),
					'subCategories' => CategoriesChild::get(),
					'subChildCategories' => CategoriesSubChild::get(),

					'proVariations' => $proVariations,
					'getVariation' => $allVariation,
					'countries' => Countries::getAll(),
					'features' => json_decode($getPro->features)
				]);
			}
		}



		public function deleteProduct(){
			$pid = Input::get("pid");

			$delete = Products::where('pid', $pid)->delete();
			if ($delete) {
				Redirect::to(Config::ADMIN_BASE_URL().'product_manager?delete=success');
			}
		}

		public function approve_product(){
			$pid = Input::get("pid");

			$delete = Products::where('pid', $pid)->update([
				'status' => 'Active'
			]);
			if ($delete) {
				Redirect::to(Config::ADMIN_BASE_URL().'product_manager?approve=success');
			}
		}

		public function update_product_details(){
			$pid = Input::get('pid');
			$category = Input::get('category');
			$title = Input::get('title');
			$sub_title = Input::get('sub_title');
			$pro_condition = Input::get('pro_condition');
			$brand = Input::get('brand');
			$size = Input::get('size');
			$material = Input::get('material');
			$manufacture_country = Input::get('manufacture_country');
			$theFeatures = json_encode(Input::get('theFeatures'));
			$description = Input::get('description');

			$items = array(
				'pid' => $pid, 
				'category' => $category, 
				'title' => $title, 
				'sub_title' => $sub_title, 
				'pro_condition' => $pro_condition, 
				'brand' => explode(',', $brand)[1], 
				'size' => $size, 
				'material' => $material, 
				'manufacture_country' => $manufacture_country, 
				'features' => $theFeatures, 
				'description' => $description, 
			);

			$adminUp = Products::adminUpdateProduct($items);
			if ($adminUp) {
				Redirect::to(Config::ADMIN_BASE_URL().'product_manager/edit_image/'.$pid);
			}
		}


		public function edit_image($id){
			$getPro = Products::where('pid', $id)->first();
			if ($getPro && $getPro->pid == $id) {
				$this->view('administrator/edit-product-images', [
					'product' => $getPro,
					'productImg' => json_decode($getPro->images)
				]);
			}
		}

		public function update_pro_img(){
			$pid = Input::get("pid");
			$singlePro = Products::where('pid', $pid)->first();

			$options = array(
	            'folder' => 'product_images/',
	            'name'  => 'product_'.$pid,
	        );

	        $image = Images::fileUpload($_FILES['product_img'], $options)['original'];

	        if ($singlePro->images) {
	        	$getServerImg = json_decode($singlePro->images, true);
	        	$getServerImg[] = $image;
	        } else {
	        	$getServerImg = array();
	        	$getServerImg[] = $image;
	        }

	        $update = Products::where('pid', $pid)->update([
	        	'images' => json_encode($getServerImg)
	        ]);

	        if ($update) {
	        	Redirect::to(Config::ADMIN_BASE_URL().'product_manager/edit_image/'.$pid);
	        }
		}

		public function remove_product_img(){
			$pid = Input::get('pid'); 
			$arrID = Input::get('arrID');

			$singlePro = Products::where('pid', $pid)->first();
			$getServerImg = json_decode($singlePro->images, true);

			unset($getServerImg[$arrID]);

			$update = Products::where('pid', $pid)->update([
	        	'images' => json_encode($getServerImg)
	        ]);

			if ($update) {
	        	Redirect::to(Config::ADMIN_BASE_URL().'product_manager/edit_image/'.$pid);
	        }
		}

		public function saveImgContinue(){
			$pid = Input::get('pid');
			Redirect::to(Config::ADMIN_BASE_URL().'product_manager/selling_details/'.$pid);
		}



		public function selling_details($id){
			$getPro = Products::where('pid', $id)->first();
			$proVariations = ProductVariation::singleByPid($id);

			$variation = explode(',', $getPro->category);
			$getVariation = CategoryVariation::getCategory($variation[0]);
			$allVariation = json_decode($getVariation->value_obj);

			if ($getPro && $getPro->pid == $id) {
				$this->view('administrator/edit-product-selling-details', [
					'product' => $getPro,
					'proVariations' => $proVariations,
					'getVariation' => $allVariation
				]);
			}
		}

		public function update_edited_pro_pricing(){
			$pid = Input::get("pid");
			$sellerID = Input::get("sellerID");
			$domestic_policy = Input::get("domestic_policy");
			$inter_policy = Input::get("inter_policy");

			foreach (Input::all()['theVariation'] as $value) {

				$getEach = explode(',', $value['variation']);
				$vName = $getEach[0];
				$vValue = $getEach[1];

				if ($value['pVarID']) {
					ProductVariation::where('id', $value['pVarID'])->update([
						'name' => $vName,
						'value' => $vValue,
						'quantity' => $value['quantity'],
						'regular_price' => $value['regular_price'],
						'sales_price' => $value['sales_price'],
						'seller_id' => $sellerID
					]);
				} else {
					ProductVariation::create([
						'pid' => $pid,
						'name' => $vName,
						'value' => $vValue,
						'quantity' => $value['quantity'],
						'regular_price' => $value['regular_price'],
						'sales_price' => $value['sales_price'],
						'seller_id' => $sellerID
					]);
				}
			}
			Products::where('pid', $pid)->update([
				'inter_policy' => $inter_policy,
				'domestic_policy' => $domestic_policy
			]);
			Redirect::to(Config::ADMIN_BASE_URL().'product_manager/shipping_info/'.$pid);
		}


		public function shipping_info($id){
			$getPro = Products::where('pid', $id)->first();
			if ($getPro && $getPro->pid == $id) {
				$this->view('administrator/edit-product-ship-info', [
					'product' => $getPro,
					'countries' => Countries::getAll(),
					'curr' => CurrencyTbl::getDefault()
				]);
			}
		}

		public function update_shipping_detail(){
			$pid = Input::get("pid");
			$pro_location_country = Input::get("pro_location_country");
			$pro_location_state = Input::get("pro_location_state");
			$shipping_method = Input::get("shipping_method");
			$shipping_fee = Input::get("shipping_fee");
			$allow_shipping_outside = Input::get("allow_shipping_outside");

			$update = Products::where('pid', $pid)->update([
				'pro_location_country' 		=> $pro_location_country,
				'pro_location_state' 	=> $pro_location_state,
				'shipping_method' 	=> $shipping_method,
				'shipping_fee' 	=> $shipping_fee,
				'allow_shipping_outside' 	=> $allow_shipping_outside
			]);

			if ($update) {
				Redirect::to(Config::ADMIN_BASE_URL().'product_manager?update=success');
			}	
		}



		


		public function delete_variation(){
			$proVarID = Input::get("proVarID");
			$proID = Input::get("proID");

			$delete = ProductVariation::where('id', $proVarID)->delete();

			if ($delete) {
				Redirect::to(Config::ADMIN_BASE_URL().'product_manager/edit_pricing/'.$proID.'?action=success');
			}
		}





		

		// public function submit_all(){
		// 	Redirect::to(Config::ADMIN_BASE_URL().'product_manager');
		// }
		// MANAGING PRODUCT

		

		public function manage_category(){
			print_r($result);
			$this->view('administrator/manage-category', [
				'categories' => CategoryTbl::categoryWrap(),
			]);
		}


		public function add_category(){
			$category = Input::get("category");
			$parentCat = Input::get("parentCategory");
			$mobile_icon = Input::get("mobile_icon");
			$web_icon = Input::get("web_icon");
			$cat_desc = Input::get("cat_desc");
			$sepParentCatValue = explode(',', $parentCat);

			$info = false;
			if ($parentCat == 'parent') {
				$options = array(
		            'folder' => 'cat_img/',
		            'name'  => $category,
		        );

		        $cat_img = Images::fileUpload($_FILES['cat_img'], $options)['original'];

    			$info = CategoryTbl::createRecord(
	    			$category,
	    			null, 
	    			$mobile_icon, 
	    			$web_icon,
	    			$cat_desc,
	    			$cat_img
	    		);
    		}
    		elseif($sepParentCatValue[0] == 1) {
    			$info = CategoriesChild::createRecord(
    				$sepParentCatValue[1], $category, null
    			);
    		}
    		elseif($sepParentCatValue[0] == 2) {
    			$info = CategoriesSubChild::createRecord(
    				$sepParentCatValue[1], $category, null
    			);
    		}

    		if ($info) {
    			Redirect::to(Config::ADMIN_BASE_URL().'product_manager/manage_category?added=success');
    		}
		}

		public function delete_category(){
			$theID = Input::get("theID");
			$theRole = Input::get("theRole");

			if($theID){
				if ($theRole == 'category') {
					$delCat = CategoryTbl::where('cat_id', $theID)->delete();
					if ($delCat) {
						$delSubCat = CategoriesChild::where('cat_id', $theID)->delete();
						$delSubCatChild = CategoriesSubChild::where('cat_id', $theID)->delete();
					}
				} else if($theRole == 'sub category'){
					$delCat = CategoriesChild::where('subcat_id', $theID)->delete();
					if ($delCat) {
						$delSubCatChild = CategoriesSubChild::where('subcat_id', $theID)->delete();
					}
				} else if($theRole == 'sub category child'){
					$delCat = CategoriesSubChild::where('sub_subcat_id', $theID)->delete();
				}

				Redirect::to(Config::ADMIN_BASE_URL().'product_manager/manage_category?category=delete');
			}

		}




		// CATEGORY BANNER
		public function category_banner(){
			print_r($result);
			$this->view('administrator/category-banner', [
				'categories' => CategoryTbl::categoryWrap(),
				'banners' => CategoryBanner::get(),
			]);
		}


		public function add_cat_banner(){
			$title = Input::get('title');
			$link = Input::get('link');
			$category = Input::get('category');

			if ($_FILES['banner']['name']) {
				$options = array('folder' => 'cat_banner/', 'name'  => $category);
	        	$banner = Images::fileUpload($_FILES['banner'], $options)['original'];
			}

			$add = CategoryBanner::createRecord(
				$title,
				$category,
				$banner,
				$link
			);
			if ($add) {
				Redirect::to(Config::ADMIN_BASE_URL().'product_manager/category_banner?add=success');
			} else {
				Redirect::to(Config::ADMIN_BASE_URL().'product_manager/category_banner?add=failed');
			}
		}


		public function delete_cat_banner(){
			$bannerID = Input::get("bannerID");
			$del = CategoryBanner::where('id', $bannerID)->delete();
			if ($del) {
				Redirect::to(Config::ADMIN_BASE_URL().'product_manager/category_banner?delete=success');
			} else {
				Redirect::to(Config::ADMIN_BASE_URL().'product_manager/category_banner?delete=failed');
			}
		}



		// FEATURE CATEGORY

		public function featured_category(){
			$this->view("administrator/featured-category", [
				'features' => CategoryHomeFeatured::orderBy('id', 'DESC')->get(),
				'categories' => CategoryTbl::get()
			]);
		}


		public function add_feature(){
			$title = Input::get("title");
			$category = Input::get("category");
			$full_width_banner_link = Input::get("full_width_banner_link");
			$left_banner_link = Input::get("left_banner_link");
			$right_banner_link = Input::get("right_banner_link");

			$checkAvailable = CategoryHomeFeatured::getSingle($category);
			if ($checkAvailable) {
				Redirect::to(Config::ADMIN_BASE_URL().'product_manager/featured_category?error=cat');
			}


			if ($_FILES['full_width_banner']['name']) {
				$options = array('folder' => 'cat_banner/', 'name'  => $category);
	        	$full_width_banner = Images::fileUpload($_FILES['full_width_banner'], $options)['original'];
			}

			if ($_FILES['left_banner']['name']) {
				$options = array('folder' => 'cat_banner/', 'name'  => $category);
	        	$left_banner = Images::fileUpload($_FILES['left_banner'], $options)['original'];
			}

			if ($_FILES['right_banner']['name']) {
				$options = array('folder' => 'cat_banner/', 'name'  => $category);
	        	$right_banner = Images::fileUpload($_FILES['right_banner'], $options)['original'];
			}

			$create = CategoryHomeFeatured::create([
				'title' => $title,
				'category' => $category,
				'full_width_banner_link' => $full_width_banner_link,
				'left_banner_link' => $left_banner_link,
				'right_banner_link' => $right_banner_link,
				'full_width_banner' => $full_width_banner,
				'left_banner' => $left_banner,
				'right_banner' => $right_banner,
			]);

			if ($create) {
				Redirect::to(Config::ADMIN_BASE_URL().'product_manager/featured_category?add=success');
			} else {
				Redirect::to(Config::ADMIN_BASE_URL().'product_manager/featured_category?add=failed');
			}
		}


		public function delete_feature_cat(){
			$getID = Input::get("featID");

			$del = CategoryHomeFeatured::where("id", $getID)->delete();
			if ($del) {
				Redirect::to(Config::ADMIN_BASE_URL().'product_manager/featured_category?delete=success');
			}
		}


		public function edit_feature_category($id){
			$getID = CategoryHomeFeatured::where('id', $id)->first();

			if ($getID && $getID->id == $id) {
				$this->view("administrator/featured-category-edit", [
					'feat' => $getID,
					'categories' => CategoryTbl::get()
				]);
			}
		}

		public function update_feature(){
			$id = Input::get("id");
			$title = Input::get("title");
			$category = Input::get("category");
			$full_width_banner_link = Input::get("full_width_banner_link");
			$left_banner_link = Input::get("left_banner_link");
			$right_banner_link = Input::get("right_banner_link");

			// $checkAvailable = CategoryHomeFeatured::getSingle($category);
			// if (count($checkAvailable) > 1) {
			// 	Redirect::to(Config::ADMIN_BASE_URL().'product_manager/edit_feature_category/'.$id.'?error=cat');
			// }

			$full_width_banner = Input::get("def_full_width_banner");
			if ($_FILES['full_width_banner']['name']) {
				$options = array('folder' => 'cat_banner/', 'name'  => $category);
	        	$full_width_banner = Images::fileUpload($_FILES['full_width_banner'], $options)['original'];
			}

			$left_banner = Input::get("def_left_banner");
			if ($_FILES['left_banner']['name']) {
				$options = array('folder' => 'cat_banner/', 'name'  => $category);
	        	$left_banner = Images::fileUpload($_FILES['left_banner'], $options)['original'];
			}

			$right_banner = Input::get("def_right_banner");
			if ($_FILES['right_banner']['name']) {
				$options = array('folder' => 'cat_banner/', 'name'  => $category);
	        	$right_banner = Images::fileUpload($_FILES['right_banner'], $options)['original'];
			}

			$create = CategoryHomeFeatured::where('id', $id)->update([
				'title' => $title,
				'category' => $category,
				'full_width_banner_link' => $full_width_banner_link,
				'left_banner_link' => $left_banner_link,
				'right_banner_link' => $right_banner_link,
				'full_width_banner' => $full_width_banner,
				'left_banner' => $left_banner,
				'right_banner' => $right_banner,
			]);

			if ($create) {
				Redirect::to(Config::ADMIN_BASE_URL().'product_manager/edit_feature_category/'.$id.'?update=success');
			} else {
				Redirect::to(Config::ADMIN_BASE_URL().'product_manager/edit_feature_category/'.$id.'?update=failed');
			}
		}




		// VARIATIONS
		public function common_variation(){
			$this->view("administrator/common-variation", [
				'categories' => CategoryTbl::get(),
				'allVariations' => CategoryVariation::get(),
			]);
		}


		public function add_variation(){
			$category = Input::get("category");
			$variationName = Input::get("variationName");
			$variationValues = Input::get("variationValues");

			$values = explode(',', $variationValues);

			// check if category already exist
			$existCat = CategoryVariation::getCategory($category);
			if ($existCat) {
				$existCatArr = json_decode($existCat->value_obj, true);
				$dExist = self::checkVaNameDuplicate($existCatArr, $variationName);
				
				//exist by value which is not allowed
				if ($dExist) {
					Redirect::to(Config::ADMIN_BASE_URL().'product_manager/common_variation?error=variation-name');
				}

				$newArr = array('name' => $variationName, 'values' => $values);
				array_push($existCatArr, $newArr);
				$jsonVariation = json_encode($existCatArr);

				$info = CategoryVariation::where('category', $category)->update([
					'value_obj' => $jsonVariation
				]);
				if ($info) {
					Redirect::to(Config::ADMIN_BASE_URL().'product_manager/common_variation?add=success');
				}
			} else {
				// New Entery
	    		$temArr = array();
				$arr = array('name' => $variationName, 'values' => $values);
				array_push($temArr, $arr);
				$json = json_encode($temArr);

				$info = CategoryVariation::create([
					'category' => $category, 
					'value_obj' => $jsonVariation
				]);
				if ($info) {
					Redirect::to(Config::ADMIN_BASE_URL().'product_manager/common_variation?add=success');
				}
			}
		}



		private function checkVaNameDuplicate($varriations=array(), $name) {
			foreach ($varriations as $value) {
				if (strtolower($name) == strtolower($value['name'])) {
					return true;
				}
			}

			return false;
		}



		// HOME CAT BANNER
		public function top_category(){
			$this->view('administrator/top-category', [
				'homeCat' => HomeTopCategory::get(),
				'categories' => CategoryTbl::categoryWrap(),
			]);
		}

		public function add_home_cat_banner(){
			$category = Input::get('category');
			$title = Input::get('title');
			if ($_FILES['home_cat_banner']['name']) {
				$options = array('folder' => 'home_cat_banner/', 'name'  => $category);
	        	$home_cat_banner = Images::fileUpload($_FILES['home_cat_banner'], $options)['original'];
			}

			if (HomeTopCategory::singleByCat($category)) {
				Redirect::to(Config::ADMIN_BASE_URL().'product_manager/category_banner?home_banner=added');
			}

			$row = array(
				'category' => $category,
				'title' => $title,
				'banner' => $home_cat_banner,
			);

			$create = HomeTopCategory::createRow($row);

			if ($create) {
				Redirect::to(Config::ADMIN_BASE_URL().'product_manager/top_category?home_banner=success');
			}
		}


		public function delete_home_cat(){
			$bannerID = Input::get("catBanID");
			$del = HomeTopCategory::where('id', $bannerID)->delete();
			if ($del) {
				Redirect::to(Config::ADMIN_BASE_URL().'product_manager/top_category?home_ban_delete=success');
			} else {
				Redirect::to(Config::ADMIN_BASE_URL().'product_manager/top_category?home_ban_delete=failed');
			}
		}





		public function deals(){
			// print_r(Configuration::first()->toArray());
			// exit();
			$this->view('administrator/deals',[
				'config' => Configuration::first()
			]);
		}

		public function updateDeals(){
			$dealRole = Input::get("dealRole");
			$dealAction = Input::get("dealAction");

			if ($dealRole == 'week') {
				$update = Configuration::where('id', 1)->update([
					'week' => ucwords($dealAction)
				]);
			} else if($dealRole == 'trending') {
				$update = Configuration::where('id', 1)->update([
					'trending' => ucwords($dealAction)	
				]);		
			}

			if ($update) {
				Redirect::to(Config::ADMIN_BASE_URL().'product_manager/deals');
			}			

		}












	}

?>