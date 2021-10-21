<?php
	class Rating {
		
		public function __construct(){		
		}

		public Static function ratingCnt($loginID){
			return OrderRating::where('seller_id', $loginID)->count();
		}

		public Static function ratings($loginID, $take=null, $offset=null){
			if(!($loginID) && $take!=null && ($offset==0 || $offset!=null || $offset!='')){
				$results = OrderRating::take($take)->offset($offset)
					->where('seller_id', $loginID)
					->orderBy('id', 'DESC')->get();
			}
			elseif($take!=null && $offset==null){
				$results = OrderRating::take($take)->where('seller_id', $loginID)->orderBy('id', 'DESC')->get();
			}
			else{
				$results = OrderRating::where('seller_id', $loginID)->orderBy('id', 'DESC')->get();
			}

			return $results;
		}

		public Static function productRatingCnts($pid){
			//check ratings for an item
			$orders = Orders::orderPID($pid);

			//Check if the order is rated
			$rateCnt = 0;
			foreach ($orders as $order) {
				if(OrderRating::where('order_id', $order->order_id)->first()){
					$rateCnt = $rateCnt + 1;
				}
			}

			return $rateCnt;
		}
		
	}
?>