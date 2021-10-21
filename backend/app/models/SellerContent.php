<?php


use Illuminate\Database\Eloquent\Model as Eloquent;

class SellerContent extends Eloquent 
{
    
    protected $fillable = [ 
        'id',   
        'title',
        'sub_title',
        'banner',
        'created_at',
        'updated_at'
     ];
    
    protected $table = 'seller_content';
    protected $casts = [ 
        'id' => 'integer', 
    ];
    protected $primaryKey = 'id';
    protected $dates = [
        'created_at',
        'updated_at',
    ];


    public static function updateInfo($data=array()){
        return self::where('id', $data['id'])->update([
            'title' => $data['title'],
            'sub_title' => $data['sub_title'],
            'banner' => $data['banner']
        ]);
    }

    public static function howItWorks(){
        return self::where('id', '>', 2)->get();
    }

    public static function bannerInfo(){
        return self::where('id', 1)->first();
    }

    public static function exploreInfo(){
        return self::where('id', 2)->first();
    }

    public static function addHowItWork($data=array()){
        return self::create([
            'title' => $data['title'],
            'sub_title' => $data['sub_title'],
            'banner' => $data['banner'],
        ]);
    }

    public static function deleteRow($id){
        return self::where('id', $id)->delete();
    }

    public static function single($id){
        return self::where('id', $id)->first();
    }

    

}
    
?>