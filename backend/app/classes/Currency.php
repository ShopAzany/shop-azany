<?php
	class Currency {
		public static $min = 4;	
		public static $max = 10000;	
		public static $minPayoneer = 50;	
		public static $minPayal = 50;	
		public static $minLocalBank = 2000;	// In Naira
		public static $minIntlBank = 100;

		private static $nairaValue = 367;
		private static $usdCents = 100; // 100 cents equal to 1 USD
		private static $ngnKobo = 100; // 100 cobo equal to 1 NGN
		
		public function __construct(){
		}

		private function usdTOcent($usd) {
			return $usd * self::$usdCents;
		}

		private function centTOusd($cent) {
			return $cent / self::$usdCents;
		}

		private function nairaTOkobo($naira) {
			$kobos = $naira * self::$ngnKobo;
			return self::koboTOusd($kobos);
		}

		private function koboTOusd($kobo) {
			// this return kobo per 1 USD
			$koboPerUSD = self::$nairaValue * self::$ngnKobo;
			//Divide and get USD value of provided kobos
			$usd = $kobo / $koboPerUSD;
			return self::usdTOcent($usd);
		}

		private function centTOnaira($cent) {
			return self::$nairaValue * self::centTOusd($cent);
		}

		public static function currInputAmount($amount, $currType='USD') {
			$currType = strtoupper($currType);
			if($currType == 'NGN' || $currType == 'NG' || $currType == 'NAIRA' || $currType == 'NIGERIA'){
				return self::nairaTOkobo($amount);
			}
			return self::usdTOcent($amount);
		}

		public static function currAmount($amount, $currType='USD') {
			$currType = strtoupper($currType);
			if($currType == 'NGN' || $currType == 'NG' || $currType == 'NAIRA' || $currType == 'NIGERIA'){
				return self::centTOnaira($amount);
			}
			return self::centTOusd($amount);
		}

	}
?>