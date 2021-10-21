<?php
	class Product {
		
		public function __construct(){		
		}

		public Static function item($pid){
			return ProductTbl::where('pid', $pid)->get()->first();
		}

		public Static function items($username=null, $take=null, $offset=null, $keywords=null){
			$uInfo = User::uSingle(null, $username);

			//
			if($keywords!=null){
				$results = ProductTbl::take($take)->offset($offset)
					->whereRaw("CONCAT(p_category, p_name, p_tags, p_desc, features) 
					LIKE '%$keywords%'")
					->where('p_status', 'Active')
					->orderBy('pid', 'DESC')->get();
			}
			elseif($username!=null && $take!=null && $offset!=null){
				$results = ProductTbl::take($take)->offset($offset)
					->where('login_id', $uInfo->login_id)
					->where('p_status', 'Active')
					->orderBy('pid', 'DESC')->get();
			}
			elseif($username!=null && $take!=null){
				$results = ProductTbl::take($take)->where('login_id', $uInfo->login_id)
					->where('p_status', 'Active')
					->orderBy('pid', 'DESC')->get();
			}
			elseif($take!=null && ($offset==0 || $offset!=null || $offset!='')){
				$results = ProductTbl::take($take)->offset($offset)
					->where('p_status', 'Active')
					->orderBy('pid', 'DESC')->get();
			}
			elseif($take!=null){
				$results = ProductTbl::take($take)
					->where('p_status', 'Active')
					->orderBy('pid', 'DESC')->get();
			}
			else{
				$results = array();
			}

			return $results;
		}

		public Static function itemsCnts($username=null, $keywords=null){
			//Grab user info
			$uInfo = User::uSingle(null, $username);

			if($keywords!=null){	
				$results = ProductTbl::whereRaw("CONCAT(p_category, p_name, p_tags, p_desc, features) LIKE '%$keywords%'")
					->where('p_status', 'Active')->count();
			}
			elseif($username!=null){	
				$results = ProductTbl::where('login_id', $uInfo->login_id)
					->where('p_status', 'Active')->count();
			}
			else{
				$results = ProductTbl::where('p_status', 'Active')->count();
			}

			return $results;
		}


		public Static function userItems($loginID, $take=null, $offset=null){
			if($take){	
				$results = ProductTbl::take($take)->offset($offset)
					->where('login_id', $loginID)
					->orderBy('pid', 'DESC')->get();
			}
			else{
				$results = ProductTbl::where('login_id', $loginID)
					->orderBy('pid', 'DESC')->get();
			}

			return $results;
		}

		public Static function userItemsCnt($loginID){
			return ProductTbl::where('login_id', $loginID)->count();
		}

		public Static function itemImgs($pid){
			return Product_image::where('pid', $pid)->get();
		}

		public Static function itemImg($pid){
			return Product_image::where('pid', $pid)->get()->first();
		}

		public Static function imgSingle($imgID){
	        return Product_image::where('img_id', $imgID)->get()->first();
	    }

		public Static function freelanceCategory(){
			return CategoryTbl::where('role', 'Freelance')->orderBy('cat_id', 'ASC')->get();
		}

		public Static function productCategory(){
			return CategoryTbl::where('role', '!=', 'Freelance')->orderBy('cat_id', 'ASC')->get();
		}

		public Static function categorySlug($slug){
			$results = CategoryTbl::where('cat_slug', $slug)->first();
			if(!$results){
				$results = Subcategory::where('subcat_slug', $slug)->first();
			}
			
			return $results;
		}

		public Static function recentViews($loginID){
			return Recent_views::whereRaw("login_id=$loginID AND id 
						IN (SELECT max(id) FROM recent_views
					GROUP BY pid, role)
					ORDER BY created_at DESC LIMIT 15")->get();
		}

		public Static function itemSalesCnt($pid){
			return Orders::where('pid', $pid)->count();
		}



		public Static function editItems($username, $take=null, $offset=null){
			$uInfo = User::uSingle(null, $username);
			
			if($take!=null && $offset!=null){
				$results = ProductTbl::take($take)->offset($offset)
					->where('login_id', $uInfo->login_id)
					->orderBy('pid', 'DESC')->get();
			}
			elseif($take!=null){
				$results = ProductTbl::take($take)->where('login_id', $uInfo->login_id)
					->orderBy('pid', 'DESC')->get();
			}

			return $results;
		}

		public Static function editItemsCnts($username){
			//Grab user info
			$uInfo = User::uSingle(null, $username);
			return $results = ProductTbl::where('login_id', $uInfo->login_id)->count();
		}




		//Admin uses
		public Static function allItems($take=null, $offset=null){
			if($take!=null && ($offset==0 || $offset!=null || $offset!='')){
				$results = ProductTbl::take($take)->offset($offset)->orderBy('pid', 'DESC')->get();
			}
			elseif($take!=null){
				$results = ProductTbl::take($take)->orderBy('pid', 'DESC')->get();
			}
			else{
				$results = ProductTbl::orderBy('pid', 'DESC')->get();
			}

			return $results;
		}


		
	}
?>