<?php
use Illuminate\Database\Eloquent\Model as Eloquent;

class ProductRatingTbl extends Eloquent 
{
    
    protected $fillable = [ 
        'id',  
        'pid',  
        'login_id',
        'seller_id',
        'name',
        'title',
        'rating', 
        'comment',
        'status',   
        'created_at',
        'updated_at'
     ];
     
    protected $primaryKey = 'id';
    protected $casts = [ 
        'id' => 'integer', 
        'pid' => 'integer', 
        'login_id' => 'integer', 
        'seller_id' => 'integer', 
        'rating' => 'integer', 
        'status' => 'integer', 
    ];
    protected $table = 'product_rating';
    protected $dates = [
        'created_at',
        'updated_at',
    ];


    public static function countRate($pid){
        return self::where('pid', $pid)->count();
    }

    public static function getStarByProduct($pid){
        return self::where('pid', $pid)->get();
    }


    public static function starAverageCal($pid){
        $allRate = self::getStarByProduct($pid);
        $totalNumRate = self::countRate($pid);

        $sumStar = 0;

        foreach ($allRate as $value) {
            $sumStar += $value->rating;
        }
        // $average = (int)$sumStar / (int)$totalNumRate;
        return $sumStar;
    }


    public function createRow($loginID, $data=array()){
        $user = User::singleUser($loginID);
        
        $rate = self::create([ 
            'pid'   =>  $data->pid,  
            'seller_id'   =>  $data->sellerID,  
            'login_id'  =>  $loginID,
            'name'  =>  $user->full_name,
            'title' =>  $data->title,
            'rating'    =>  $data->rating, 
            'comment'   =>  $data->comment
        ]);

        if ($rate) {
            OrdersTbl::where('order_id', $data->orderID)->update([
                'rate' => 1
            ]);
        }

        return $rate;
    }


    public function itemRatings($pid) {
        return self::select('product_rating.*', 'users.full_name')
            ->where('product_rating.pid', $pid)->where('product_rating.status', 1)
            ->join('users', 'users.login_id', '=', 'product_rating.login_id')
            ->groupBy('product_rating.login_id')->orderBy('id', 'DESC')->get();
    }

    public function countSellerRate($sellerID){
        return self::where('seller_id', $sellerID)->count();
    }





}

?>