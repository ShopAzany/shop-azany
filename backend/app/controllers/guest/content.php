<?php
	class content extends controller{
		
		public function __construct(){
		}


		public function index(){
			HeadersControl::guest('holder');
			$result = array(
				'about' => AboutUsTbl::first(),
				'brands' => BrandTbl::get(),
			);
			self::printResult($result);
		}


		public function single($root, $subroot, $url){
			HeadersControl::guest('holder');

			$contents = PageTbl::single($url);
			self::printResult($contents);
		}

		public function faq(){
			HeadersControl::guest('holder');

			self::printResult(FaqTbl::getForGuest());
		}


		public function seller_content(){
			HeadersControl::guest('holder');

			$result = array(
				'banner_info' => SellerContent::bannerInfo(),
				'how_it_work' => SellerContent::howItWorks(),
				'explore' => SellerContent::exploreInfo()
			);

			self::printResult($result);
		}

		private function printResult($result){
			print_r(json_encode($result));
			exit();
		}

	}

?>