<?php
class categories extends controller
{
	private $pageLimit = 12;


	public function __construct(){
	}

	public function printResult($result){
		print_r(json_encode($result));
		exit();
	}

	public function index(){
		HeadersControl::guest('holder');
		$result = CategoryTbl::categoryWrap();
		self::printResult($result);
	}

	public function catBySlugs(){
		HeadersControl::guest('holder');
		$result = array(
			'categories' => CategoryTbl::get(), 
			'subcategories' => CategoriesChild::get(), 
			'subChildcategories' => CategoriesSubChild::get(), 
			'cat_variation' => CategoryVariation::get(), 
		);
		self::printResult($result);
	}

	public function getVariation($root, $subroot, $cat){
		HeadersControl::guest('holder');
		// print_r($cat);
		// exit();
		$result = array(
			'cat_variation' => CategoryVariation::getCategoryVariations($cat)
		);
		self::printResult($result);
	}



	public function menus(){
		HeadersControl::guest('holder');
		self::printResult(Menus::menu());
	}

	public function topSelling(){
		self::printResult(OrdersTbl::mostSoldPro());
		exit();
	}


	public function home_info($root, $subroot, $token=null, $catArr=null){
		$isAuth = HeadersControl::optionRequest($token);
		$loginID = $isAuth['loginID'] ? $isAuth['loginID'] : null;

		// $catArr = json_encode(array('phones-and-tablets', 'computers-and-accessories'));

		//recommended
		$category = json_decode($catArr);
		if ($category) {
			$newRecommemded = array();
			foreach ($category as $cat) {
				$product = Products::recommended($cat, $loginID);
				foreach ($product as $pro) {
					array_push($newRecommemded, $pro);
				}
			}
		} else {
			$newRecommemded = [];
		}

		//shop by country
		$byCountry = ShopByCountry::orderBy('id', 'DESC')->get();
		$newCountry = array();
		foreach ($byCountry as $value) {
			$value['selectedPro'] = Products::homeProByCountry($value->country, $loginID);
			array_push($newCountry, $value);
		}

		//FEATURE PRODUCT BANNER
		$featProBan = FeatureProductBanner::first();
		$featProBan['products'] = Products::featProBan($featProBan->category, $featProBan->no_of_product, $loginID);

		$result = array(
			'shopByCountry' => $newCountry, 
			'HomeProduct' => HomeProductTbl::first(),
			'featProBan' => $featProBan,
			'top_categories' => HomeTopCategory::get(),
			'todayDeals' => Products::todayDeals($loginID),
			'threeGridImg' => HomeBanners::getAll(),
			'recentlyAdded' => Products::recentlyAdded($loginID),
			'liveStream' => VideoStreamTbl::get(),
			'topSelling' => array(),
			'recommended' => array_slice($newRecommemded, 0,4),
			'whyChoseUs' => WhyChoseUsTbl::get()
		);

		self::printResult($result);
	}


	public function add($root, $subRoot, $token){
		$isAuth = HeadersControl::admin($token);
		if (isset($isAuth['adminID']) && is_numeric($isAuth['adminID'])) {
			$adminID = $isAuth['adminID'];

			$postdata = file_get_contents("php://input");
    		$request = json_decode($postdata);
    		$role = explode(',', $request->parentCategory);

    		$info = false;
    		if ($request->parentCategory == 'parent') {
    			$info = Category::createRecord(
	    			$request->category,
	    			null, 
	    			$request->mobile_icon, 
	    			$request->web_icon
	    		);
    		}
    		elseif($role[0] == 1) {
    			$info = CategoriesChild::createRecord(
    				$role[1], $request->category, null
    			);
    		}
    		elseif($role[0] == 2) {
    			$info = CategoriesSubChild::createRecord(
    				$role[1], $request->category, null
    			);
    		}
    		
    		self::printResult(Helper::actionResponse($info));
		}
		else {
			self::printResult($isAuth);
		}
	}

	public function delete($root, $subRoot, $token, $catID, $level){
		$isAuth = HeadersControl::admin($token);
		if (isset($isAuth['adminID']) && is_numeric($isAuth['adminID'])) {
			$adminID = $isAuth['adminID'];

    		$info = false;
    		if ($level == 1) {
    			$info = Category::removeRecord($catID);
    		}
    		elseif($level == 2) {
    			$info = CategoriesChild::removeRecord($catID);
    		}
    		elseif($level == 3) {
    			$info = CategoriesSubChild::removeRecord($catID);
    		}
    		
    		self::printResult(Helper::actionResponse($info));
		}
		else {
			self::printResult($isAuth);
		}
	}

	public function allBannerAds($root, $subRoot, $token){
		$isAuth = HeadersControl::admin($token);
		if (isset($isAuth['adminID']) && is_numeric($isAuth['adminID'])) {
			$adminID = $isAuth['adminID'];
    		
    		self::printResult(CategoryBanner::allBannerAds());
		}
		else {
			self::printResult($isAuth);
		}
	}

	public function deleteBannerAd($root, $subRoot, $token, $id){
		$isAuth = HeadersControl::admin($token);
		if (isset($isAuth['adminID']) && is_numeric($isAuth['adminID'])) {
			$adminID = $isAuth['adminID'];
    		
    		$info = CategoryBanner::removeRecord($id);
    		self::printResult(Helper::actionResponse($info));
		}
		else {
			self::printResult($isAuth);
		}
	}

