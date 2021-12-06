<?php
class all_deals extends controller
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

	public function deals($root, $subroot, $theDeals, $token=null, $limit=20, $page=1, $sort='', $catArr=null){
		$isAuth = HeadersControl::optionRequest($token);
		$loginID = $isAuth['loginID'] ? $isAuth['loginID'] : null;

		if($limit > 0){$this->pageLimit = $limit;}

		if(!$page){
			$page = 1; $offset = 0;
		} else{				
			$offset = $this->pageLimit * ($page - 1);
		}

		$sortQuery = "products.pid ASC";
		if ($sort) {
			if (strtolower($sort) == 'asc') {
				$sortQuery = "product_variations.sales_price ASC";
			} else {
				$sortQuery = "product_variations.sales_price DESC";
			}
		}

		if ($theDeals == 'today_deals') {
			$allProducts = Products::select('products.*')
			->take($limit)->offset($offset)->whereRaw("product_variations.discount > 0 AND ".self::query())
			->join('product_variations', 'product_variations.pid', 'products.pid')
			->groupBy('product_variations.pid')
			->orderByRaw("$sortQuery")
			->get();

			$allProductsCount = Products::whereRaw("product_variations.discount > 0 AND ".self::query())
			->join('product_variations', 'product_variations.pid', 'products.pid')
			->groupBy('product_variations.pid')
			->get()->count();
		} else if($theDeals == 'recommended'){
			// $catArr = json_encode(array('phones-and-tablets'));
			$categ = json_decode($catArr);
			if ($categ) {
				$allProducts = array();
				foreach ($categ as $cat) {
					$product = Products::select('products.*')
						->whereRaw("category LIKE '%$cat%' AND ".self::query())
						->orderByRaw("$sortQuery")
						->join('product_variations', 'product_variations.pid', 'products.pid')
						->take($limit)->offset($offset)
						->groupBy('product_variations.pid')->get();
					foreach ($product as $pro) {
						array_push($allProducts, $pro);
					}
				}

			}
			$allProductsCount = count($allProducts);
		} else if($theDeals == 'recently_added') {
			$allProducts = Products::select('products.*')
			->take($limit)->offset($offset)->whereRaw(self::query())
			->join('product_variations', 'product_variations.pid', 'products.pid')
			->groupBy('product_variations.pid')
			->orderByRaw("products.pid DESC")
			->get();

			$allProductsCount = count($allProducts);
		} else if($theDeals == 'recently_added'){

		}


		$categoryVarss = array();
		$newAllProducts = array();
		foreach ($allProducts as $product) {
			$product['variation'] = ProductVariation::singleByPid($product->pid);
			$product['isFavorite'] = SavedProductsTbl::isFavorite($product->pid, $loginID);

			$categoryVar = CategoryVariation::getCategory(explode(',', str_replace(' ', '', $product->category))[0]);

			array_push($newAllProducts, $product);
			array_push($categoryVarss, $categoryVar);
		}



		$result = array(
			'data' => $newAllProducts, 
			'count' => $allProductsCount, 
			'categories' => CategoryTbl::get(), 
			'subcategories' => CategoriesChild::get(), 
			'subChildcategories' => CategoriesSubChild::get(), 
			'cat_variation' => $categoryVarss
		);
		self::printResult($result);
	}


	private function query(){
		$aquery = '';
		$dQuery = "";
		if (Input::get('discount')) {
			$discountRange = array_filter(explode('-', Input::get('discount')));
			$firster = intval($discountRange[0]);
			$seconder = intval($discountRange[1]);
			$dQuery .= " (product_variations.discount >= $firster AND product_variations.discount <= $seconder)";
		}

		if (Input::get('category')) {
			$categories = array_filter(explode('~', Input::get('category')));
			foreach ($categories as $value) {
				if ($dQuery) {
					$dQuery .= " OR (products.category LIKE '%$value%')";
				} else {
					$dQuery .= " (products.category LIKE '%$value%')";
				}
			}
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

		// self::printResult($dQuery);
		

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

		if ($dQuery) {
			$aquery .= "($dQuery)";
		}
		
		// print_r($aquery);
		// exit();
		$mainQuery = "products.status='Active'";
		if ($aquery) {
			$mainQuery = "products.status='Active' AND ";
		}
		
		return $mainQuery.' '.$aquery;
	}








}
?>