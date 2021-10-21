<?php
	/**
	 * this class is the default controller of our application,
	 * 
	*/ 
	class home_product extends controller{
		public function __construct(){
			$this->middleware('administrator')->mustbe_loggedin();
		}

		public function index(){
			$this->view('administrator/home-product', [
				'home_pro' => HomeProductTbl::first()
			]);
		}


		public function shop_by_country(){
			$this->view('administrator/shop-by-country', [
				'home_pro' => HomeProductTbl::first(),
				'countries' => Countries::getAll(),
				'shopByCountry' => ShopByCountry::get()
			]);
		}

		public function add_country(){
			$country = Input::get("country");
			if ($_FILES['countryImg']['name']) {
				$options = array('folder' => 'country_img/', 'name'  => $country);
	        	$countryImg = Images::fileUpload($_FILES['countryImg'], $options)['original'];
			}

			$check = ShopByCountry::count();

			if ($check == 4) {
				Redirect::to(Config::ADMIN_BASE_URL().'home_product/shop_by_country?status=error');
			} else {
				$add = ShopByCountry::addCountry($country, $countryImg);

				if ($add) {
					Redirect::to(Config::ADMIN_BASE_URL().'home_product/shop_by_country?status=success');
				}
			}

		}

		public function delete_country(){
			$shopByID = Input::get("shopByID");

			$del = ShopByCountry::deleteRow($shopByID);
			if ($del) {
				Redirect::to(Config::ADMIN_BASE_URL().'home_product/shop_by_country?status=delete');
			}
		}



		public function three_grid_image(){
			$this->view('administrator/three-grid-img', [
				'getAll' => HomeBanners::getAll(),
				'home_pro' => HomeProductTbl::first(),
			]);
		}

		public function addGrimImage(){
			$url = Input::get("url");
			if ($_FILES['gridImg']['name']) {
				$options = array('folder' => 'slides/', 'name'  => 'right_banner');
	        	$gridImg = Images::fileUpload($_FILES['gridImg'], $options)['original'];
			}

			$create = HomeBanners::creatRow($url, $gridImg);

			if ($create) {
				Redirect::to(Config::ADMIN_BASE_URL().'home_product/three_grid_image?status=success');
			}
		}

		public function delete_grid_img(){
			$gridID = Input::get("bannerID");

			$del = HomeBanners::deleteRow($gridID);
			if ($del) {
				Redirect::to(Config::ADMIN_BASE_URL().'home_product/three_grid_image?status=delete');
			}
		}


		public function status_action(){
			// print_r(Input::all());
			// exit();
			$product_type = Input::get("product_type");
			$action = Input::get("action");
			$home = Input::get("home");

			$update = HomeProductTbl::setAction($product_type, $action);

			if ($update) {
				if ($home) {
					Redirect::to(Config::ADMIN_BASE_URL().'home_product/?action='.$product_type);
				} else {
					Redirect::to(Config::ADMIN_BASE_URL().'home_product/'.$product_type.'?action=success');
				}
				
			}
		}


		// LIVE STREAM
		public function live_stream(){
			$this->view('administrator/live-stream', [
				'home_pro' => HomeProductTbl::first(),
				'allVideos' => VideoStreamTbl::get()
			]);
		}



		public function add_live_stream(){
			$title = Input::get('title');
			$type = Input::get('video_type');

			if ($type == 'youtube') {
				$url = str_replace('https://www.youtube.com/embed/', '', str_replace('http://www.youtube.com/embed/', '', Input::get('video_url')));
			} else {
				$options = array(
		            'folder' => 'video/',
		            'name'  => $title,
		        );

		        $url = Images::fileUpload($_FILES['local_vid'], $options)['original'];
			}

			$add = VideoStreamTbl::createRow($title, $type, $url);

			if ($add) {
				Redirect::to(Config::ADMIN_BASE_URL().'home_product/live_stream?status=added');
			}
		}

		public function delete_vid(){
			$vidID = Input::get("vidID");

			$dele = VideoStreamTbl::deletVid($vidID);
			if ($dele) {
				Redirect::to(Config::ADMIN_BASE_URL().'home_product/live_stream?status=delete');
			}
		}




		// FEATURE PRODUCT BANNER
		public function feature_product_banner(){
			$this->view('administrator/home-feature-product-banner', [
				'home_pro' => HomeProductTbl::first(),
				'category' => CategoryTbl::get(),
				'getFirst' => FeatureProductBanner::first()
			]);
		}

		public function update_feat_pro_banner(){
			$category = Input::get('category');
			$proNum = Input::get('no_of_pro');
			$id = Input::get('id');

			$banner = Input::get("defBanner");
			if ($_FILES['gridImg']['name']) {
				$options = array(
		            'folder' => 'featPro/',
		            'name'  => $category,
		        );

		        $banner = Images::fileUpload($_FILES['gridImg'], $options)['original'];
			}

			$update = FeatureProductBanner::updateRow($id, $category, $banner, $proNum);
			if ($update) {
				Redirect::to(Config::ADMIN_BASE_URL().'home_product/feature_product_banner?status=update');
			}
		}




		



	}

?>