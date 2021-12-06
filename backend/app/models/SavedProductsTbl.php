<?php


use Illuminate\Database\Eloquent\Model as Eloquent;

class SavedProductsTbl extends Eloquent 
{
    
    protected $fillable = [ 
        'id',   
        'login_id',
        'seller_id',
        'pid',
        'created_at',
        'updated_at'
     ];
    
    protected $table = 'saved_product';
    protected $casts = [ 
        'id' => 'integer', 
        'login_id' => 'integer', 
        'seller_id' => 'integer', 
        'pid' => 'integer', 
    ];
    protected $primaryKey = 'id';
    protected $dates = [
        'created_at',
        'updated_at',
    ];



    public static function getForUser($loginID, $limit, $offset){
        return self::take($limit)->offset($offset)
            ->selectRaw(self::selectOpt())->where('login_id', $loginID)
            ->leftJoin('products', 'products.pid', '=', 'saved_product.pid')
            ->orderBy('saved_product.id', 'DESC')->get();
    }


    public static function getForUserCount($loginID){
        return self::where('saved_product.login_id', $loginID)->count();
    }

    private function selectOpt(){
        return "saved_product.id, products.pid, products.category, products.name, products.images, products.featured_img";
    }



    public static function saveProduct($loginID, $prodID){
        $pro = Products::singleById($prodID);
        return self::create([
            'login_id' => $loginID,
            'pid' => $prodID,
            'seller_id' => $pro->seller_id
        ]);
    }

    public function removeRecord($loginID, $pid){
        return self::where('login_id', $loginID)->where('pid', $pid)->delete();
    }

    public static function lastSevenDayChart($sellerID, $duration){
        $currentDate = CustomDateTime::currentTime();
        $lastSeveDay = CustomDateTime::addDate('-6 '.$duration);

        return self::where('created_at', '>=', $lastSeveDay)->where('seller_id', $sellerID)->get();
    }


    public function isFavorite($pid, $loginID){
        return self::where('pid', $pid)->where('login_id', $loginID)->count();
    }

    

}
    
?>