	public function addBannerAd($root, $subRoot, $token){
		$isAuth = HeadersControl::admin($token);
		if (isset($isAuth['adminID']) && is_numeric($isAuth['adminID'])) {
			$adminID = $isAuth['adminID'];

			$postdata = file_get_contents("php://input");
    		$request = json_decode($postdata);

    		$result = CategoryBanner::getSIngle($request->category);
    		if ($result) {
    			self::printResult(Helper::actionResponse(false));
    		}
    		$info = CategoryBanner::createRecord(
    			$request->title, $request->category, $request->banner, $request->link
    		);
    		
    		self::printResult(Helper::actionResponse($info));
		}
		else {
			self::printResult($isAuth);
		}
	}

	public function homeFeaturedCategories($root, $subRoot, $token){
		$isAuth = HeadersControl::admin($token);
		if (isset($isAuth['adminID']) && is_numeric($isAuth['adminID'])) {
			$adminID = $isAuth['adminID'];
    		
    		self::printResult(CategoryHomeFeatured::allRecords());
		}
		else {
			self::printResult($isAuth);
		}
	}

	public function deleteHomeFeaturedCat($root, $subRoot, $token, $id){
		$isAuth = HeadersControl::admin($token);
		if (isset($isAuth['adminID']) && is_numeric($isAuth['adminID'])) {
			$adminID = $isAuth['adminID'];
    		
    		$info = CategoryHomeFeatured::deleteRecord($id);
    		self::printResult(Helper::actionResponse($info));
		}
		else {
			self::printResult($isAuth);
		}
	}

	public function addHomeFeaturedCat($root, $subRoot, $token){
		$isAuth = HeadersControl::admin($token);
		if (isset($isAuth['adminID']) && is_numeric($isAuth['adminID'])) {
			$adminID = $isAuth['adminID'];

			$postdata = file_get_contents("php://input");
    		$request = json_decode($postdata);

    		$result = CategoryHomeFeatured::getSingle($request->category);
    		if ($result && $request->page != 'edit') {
    			self::printResult(Helper::actionResponse(false));
    		}
    		$info = CategoryHomeFeatured::createRecord($request);
    		
    		self::printResult(Helper::actionResponse($info));
		}
		else {
			self::printResult($isAuth);
		}
	}

	public function getVariations($root, $subRoot, $token=null){
		$isAuth = HeadersControl::admin($token);
		if (isset($isAuth['adminID']) && is_numeric($isAuth['adminID'])) {
			$adminID = $isAuth['adminID'];

			$arra = array();
			foreach (CategoryVariation::allRows() as $value) {
				$value['value_obj'] = json_decode($value->value_obj, true);
				array_push($arra, $value);
			}
			
    		self::printResult($arra);
		}
		else {
			self::printResult($isAuth);
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

	private function removeArr($varriations, $name) {
		foreach ($varriations as $key => $value) {
			if ($value['name'] == $name) {
				unset($varriations[$key]);
			}
		}

		return array_values($varriations);
	}

	public function addVariation($root, $subRoot, $token){
		$isAuth = HeadersControl::admin($token);
		if (isset($isAuth['adminID']) && is_numeric($isAuth['adminID'])) {
			$adminID = $isAuth['adminID'];

			$postdata = file_get_contents("php://input");
    		$request = json_decode($postdata);

    		$values = explode(',', $request->variationValues);

    		$name_slug = 

			//Exist by category, if true then update 
			$exist = CategoryVariation::getCategory($request->category);
			if ($exist) {
				$existArr = json_decode($exist->value_obj, true);
				$dExist = self::checkVaNameDuplicate($existArr, $request->variationName);
				
				//exist by value which is not allowed
				if ($dExist) {
					self::printResult(Helper::actionResponse(false));
				}

				$newArr = array(
					'name' => $request->variationName, 
					'slug' => str_replace('-', '_', Settings::cleanUrl($request->variationName)) , 
					'values' => $values
				);
				array_push($existArr, $newArr);
				$json = json_encode($existArr);

				$info = CategoryVariation::updateRecord($request->category, $json);
				self::printResult(Helper::actionResponse($info));
			}
			else {
				// New Entery
	    		$temArr = array();
				$arr = array(
					'name' => $request->variationName, 
					'slug' => str_replace('-', '_', Settings::cleanUrl($request->variationName)) , 
					'values' => $values);
				array_push($temArr, $arr);
				$json = json_encode($temArr);

				$info = CategoryVariation::createRecord($request->category, $json);
				self::printResult(Helper::actionResponse($info));
			}
		}
		else {
			self::printResult($isAuth);
		}
	}


	public function deleteVariation($root, $subRoot, $token, $category, $name=null){
		$isAuth = HeadersControl::admin($token);
		if (isset($isAuth['adminID']) && is_numeric($isAuth['adminID'])) {
			$adminID = $isAuth['adminID'];

			// self::printResult($name);

			$exist = CategoryVariation::getCategory($category);
			if ($name && $name != $category) {
				$arr = json_decode($exist->value_obj, true);
				$newAr = self::removeArr($arr, $name);

				$info = CategoryVariation::updateRecord($category, json_encode($newAr));
				self::printResult(Helper::actionResponse($info));
			}
			else {
				$info = CategoryVariation::deleteRecord($category);
    			self::printResult(Helper::actionResponse($info));
			}
		}
		else {
			self::printResult($isAuth);
		}
	}

}
?>