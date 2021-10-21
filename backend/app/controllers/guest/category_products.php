<?php
class category_products extends controller
{
	private $pageLimit = 12;


	public function __construct(){
	}

	private function printResult($results) {
		print_r(json_encode($results));
		exit();
	}

	// Grab products by category
	public function index($r, $token, $category, $limit=20, $page=1, $sort=''){
		$isAuth = HeadersControl::optionRequest($token);
		$loginID = $isAuth['loginID'] ? $isAuth['loginID'] : null;

		// self::printResult($category);

		if($limit > 0){$this->pageLimit = $limit;}

		if(!$page){
			$page = 1; $offset = 0;
		}
		else{				
			$offset = $this->pageLimit * ($page - 1);
		}

		$categoryBanner = CategoryBanner::getCategoryBanners($category);
		if(!$categoryBanner) {
			$categoryBanner = array();
		}

		$sortQuery = "products.pid ASC";
		if ($sort) {
			if (strtolower($sort) == 'asc') {
				$sortQuery = "product_variations.sales_price ASC";
			} else {
				$sortQuery = "product_variations.sales_price DESC";
			}
		}

		$allProducts = Products::selectRaw("products.*, product_variations.quantity - product_variations.order_count AS quantity")
			->take($limit)->offset($offset)->whereRaw(self::query($category))
			->join('product_variations', 'product_variations.pid', 'products.pid')
			->groupBy('products.pid')
			->orderByRaw("$sortQuery")
			->get();

		$allProductsCount = Products::whereRaw(self::query($category))
			->join('product_variations', 'product_variations.pid', 'products.pid')
			->groupBy('products.pid')
			->get()->count();

		$newAllProducts = array();
		foreach ($allProducts as $product) {
			$product['variation'] = ProductVariation::singleByPid($product->pid);
			$product['isFavorite'] = SavedProductsTbl::isFavorite($product->pid, $loginID);

			array_push($newAllProducts, $product);
		}
		
		$products = array(
			'data' => $newAllProducts, 
			'count' => $allProductsCount,
			'sidebarCategories' => CategoryTbl::getSidebarCategories($category),
			'categoryTitle' => CategoryTbl::catTitle($category),
			'categoryVariations' => CategoryVariation::getCategoryVariations($category),
			'categoryBanner' => $categoryBanner
		);

		self::printResult($products);
	}


	private function query($category){
		$aquery = '';
		$dQuery = "";
		if (Input::get('discount')) {
			$discountRange = array_filter(explode('-', Input::get('discount')));
			$firster = intval($discountRange[0]);
			$seconder = intval($discountRange[1]);
			$dQuery .= " (product_variations.discount >= $firster AND product_variations.discount <= $seconder)";
		}

		if (Input::get('tags')) {
			$tags = array_filter(explode('~', Input::get('tags')));
			foreach ($tags as $value) {
				if ($dQuery) {
					$dQuery .= " OR (products.tags LIKE '%$value%')";
				} else {
					$dQuery .= " (products.tags LIKE '%$value%')";
				}
				
			}
		}

		if (Input::get('brand')) {
			$brands = array_filter(explode('~', Input::get('brand')));
			foreach ($brands as $value) {
				if ($dQuery) {
					$dQuery .= " OR (products.brand LIKE '%$value%')";
				} else {
					$dQuery .= " (products.brand LIKE '%$value%')";
				}
				
			}
		}
		

		$sortWell = explode(',', CategoryTbl::forBreacrum($category));
		$getAllVarByCat = CategoryVariation::getCategory($sortWell[0]);
	
		foreach (json_decode($getAllVarByCat->value_obj) as $value) {
			$var = Input::get($value->slug);
			if (Input::get($value->slug)) {
				$queryValue = Input::get($value->slug);
				$name =  str_replace('_', ' ', $value->slug);
				$urlQueryValues = array_filter(explode('~', $queryValue));

				foreach ($urlQueryValues as $key => $value) {
					$value = str_replace('_', ' ', $value);
					if ($dQuery) {
						$dQuery .= " OR (product_variations.name='$name' AND product_variations.value='$value')";
					} else {
						$dQuery .= " (product_variations.name='$name' AND product_variations.value='$value')";
					}
				}
			}
		}

		if ($category) {
			if ($dQuery) {
				$aquery .= "($dQuery) AND (products.category LIKE '%$category%')";
			} else {
				$aquery .= " (products.category LIKE '%$category%')";
			}
		}
		
		// print_r($aquery);
		// exit();
		$mainQuery = "products.status='Active'";
		if ($aquery) {
			$mainQuery = "products.status='Active' AND ";
		}
		
		return $mainQuery.' '.$aquery;
	}

