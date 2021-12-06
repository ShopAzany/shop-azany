<?php
use Illuminate\Database\Eloquent\Model as Eloquent;

class HomeProductTbl extends Eloquent 
{
	
	protected $fillable = [ 
		'id',
		'shop_by_country',
        'two_pro_banner',	
        'today_deals', 
        'recommended',  
        'three_grid_img',  
        'top_selling',
        'live_stream',      
        'recently_added',   
        'created_at',
        'updated_at'
	 ];
     
	protected $primaryKey = 'id';
    protected $casts = [ 
        'id' => 'integer', 
    ];
	protected $table = 'home_product';
  	protected $dates = [       
        'created_at',
        'updated_at'
    ];


    public static function setAction($proType, $action){
        if ($action) {
            return self::where('id', 1)->update([
                $proType => 'Enabled'
            ]);
        } else {
            return self::where('id', 1)->update([
                $proType => 'Disabled'
            ]);
        }
    }




}

?>