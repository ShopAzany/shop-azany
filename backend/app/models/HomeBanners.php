<?php


use Illuminate\Database\Eloquent\Model as Eloquent;

class HomeBanners extends Eloquent 
{
    
    protected $fillable = [ 
        'id',   
        'banner_top',
        'banner_top_link',
        'banner_bottom',
        'banner_bottom_link',
        'created_at',
        'updated_at'
     ];
    
    protected $table = 'home_banners';
    protected $casts = [ 
        'id' => 'integer', 
    ];
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function bannerWrap(){
        return self::first();
    }

    public function updateRecord($obj){
        $info = self::where('id', $obj['id'])->update([  
            'banner_top' => $obj['banner_top'],
            'banner_top_link' => $obj['banner_top_link'],
            'banner_bottom' => $obj['banner_bottom'],
            'banner_bottom_link' => $obj['banner_bottom_link'],
        ]);

        return $info;
        
    }


    public static function getAll(){
        return self::where('id', '!=', 1)->get();
    }

    public static function creatRow($url, $banner){
        return self::create([
            'banner_top' => $banner,
            'banner_top_link' => $url,
        ]);
    }

    public static function deleteRow($id){
        return self::where('id', $id)->delete();
    }

}
    
?>