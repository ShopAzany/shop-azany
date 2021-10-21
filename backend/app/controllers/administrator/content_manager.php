<?php
	/** 
	 * this class is the default controller of our application,
	 * 
	*/
	class content_manager extends controller{
		public function __construct(){
			$this->middleware('administrator')->mustbe_loggedin();
		}

		

		public function home_slider(){
			print_r($result);
			$this->view('administrator/home-slide', [
				'slides' => HomeSlider::getAll(),
				'rightBanner' => HomeBanners::first(),
			]);
		}

		public function delete_slide(){
			$delID = Input::get('slideID');
			$delete = HomeSlider::where('id', $delID)->delete();
			if ($delete) {
				Redirect::to(Config::ADMIN_BASE_URL().'content_manager/home_slider?delete=success');
			}
		}


		public function add_slider(){
			$title = Input::get('title');
			$url = Input::get('url');
			$descr = Input::get('descr');
			$options = array(
	            'folder' => 'slides/',
	            'name'  => 'banner'
	        );

	        $banner = Images::fileUpload($_FILES['banner'], $options)['original'];

			$result = HomeSlider::create([
				'title' => $title,
				'url' => $url,
				'banner' => $banner,
				'descr' => $descr,
			]);
			if ($result) {
				Redirect::to(Config::ADMIN_BASE_URL().'content_manager/home_slider?added=success');
			} else {
				Redirect::to(Config::ADMIN_BASE_URL().'content_manager/home_slider?added=failed');
			}
		}


		public function update_home_right_banner(){
			$banner_top_link = Input::get('banner_top_link');
			$banner_bottom_link = Input::get('banner_bottom_link');
			$id = Input::get('id');

			$rightBannerTop = Input::get("defHomeRightTop");
			if ($_FILES['home_right_banner_top']['name']) {
				$options = array('folder' => 'slides/', 'name'  => 'right_banner');
	        	$rightBannerTop = Images::fileUpload($_FILES['home_right_banner_top'], $options)['original'];
			}

			$rightBannerBottom = Input::get("defHomeRightBottom");
			if ($_FILES['home_right_banner_bottom']['name']) {
				$options = array('folder' => 'slides/', 'name'  => 'right_banner');
	        	$rightBannerBottom = Images::fileUpload($_FILES['home_right_banner_bottom'], $options)['original'];
			}

			$send = array(
				'id' => $id,
				'banner_top' => $rightBannerTop,
				'banner_bottom' => $rightBannerBottom,
				'banner_top_link' => $banner_top_link,
				'banner_bottom_link' => $banner_bottom_link,
			);

			// print_r($send);
			// exit();
			$update = HomeBanners::updateRecord($send);

			if ($update) {
				Redirect::to(Config::ADMIN_BASE_URL().'content_manager/home_slider?added=right_banner');
			}
		}

		public function edit_slider($id){
			$get = HomeSlider::singleRecord($id);

			if ($get && $get->id == $id) {
				$this->view("administrator/home-slide-edit", [
					'slide' => $get
				]);
			}
		}


		public function updateSlide(){
			$title = Input::get('title');
			$url = Input::get('url');
			$descr = Input::get('descr');

			$banner = Input::get('img');
			$id = Input::get('id');
			if ($_FILES['banner']['name']) {
				$options = array('folder' => 'slides/', 'name'  => 'banner');
	        	$banner = Images::fileUpload($_FILES['banner'], $options)['original'];
			}
			
			$result = HomeSlider::where('id', $id)->update([
				'title' => $title,
				'url' => $url,
				'banner' => $banner,
				'descr' => $descr,
			]);
			if ($result) {
				Redirect::to(Config::ADMIN_BASE_URL().'content_manager/edit_slider/'.$id.'?update=success');
			} else {
				Redirect::to(Config::ADMIN_BASE_URL().'content_manager/edit_slider/'.$id.'?update=failed');
			}
		}





		// PAGES
		public function all_pages(){
			$this->view("administrator/all-pages", [
				'allPages' => PageTbl::get(),
			]);
		}

		public function edit_page($id){
			$page = PageTbl::where('id', $id)->first();
			if ($page) {
				$this->view('administrator/edit-page', [
					'page' => $page
				]);
			}
		}


		public function update_page(){
			$pageID = Input::get("pageID");
			$title = Input::get("title");
			$sub_title = Input::get("sub_title");
			$contents = Input::get("contents");
			$status = Input::get("status");

			$update = PageTbl::where('id', $pageID)->update([
				'title' => $title,
				'overview' => $sub_title,
				'contents' => $contents,
				'status' => $status,
			]);

			if ($update) {
				Redirect::to(Config::ADMIN_BASE_URL().'content_manager/edit_page/'.$pageID.'?update=success');
			} else {
				Redirect::to(Config::ADMIN_BASE_URL().'content_manager/edit_page/'.$pageID.'?update=failed');
			}
		}





		// MANAGE MENU
		public function manage_menu(){
			$this->view("administrator/manage-menu", [
				'categories' => CategoryTbl::get(),
				'pages' => PageTbl::get(),
				'menus' => Menus::allRecords()
			]);
		}


		public function add_menu(){
			$cat = Input::get("category");
			$role = Input::get("role");
			$add = Menus::createdRecord($cat, $role);
			if ($add) {
				Redirect::to(Config::ADMIN_BASE_URL().'content_manager/manage_menu?menu=success');
			}
		}

		public function add_page(){
			$page = Input::get("page");
			$role = Input::get("role");
			$add = Menus::createdRecord($page, $role);
			if ($add) {
				Redirect::to(Config::ADMIN_BASE_URL().'content_manager/manage_menu?page=success');
			}
		}

		public function delete_menu(){
			$menuID = Input::get("menuID");

			$del = Menus::where('id', $menuID)->delete();
			if ($del) {
				Redirect::to(Config::ADMIN_BASE_URL().'content_manager/manage_menu?delete=success');
			}
		}




		// EMAIL TEMPLATE
		public function email_template(){
			$this->view("administrator/email-template", [
				'emails' => Email_templates::get(),
			]);
		}


		public function edit_email_template($emailID){
			$getEmail = Email_templates::where('id', $emailID)->first();
			if ($getEmail && $getEmail->id == $emailID) {
				$this->view("administrator/email-template-edit", [
					'email' => $getEmail
				]);
			}
		}

		public function update_email_template(){
			$title = Input::get("title");
			$emailID = Input::get("emailID");
			$content = Input::get("content");
			$footer = Input::get("footer");

			$update = Email_templates::where('id', $emailID)->update([
				'title' => $title,
				'content' => $content,
				'footer' => $footer,
			]);
			if ($update) {
				Redirect::to(Config::ADMIN_BASE_URL().'content_manager/edit_email_template/'.$emailID.'?update=success');
			}
		}





		// BRANDS
		public function brands(){
			$this->view('administrator/brands', [
				'allBrands' => BrandTbl::orderBy('id', 'DESC')->get(),
			]);
		}



		public function add_brand(){
			$name = Input::get('name');
			$options = array(
	            'folder' => 'slides/',
	            'name'  => 'banner'
	        );

	        $banner = Images::fileUpload($_FILES['image'], $options)['original'];

	        $create = BrandTbl::create([
	        	'name' => $name,
	        	'image' => $banner
	        ]);
	        if ($create) {
	        	Redirect::to(Config::ADMIN_BASE_URL().'content_manager/brands?add=success');
	        }
		}

		public function deleteBrand(){
			$brID = Input::get('brID');
			$delete = BrandTbl::where('id', $brID)->delete();
			if ($delete) {
				Redirect::to(Config::ADMIN_BASE_URL().'content_manager/brands?delete=success');
			}
		}


		// ADVERTS
		public function adverts(){
			$this->view('administrator/adverts', [
				'homeAds' => AdvertTbl::homeAds(),
			]);
		}


		public function updateAdvert(){
			$id = Input::get("id");
			$title = Input::get("title");
			$content = Input::get("content");
			$status = Input::get("status");

			$options = array(
	            'folder' => 'ads/',
	            'name'  => $title
	        );
			$image = Images::fileUpload($_FILES['image'], $options)['original'];

	        $update = AdvertTbl::where('id', $id)->update([
	        	'title' => $title,
	        	'content' => $content,
	        	'image' => $image,
	        	'status' => $status
	        ]);

	        if ($update) {
				Redirect::to(Config::ADMIN_BASE_URL().'content_manager/adverts?update=success');
			}
		}




		// SELLER CONTENTS
		public function seller_content(){
			$this->view('administrator/seller-content', [
				'ban' => SellerContent::bannerInfo(),
				'howItWorks' => SellerContent::howItWorks(),
				'explore' => SellerContent::exploreInfo(),
			]);
		}


		public function updateSellInfo(){
			$id = Input::get('id');
			$title = Input::get('title');
			$sub_title = Input::get('sub_title');

			$banner = Input::get("default_banner");
			if ($_FILES['banner']['name']) {
				$options = array('folder' => 'seller_content/', 'name'  => 'image');
	        	$banner = Images::fileUpload($_FILES['banner'], $options)['original'];
			}

			$toUpdate = array(
				'id' => $id, 
				'title' => $title, 
				'sub_title' => $sub_title, 
				'banner' => $banner, 
			);
			$update = SellerContent::updateInfo($toUpdate);
			if ($update) {
				Redirect::to(Config::ADMIN_BASE_URL().'content_manager/seller_content?update=success');
			}
		}


		public function add_how_it_work(){
			$title = Input::get('title');
			$sub_title = Input::get('sub_title');

			if ($_FILES['banner']['name']) {
				$options = array('folder' => 'seller_content/', 'name'  => 'how-it-work');
	        	$banner = Images::fileUpload($_FILES['banner'], $options)['original'];
			}
			$addArray = array(
				'title' => $title,
				'sub_title' => $sub_title, 
				'banner' => $banner, 
			);
			$addNow = SellerContent::addHowItWork($addArray);
			if ($addNow) {
				Redirect::to(Config::ADMIN_BASE_URL().'content_manager/seller_content?update=add');
			}
		}

		public function deleteHowWork(){
			$id = Input::get('howID');
			$del = SellerContent::deleteRow($id);
			if ($del) {
				Redirect::to(Config::ADMIN_BASE_URL().'content_manager/seller_content?delete=success');
			}
		}



		public function get_how_work_detail($id) {
			$how = SellerContent::single($id);

			$result = "";

			if ($how) {

				$result = '1|'.$how->title.'|'.$how->sub_title.'|'.$how->banner.'|'.$how->id;

			} else {
				$result = "Please select payment method";
			}
			print_r($result);
			exit();
		}





		//WHY CHOSE US
		public function why_chose_us(){
			$this->view('administrator/why-chose-us', [
				'whyUs' => WhyChoseUsTbl::get()
			]);
		}

		public function addWhyChoseUs(){
			$title = Input::get('title');
			$svg = Input::get('svg');
			$content = Input::get('content');

			$send = array(
				'title' => $title, 
				'svg' => $svg, 
				'content' => $content, 
			);

			$create = WhyChoseUsTbl::createRow($send);
			if ($create) {
				Redirect::to(Config::ADMIN_BASE_URL().'content_manager/why_chose_us?status=added');
			}
		}


		public function updateWhyChoseUs(){
			$id = Input::get('id');
			$title = Input::get('title');
			$svg = Input::get('svg');
			$content = Input::get('content');

			$send = array(
				'id' => $id, 
				'title' => $title, 
				'svg' => $svg, 
				'content' => $content, 
			);

			$create = WhyChoseUsTbl::updateRow($send);
			if ($create) {
				Redirect::to(Config::ADMIN_BASE_URL().'content_manager/why_chose_us?status=updated');
			}
		}

		public function deleteWhyChoseUs(){
			$id = Input::get('id');
			$del = WhyChoseUsTbl::deleteRow($id);
			if ($del) {
				Redirect::to(Config::ADMIN_BASE_URL().'content_manager/why_chose_us?status=deleted');
			}
		}


		public function get_why_chose_us($id) {
			$why = WhyChoseUsTbl::singleRow($id);

			$result = "";

			if ($why) {

				$result = '1|'.$why->title.'|'.$why->svg.'|'.$why->content.'|'.$why->id;

			} else {
				$result = "Please select payment method";
			}
			print_r($result);
			exit();
		}



		public function about_us(){
			$this->view('administrator/about-us', [
				'about' => AboutUsTbl::first()
			]);
		}


		public function update_about_us(){
			$id = Input::get('id');
			$title = Input::get('title');
			$sub_title = Input::get('sub_title');
			$vision = Input::get('vision');
			$mission = Input::get('mission');
			$what_we_do = Input::get('what_we_do');
			$who_we_serve = Input::get('who_we_serve');

			$title_image = Input::get('default_title_image');
			if ($_FILES['title_image']['name']) {
				$options = array('folder' => 'images/', 'name'  => $title);
	        	$title_image = Images::fileUpload($_FILES['title_image'], $options)['original'];
			}

			$what_we_do_image = Input::get('default_what_we_do_image');
			if ($_FILES['what_we_do_image']['name']) {
				$options = array('folder' => 'images/', 'name'  => $title);
	        	$what_we_do_image = Images::fileUpload($_FILES['what_we_do_image'], $options)['original'];
			}

			$vision_image = Input::get('default_vision_image');
			if ($_FILES['vision_image']['name']) {
				$options = array('folder' => 'images/', 'name'  => $title);
	        	$vision_image = Images::fileUpload($_FILES['vision_image'], $options)['original'];
			}

			$update = AboutUsTbl::where('id', $id)->update([
				'title'  =>  $title,
				'sub_title'  =>  $sub_title,
				'vision'  =>  $vision,
				'mission'  =>  $mission,
				'what_we_do'  =>  $what_we_do,
				'who_we_serve'  =>  $who_we_serve,
				'title_image'  =>  $title_image,
				'what_we_do_image'  =>  $what_we_do_image,
				'vision_image'  =>  $vision_image,
			]);

			if ($update) {
				Redirect::to(Config::ADMIN_BASE_URL().'content_manager/about_us?update=success');
			}
		}


		public function faq(){
			$this->view('administrator/faq', [
				'faqs' => FaqTbl::get()
			]);
		}


		public function add_faq(){
			$question = Input::get('question');
			$answer = Input::get('answer');

			$add = FaqTbl::createRow($question, $answer);

			if ($add) {
				Redirect::to(Config::ADMIN_BASE_URL().'content_manager/faq?add=success');
			}
		}

		public function get_faq($id) {
			$faq = FaqTbl::single($id);

			$result = "";

			if ($faq) {

				$result = '1|'.$faq->id.'|'.$faq->question.'|'.$faq->answer.'|'.$faq->status;

			} else {
				$result = "No result available";
			}
			print_r($result);
			exit();
		}


		public function update_faq(){
			$id = Input::get('id');
			$question = Input::get('question');
			$answer = Input::get('answer');
			$status = Input::get('status');

			$update = FaqTbl::updateRow($id, $question, $answer, $status);

			if ($update) {
				Redirect::to(Config::ADMIN_BASE_URL().'content_manager/faq?update=success');
			}
		}


		public function delete_faq(){
			$id = Input::get('id');

			$delFaq = FaqTbl::deleteRow($id);

			if ($delFaq) {
				Redirect::to(Config::ADMIN_BASE_URL().'content_manager/faq?delete=success');
			}
		}



		public function welcome_email(){
			// $user = User::where('login_id', 1)->first();
			// $test = EmailNote::welcomeEmail($user);

			
			// print_r($test);
			// exit();
			// $this->view('administrator/email-welcome');
		}


		public function email_receipt(){

			// $inv = Invoices::singleOrder(7);
			// $shipCost = Invoices::sumShippingCost($inv->order_number);

			// $orders = OrdersTbl::generateInvoiceOrders($inv->order_number, 51);
			// $user = User::where('login_id', 51)->first();

			// $orderInfo = array(
			// 	'subtotal' => $inv->total,
			// 	'shipping_cost' => $shipCost,
			// 	'tax' => 0.0,
			// 	'total' => $inv->total + $shipCost,
			// 	'email' => $user->email,
			// 	'full_name' => $user->full_name,
			// 	'order_number' => $inv->order_number
			// );
			
			// $rec = Products::take(3)->orderBy('pid', 'DESC')->get();
			// $recommended = array();
			// foreach ($rec as $value) {
			// 	$value['pro_var'] = ProductVariation::firstProdID($value->pid);
			// 	array_push($recommended, $value);
			// }

			// $test = EmailNote::orderConfirmation($orderInfo, $orders, $recommended);

			
			// print_r($test);
			// exit();


			// $this->view('administrator/email-receipt');
		}



	}

?>