<?php
use Illuminate\Database\Eloquent\Model as Eloquent;

class FeatureProductBanner extends Eloquent 
{
	
	protected $fillable = [ 
		'id',
		'category',
        'banner',  
        'no_of_product',  
        'created_at',
        'updated_at'
	 ];
     
	protected $primaryKey = 'id';
    protected $casts = [ 
        'id' => 'integer',
        'no_of_product' => 'integer',
    ];
	protected $table = 'feature_product_banner';
  	protected $dates = [       
        'created_at',
        'updated_at'
    ];


    public static function updateRow($id, $category, $banner, $proNum){
        return self::where('id', $id)->update([
            'category' => $category,
            'banner' => $banner,
            'no_of_product' => $proNum
        ]);
    }

    

    




}

?>