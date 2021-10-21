<?php
	/**
	 * this class is the default controller of our application,
	 * 
	*/
	class dashboard extends controller{
		public function __construct(){
			$this->middleware('administrator')->mustbe_loggedin();
		}

		//Default load function
		public function index(){
			/*echo Investments::usdInvestments();
			exit();*/
			$this->view('administrator/dashboard',[
				'allUser' => User::count(),
				'allSeller' => Seller::count(),
				'allOrder' => OrdersTbl::count(),
				'recentAddedPro' => Products::adminRecentAdded(),
				'curr' => CurrencyTbl::getDefault(),
				'recentOrder' => OrdersTbl::recentAdminOrder()
			]);
		}

		
	}

?>