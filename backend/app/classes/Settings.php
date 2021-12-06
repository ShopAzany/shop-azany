<?php
	class Settings {

		//amt
		public static function currAmount($amt, $userISO=null){
			//$nairaValue = Visitor::location()['currencyValue'];
			$nairaValue = 361;
			if(self::defaultCurrency()->c_code == 'NGN' || self::defaultCurrency()->c_country == 'Nigeria'){
				$result = number_format($amt * $nairaValue);
			}
			else {
				//$result = number_format((float)$amt, 2, '.', ',');
				//$result = round($amt, 2);
				$result = number_format($amt);
			}
				
			return $result;
		}

		//amt
		public static function admCurrAmount($amt){				
			return $result = number_format($amt);;
		}

		//convert Naira to US Dollar
		public static function currExcInput($amount){
			//$nairaValue = Visitor::location()['currencyValue'];
			$nairaValue = 361;
			$amount = preg_replace('#[^0-9.]#', '', $amount);

			if(self::defaultCurrency()->c_code == 'NGN' || self::defaultCurrency()->c_country == 'Nigeria'){

				$amount = $amount / $nairaValue;
			}
				
			return round($amount, 2);
		}

		public static function decimalsChcked($value){			
			return round($value, 2);
		}

		public static function minAmount(){			
			return 4;
		}

		public static function maxAmount(){			
			return 10000;
		}

		//Clean url
		public static function cleanUrl($string) {
			$string = str_replace('.', 'dot ', $string);
			$firt = substr($string,0,1);
		    if($firt == " ") {
		      $string = preg_replace("/^".$firt."/", "", $string);
		    }else{
		      $string = $string;
		    }

		    $string = str_replace('(', '-', $string);
		    $string = str_replace(')', '-', $string);
		    $string = str_replace(' - ', ' ', rtrim(trim($string), ' '));

		   	$string = str_replace(' ', '-', str_replace('&', 'and', str_replace('  ', ' ', $string)));

		   	return strtolower(preg_replace('/[^A-Za-z0-9\-]/', '', $string));
		}
		
		//Check username 
		public static function checkUsername($string) {
			$check = preg_replace('/[^A-Za-z0-9\_]/', '', $string);

			$firt = substr($check,0,1);

		    if($string == $check && strlen($check) > 4 && strlen($check) <= 16 && !is_numeric($firt)) {
		      return true;
		    }

		    return false;	   	 
		}

		//Generate unique random number
		public static function randomNums($length){
			$chars = "1234567890";
			$clen   = strlen($chars)-1;
			$randmStr  = '';

			for ($i = 0; $i < $length; $i++) {
			      $randmStr .= $chars[mt_rand(0,$clen)];
			}
			return ($randmStr);		
		}

		//Generate unique random string
		public static function randomStrgs($length){
			$chars = "1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
			// $chars = "1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ";
			$clen   = strlen($chars)-1;
			$randmStr  = '';

			for ($i = 0; $i < $length; $i++) {
			      $randmStr .= $chars[mt_rand(0,$clen)];
			}
			return strtoupper($randmStr);
		}

		//generate server secret key
		public static function serverKey(){
			return '5f2b5cdbe5194f10b3241568fe4e2b24';
		}

		//Generate order Number
		public static function orderNum(){
			return 'OZ'.self::randomStrgs(4).self::randomNums(4);
		}	

		public static function currentTime(){
			date_default_timezone_set("Africa/Lagos");
			return date("Y-m-d H:i:s");
		}

		public static function addDate($dateTime){
			return date('Y-m-d H:i:s', strtotime("$dateTime", strtotime(self::currentTime())));
		}

		public static function dayStartEnd(){
			$dtNow = new DateTime();
			// $dtNow->setTimezone(new DateTimeZone('Africa/Lagos'));
			$dtNow->setTimestamp(strtotime(self::currentTime()));

			$beginOfDay = clone $dtNow;
			$beginOfDay->modify('today');

			$endOfDay = clone $beginOfDay;
			$endOfDay->modify('tomorrow');
			$endOfDateTimestamp = $endOfDay->getTimestamp();
			$endOfDay->setTimestamp($endOfDateTimestamp - 1);

			return array(
		        'dayStart' => $beginOfDay->format('Y-m-d H:i:s'),
		        'dayEnd' => $endOfDay->format('Y-m-d H:i:s'),
		    );
		}

		//Calculate weekly timer
		public static function weekSartEndDate(){
			// Change to whatever date you need
		    $cur_date = strtotime(self::currentTime()); 
		    // Get the day of the week: Sunday = 0 to Saturday = 6
		    $dotw = date('w', $cur_date);
		    if($dotw>1){
		        $pre_monday  =  $cur_date-(($dotw-1)*24*60*60);
		        $next_sunday = $cur_date+((7-$dotw)*24*60*60);
		    }
		    else if($dotw==1){
		        $pre_monday  = $cur_date;
		        $next_sunday =  $cur_date+((7-$dotw)*24*60*60);
		    }
		    else if($dotw==0){
		        $pre_monday  =$cur_date - (6*24*60*60);;
		        $next_sunday = $cur_date;
		    }

		    //NEW: get last day of the week
		    $currDatNm = date('w');
			$remainingDatNm = 6 - $currDatNm;
			$lastDateWeek = date('Y-m-d H:i:s', strtotime('+'.$remainingDatNm.' days', strtotime(date("Y-m-d H:i:s"))));

		    return array(
		    	'weekStart' => date("Y-m-d h:i:s",$pre_monday),
		    	'weekEnd' => $lastDateWeek,
		    );
		}

		//Calculate monthly Start and End dates
		public static function monthSartEndDate(){
			return array(
				'monthStart' => date('Y-m-01 H:i:s',strtotime('this month')),
				'monthEnd' => date('Y-m-t H:i:s',strtotime(self::currentTime()))
			);
		}

		//Calculate annual Start and End dates
		public static function yearSartEndDate(){
			$year = date('Y');
			$start = mktime(0, 0, 0, 1, 1, $year);
			$end = mktime(0, 0, 0, 12, 31, $year);
			
			return array(
				'yearStart' => date('Y-m-d H:i:s', $start),
				'yearEnd' => date('Y-m-d H:i:s', $end)
			);
		}


		public function onlyString($getStr){
			return str_replace('-', ' ', str_replace('_', ' ', str_replace('and', '&', $getStr)));
		}

	}

?>