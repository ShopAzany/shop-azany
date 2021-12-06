<?php
use Illuminate\Database\Eloquent\Model as Eloquent;

class VideoStreamTbl extends Eloquent 
{
	
	protected $fillable = [ 
		'id',
		'title',
        'type',  
        'url',  
        'created_at',
        'updated_at'
	 ];
     
	protected $primaryKey = 'id';
    protected $casts = [ 
        'id' => 'integer', 
    ];
	protected $table = 'video_stream';
  	protected $dates = [       
        'created_at',
        'updated_at'
    ];


    public static function creatRow($url, $banner){
        return self::create([
            'url' => $url,
            'banner' => $banner,
        ]);
    }


    public static function deleteRow($id){
        return self::where('id', $id)->delete();
    }

    public static function getAll(){
        return self::get();
    }

    public function createRow($title, $type, $url){
        return self::create([
            'title' => $title,
            'type' => $type,
            'url' => $url
        ]);
    }

    public static function deletVid($id){
        return self::where('id', $id)->delete();
    }
    

    




}

?>