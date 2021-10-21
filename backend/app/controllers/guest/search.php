<?php
class search extends controller
{
	private $pageLimit = 12;


	public function __construct(){
	}

	public function index($root=null, $category, $keywords=null, $limit=20, $page=1, $token=null, $sort=''){
		$isAuth = HeadersControl::optionRequest($token);
		$loginID = $isAuth['loginID'] ? $isAuth['loginID'] : null;

		if($limit > 0){$this->pageLimit = $limit;}

		if(!$page){
			$page = 1; $offset = 0;
		}
		else{				
			$offset = $this->pageLimit * ($page - 1);
		}
		// print_r(self::query($keywords, $category));
		// exit();

		$sortQuery = "products.pid ASC";
		if ($sort) {
			if (strtolower($sort) == 'asc') {
				$sortQuery = "product_variations.sales_price ASC";
			} else {
				$sortQuery = "product_variations.sales_price DESC";
			}
		}

		$products = Products::select('products.*')
			->take($limit)->offset($offset)
			->whereRaw(self::query($keywords, $category))
			->join('product_variations', 'product_variations.pid', 'products.pid')
			->groupBy('products.pid')
			->orderByRaw("$sortQuery")
			->get();

		$allProductsCount = Products::select('products.*')
			->whereRaw(self::query($keywords, $category))
			->join('product_variations', 'product_variations.pid', 'products.pid')
			->groupBy('products.pid')
			->get()->count();
		
		$newAllProducts = array();
		$categories = array();
		$catFilter = array();


		$categoryVarss = array();
		foreach ($products as $product) {
			$category = explode(',', str_replace(' ', '', $product->category))[0];
			$product['variation'] = ProductVariation::singleByPid($product->pid);
			$product['isFavorite'] = SavedProductsTbl::isFavorite($product->pid, $loginID);
			$categoryVar = CategoryVariation::getCategory(explode(',', str_replace(' ', '', $product->category))[0]);

			if (!in_array($category, $catFilter)) {
				array_push($catFilter, $category);
				array_push($categories, CategoryTbl::mainCats($category));
			}
			array_push($newAllProducts, $product);
			array_push($categoryVarss, $categoryVar);
		}

		$products = array(
			'data' => $newAllProducts, 
			'count' => $allProductsCount,
			'sidebarCategories' => $categories,
			'categoryTitle' => 'Category',
			// 'categoryVariations' => CategoryVariation::getCategoryVariations($category),
			'categoryBanner' => null,
			'cat_variation' => $categoryVarss
		);

		self::printResult($products);
	}


	private function query($keywords, $category){
		$aquery = '';
		$dQuery = "";
		$urlQueryStr = explode("&", $_SERVER['QUERY_STRING']);
		array_splice($urlQueryStr, 0, 1);

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
					$dQuery .= " OR (products.category LIKE '%$value%' AND (products.name LIKE '%$keywords%' OR products.tags LIKE '%$keywords%' OR products.brand LIKE '%$keywords%' OR products.category LIKE '%$keywords%'))";
				} else {
					$dQuery .= " (products.category LIKE '%$value%' AND (products.name LIKE '%$keywords%' OR products.tags LIKE '%$keywords%' OR products.brand LIKE '%$keywords%' OR products.category LIKE '%$keywords%'))";
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


		// if ($category && $category != 'all') {
		// 	if ($dQuery) {
		// 		$dQuery .= " AND products.category LIKE '%$category%'";
		// 	} else {
		// 		$dQuery .= "products.category LIKE '%$category%'";
		// 	}
		// }

		foreach ($urlQueryStr as $qValue) {
			$nValue = explode('=', $qValue);
			$name =  str_replace('_', ' ', $nValue[0]);
			$vValue = $nValue[1];
			$urlQueryValues = array_filter(explode('~', $vValue));

			foreach ($urlQueryValues as $key => $value) {
				$value = str_replace('_', ' ', $value);
				if ($dQuery) {
					$dQuery .= " OR (product_variations.name='$name' AND product_variations.value='$value')";
				} else {
					$dQuery .= " (product_variations.name='$name' AND product_variations.value='$value')";
				}
			}
		}

	
		if ($dQuery) {
			$dQuery .= " AND (products.name LIKE '%$keywords%' OR products.tags LIKE '%$keywords%' OR products.brand LIKE '%$keywords%' OR products.category LIKE '%$keywords%')";
		} else {
			$dQuery .= "(products.name LIKE '%$keywords%' OR products.tags LIKE '%$keywords%' OR products.brand LIKE '%$keywords%' OR products.category LIKE '%$keywords%')";
		}

		if ($category && $category != 'all') {
			if ($dQuery) {
				$aquery .= "($dQuery) AND (products.category LIKE '%$category%')";
			} else {
				$aquery .= " (products.category LIKE '%$category%')";
			}
		} else {
			if ($dQuery) {
				$aquery .= "($dQuery) ";
			} else {
				$aquery .= " ";
			}
		}


		// if ($dQuery) {
		// 	$aquery .= "($dQuery) AND (products.name LIKE '%$keywords%' OR products.tags LIKE '%$keywords%' OR products.brand LIKE '%$keywords%' OR products.category LIKE '%$keywords%')";
		// } else {
		// 	$aquery .= "(products.name LIKE '%$keywords%' OR products.tags LIKE '%$keywords%' OR products.brand LIKE '%$keywords%' OR products.category LIKE '%$keywords%')";
		// }
		


		$mainQuery = "products.status='Active'";
		if ($aquery) {
			$mainQuery = "products.status='Active' AND ";
		}
		// print_r($mainQuery.' '.$aquery);
		// exit();

		return $mainQuery.' '.$aquery;
	}


	private function results($keyword, $offset){
		return Products::take($this->pageLimit)->offset($offset)
			->selectRaw(self::selectOpt())
			->whereRaw(self::query(self::validateQuery($keyword)))
			->orderBy('updated_at', 'DESC')->get();
	}

	private function resultCnts($keyword){
		return Products::selectRaw(self::selectOpt())
			->whereRaw(self::query(self::validateQuery($keyword)))->count();
	}

	private function selectOpt(){
		return "pid, category, name, brand, regular_price, sales_price, discount, featured_img";
	}

	// private function query($validatedQuery){
	// 	return "status='Active' AND ($validatedQuery)";
	// }

	private function printResult($results) {
		print_r(json_encode($results));
		exit();
	}

	private function validateQuery($keyword){
		$keyword = rtrim($keyword, "-");
		$keyValue = str_replace('-', ' ', $keyword);
		$tempAry = explode('-', $keyword);
		$isMore = (count($tempAry) > 1) ? ' OR ' : '';

		$queryKeyword = self::searchQuery($keyValue, $isMore);

		if (count($tempAry) > 1) {
			$i = 0;
			foreach ($tempAry as $value) {
				$i++;
				$temp = (count($tempAry) > 1 AND $i < count($tempAry)) ? ' OR ' : '';
				$queryKeyword = $queryKeyword .self::searchQuery($value, $temp);
			}
		}

		return $queryKeyword;
	}

	private function searchQuery($keyword, $addon){
		return "(category LIKE '%$keyword%' OR 
					tags LIKE '%$keyword%' OR 
					name LIKE '%$keyword%' OR 
					brand LIKE '%$keyword%' OR 
					overview LIKE '%$keyword%'
				) $addon ";
	}

}
?>