	//Grab single product
	public function product($root, $subRoot, $pid, $token=null){
		// HeadersControl::guest($pid);
		$isAuth = HeadersControl::optionRequest($token);
		$loginID = $isAuth['loginID'] ? $isAuth['loginID'] : null;

		$product = Products::singleById($pid);
		$category = end(explode(',', str_replace(' ', '', $product->category)));
		$product['additional_description'] = json_decode($product->additional_description, true);
		$product['variation'] = ProductVariation::singleByPid($pid);
		// $product['variation'] = $newVariation;
		$product['images'] = json_decode($product->images, true);
		$product['ratings'] = ProductRatingTbl::itemRatings($pid);
		$product['categoryTitle'] = CategoryTbl::catTitle($category);
		$product['rate_number'] = ProductRatingTbl::countRate($pid);
        $product['average_rate'] = ProductRatingTbl::starAverageCal($pid);
		$product['sellerInfo'] = SellerBussinessInfo::singleBySellerID($product->seller_id);
		$product['sellerRate'] = ProductRatingTbl::countSellerRate($product->seller_id);
		$product['sellerOrderFulfilment'] = OrdersTbl::sellerOrderFulfilment($product->seller_id);
		$product['otherSellerProduct'] = Products::otherSellerProduct($product->seller_id, $product->pid, $loginID);
		$product['sameProduct'] = Products::OtherSameProduct(explode(',', $product->category)[0], $product->pid, $loginID);
		$product['isFavorite'] = SavedProductsTbl::isFavorite($pid, $loginID);

		self::printResult($product);
	}

	//Grab deal
	public function deal($root, $subRoot, $limit=10){
		HeadersControl::guest('holder');

		$dealPro = Products::deal($limit);

		$newAllProducts = array();
		foreach ($dealPro as $product) {
			$product['variation'] = ProductVariation::singleByPid($product->pid);

			array_push($newAllProducts, $product);
		}

		self::printResult($newAllProducts);
	}

	//Grab featured
	public function featured($root, $subRoot, $limit=10){
		HeadersControl::guest('holder');

		$featurePro = Products::featured($limit);

		$newAllProducts = array();
		foreach ($featurePro as $product) {
			$product['variation'] = ProductVariation::singleByPid($product->pid);

			array_push($newAllProducts, $product);
		}

		self::printResult($newAllProducts);
	}

	//Home featured categories
	public function featuredCategories($root, $subRoot, $limit=10){
		HeadersControl::guest('holder');

		self::printResult(CategoryHomeFeatured::getFeaturedCategories($limit));
	}

	//Auth user rating
	public function rating($root, $subRoot, $token) {
		$isAuth = HeadersControl::user($token);
		if (isset($isAuth['loginID']) && is_numeric($isAuth['loginID'])) {
			$loginID = $isAuth['loginID'];

			$postdata = file_get_contents("php://input");
    		$request = json_decode($postdata);
    		$data = json_decode($request->data);

    		$info = ProductRating::insertRecord($data);
    		self::printResult(Helper::actionResponse($info));
		}
		else {
			self::printResult($isAuth);
		}
	}

}
?>