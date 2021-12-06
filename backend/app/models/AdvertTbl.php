<?php


use Illuminate\Database\Eloquent\Model as Eloquent;

class AdvertTbl extends Eloquent 
{
    
    protected $fillable = [ 
        'id',   
        'title',
        'image',
        'content',
        'status',
        'created_at',
        'updated_at'
     ];
    
    protected $table = 'adverts';
    protected $casts = [ 
        'id' => 'integer', 
    ];
    protected $primaryKey = 'id';
    protected $dates = [
        'created_at',
        'updated_at',
    ];


    public static function homeAds(){
        return self::where('id', 1)->first();
    }

    

}
    
?>