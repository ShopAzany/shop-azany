<?php
use Illuminate\Database\Eloquent\Model as Eloquent;

class ShopByCountry extends Eloquent 
{
	
	protected $fillable = [ 
		'id',
		'country',
        'country_slug',	
        'image',  
        'created_at',
        'updated_at'
	 ];
     
	protected $primaryKey = 'id';
    protected $casts = [ 
        'id' => 'integer', 
    ];
	protected $table = 'shop_by_country';
  	protected $dates = [       
        'created_at',
        'updated_at'
    ];


    public static function addCountry($country, $img){
        return self::create([
            'country' => ltrim($country),
            'country_slug' => Settings::cleanUrl($country),
            'image' => $img,
        ]);
    }


    public static function deleteRow($id){
        return self::where('id', $id)->delete();
    }

    

    




}

?>