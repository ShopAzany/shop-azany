<?php
	/** 
	 * this class is the default controller of our application,
	 * 
	*/
	class general_settings extends controller{
		public function __construct(){
			$this->middleware('administrator')->mustbe_loggedin();
		}

		//Default load function
		public function website_settings(){
			$this->view('administrator/website-settings', [
				'webSettting' => WebsiteSettings::first()
			]);
		}

		public function website_update(){
			$id = Input::get('webID') ?: null;
			$biz_name = Input::get('biz_name');
			$site_name = Input::get('site_name');
			$site_title = Input::get('site_title');
			$site_email = Input::get('site_email');
			$site_description = Input::get('site_description');
			$site_url = Input::get('site_url');
			$biz_phone = Input::get('biz_phone');
			$biz_addr = Input::get('biz_addr');
			$biz_city = Input::get('biz_city');
			$biz_state = Input::get('biz_state');
			$biz_country = Input::get('biz_country');
			$copyright = Input::get('copyright');

			$logo_url = Input::get('default_logo');
			if ($_FILES['logo_url']['name']) {
				$options = array('folder' => 'images/', 'name'  => 'logo');
	        	$logo_url = Images::fileUpload($_FILES['logo_url'], $options)['original'];
			}

			$favicon_url = Input::get('default_favicon');
			if ($_FILES['favicon_url']['name']) {
				$options = array('folder' => 'images/', 'name'  => 'logo');
	        	$favicon_url = Images::fileUpload($_FILES['favicon_url'], $options)['original'];
			}

			$gonow = WebsiteSettings::where('id', 1)->update([
				'biz_name' 			=> $biz_name, 
				'site_name' 				=> $site_name, 
				'site_title' 			=> $site_title, 
				'site_email' 			=> $site_email, 
				'site_url' 				=> $site_url, 
				'biz_phone' 			=> $biz_phone,
				'biz_addr' 			=> $biz_addr,
				'biz_city' 				=> $biz_city,
				'biz_state' 			=> $biz_state,
				'biz_country' 			=> $biz_country,
				'site_description' 		=> $site_description, 
				'favicon_url' 		=> $favicon_url, 
				'logo_url' 			=> $logo_url, 
			]);

			if ($gonow) {
				Redirect::to(Config::ADMIN_BASE_URL().'general_settings/website_settings?update=success');
			} else {
				Redirect::to(Config::ADMIN_BASE_URL().'general_settings/website_settings?update=failed');
			}
		}


		public function currency_settings(){
			$this->view('administrator/currency-settings', [
				'allCurrencies' => CurrencyTbl::get()
			]);
		}

		public function add_currency(){
			$country = Input::get('country');
			$code = Input::get('code');
			$symbol = Input::get('symbol');

			$gonow = Array(
				'country' 	=> $country, 
				'code' 		=> $code, 
				'symbol' 		=> $symbol
			);
			$notice = CurrencyTbl::insertTable($gonow);

			if ($notice) {
				Redirect::to(Config::ADMIN_BASE_URL().'general_settings/currency_settings?add=success');
			} else {
				Redirect::to(Config::ADMIN_BASE_URL().'general_settings/currency_settings?add=failed');
			}
		}

		public function del_currency(){
			$currID = Input::get("currID");
			$del = CurrencyTbl::where('id', $currID)->delete();
			if ($del) {
				Redirect::to(Config::ADMIN_BASE_URL().'general_settings/currency_settings?delete=success');
			} else {
				Redirect::to(Config::ADMIN_BASE_URL().'general_settings/currency_settings?delete=failed');
			}
		}

		public function set_default(){
			$currID = Input::get("currID");
			$set = CurrencyTbl::setDefault($currID);
			if ($set) {
				Redirect::to(Config::ADMIN_BASE_URL().'general_settings/currency_settings?set=success');
			} else {
				Redirect::to(Config::ADMIN_BASE_URL().'general_settings/currency_settings?set=failed');
			}
		}



		public function bank_account_info(){
			$accounts = Admin_bank::first();
			$this->view('administrator/bank-account-info', [
				'usdBanks' => Admin_bank::getByCurr('USD'),
				'ngnBanks' => Admin_bank::getByCurr('NGN'),
				'euroBanks' => Admin_bank::getByCurr('EURO'),
				'poundBanks' => Admin_bank::getByCurr('POUND')
			]);
		}


		// NEW BANK SCRIPT
		public function add_bank(){
			$currency = Input::get('currency');
			$bank = Input::get('bank');
			$account_name = Input::get('account_name');
			$account_number = Input::get('account_number');
			$account_type = Input::get('account_type');

			$add = Admin_bank::create([
				'currency' => $currency,
				'bank' => $bank,
				'account_name' => $account_name,
				'account_number' => $account_number,
				'account_type' => $account_type
			]);

			if ($add) {
				Redirect::to(Config::ADMIN_BASE_URL().'general_settings/bank_account_info?add=success');
			} else {
				Redirect::to(Config::ADMIN_BASE_URL().'general_settings/bank_account_info?add=failed');
			}
		}


		public function delete_bank(){
			$id = Input::get('bankID');

			$del = Admin_bank::where('id', $id)->delete();

			if ($del) {
				Redirect::to(Config::ADMIN_BASE_URL().'general_settings/bank_account_info?delete=success');
			} else {
				Redirect::to(Config::ADMIN_BASE_URL().'general_settings/bank_account_info?delete=failed');
			}
		}

		public function go_bring($bankID){
			$bankInfo = Admin_bank::where('id', $bankID)->first();

			$currSym = $bankInfo->currency;
			if ($currSym == 'NGN') {
				$symbol = '(₦)';
			} else if ($currSym == 'USD') {
				$symbol = '($)';
			} else if ($currSym == 'POUND') {
				$symbol = '(£)';
			} else if ($currSym == 'EURO') {
				$symbol = '(€)';
			} 

			if ($bankInfo) {
				echo '
					<input type="hidden" name="id" value="'.$bankInfo->id.'">
					<div class="form-group">
			            <label>Select Currency</label>
			            <select class="form-control custom-select" name="currency">
			              <option selected value="'.$bankInfo->currency.'">'.$bankInfo->currency.' '.$symbol.'</option>
			              <option value="NGN">NGN (₦)</option>
			              <option value="USD">USD ($)</option>
			              <option value="POUND">POUND  (£)</option>
			              <option value="EURO">EURO (€)</option>
			            </select>
			        </div>

			        <div class="form-group">
			            <label>Account Name</label>
			            <input type="text" name="account_name" class="form-control" value="'.$bankInfo->account_name.'">
			        </div>

			        <div class="form-group">
			            <label>Account Number</label>
			            <input type="text" name="account_number" class="form-control" value="'.$bankInfo->account_number.'">
			        </div>

			        <div class="form-group">
			            <label>Bank Name</label>
			            <input type="text" name="bank" class="form-control" value="'.$bankInfo->bank.'">
			        </div>

			        <div class="form-group">
			            <label>Account Type</label>
			            <input type="text" name="account_type" class="form-control" value="'.$bankInfo->account_type.'">
			        </div>
				';
			} else {
				echo 0;
			}
			exit();
		}


		public function update_bank_info(){
			$id = Input::get('id');
			$currency = Input::get('currency');
			$bank = Input::get('bank');
			$account_name = Input::get('account_name');
			$account_number = Input::get('account_number');
			$account_type = Input::get('account_type');

			$update = Admin_bank::where('id', $id)->update([
				'currency' => $currency,
				'bank' => $bank,
				'account_name' => $account_name,
				'account_number' => $account_number,
				'account_type' => $account_type
			]);

			if ($update) {
				Redirect::to(Config::ADMIN_BASE_URL().'general_settings/bank_account_info?update=success');
			} else {
				Redirect::to(Config::ADMIN_BASE_URL().'general_settings/bank_account_info?update=failed');
			}
		}



		public function social_settings(){
			$this->view('administrator/socail-settings', [
				'social_settings' => SocialSettingsTbl::get()
			]);
		}


		public function add_social(){
			$name = Input::get('name');
			$icon = Input::get('icon');
			$link = Input::get('link');

			$add = SocialSettingsTbl::createRow($name, $icon, $link);

			if ($add) {
				Redirect::to(Config::ADMIN_BASE_URL().'general_settings/social_settings?add=success');
			}
		}

		public function get_social($id) {
			$sos = SocialSettingsTbl::single($id);

			$result = "";

			if ($sos) {

				$result = '1|'.$sos->id.'|'.$sos->name.'|'.$sos->icon.'|'.$sos->link.'|'.$sos->status;

			} else {
				$result = "No result available";
			}
			print_r($result);
			exit();
		}


		public function update_social(){
			$id = Input::get('id');
			$name = Input::get('name');
			$icon = Input::get('icon');
			$link = Input::get('link');
			$status = Input::get('status');

			$update = SocialSettingsTbl::updateRow($id, $name, $icon, $link, $status);

			if ($update) {
				Redirect::to(Config::ADMIN_BASE_URL().'general_settings/social_settings?update=success');
			}
		}

		public function delete_social(){
			$id = Input::get('id');

			$del = SocialSettingsTbl::deleteRow($id);
			if ($del) {
				Redirect::to(Config::ADMIN_BASE_URL().'general_settings/social_settings?delete=success');
			}
		}


		

	}

?>