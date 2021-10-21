<?php


use Illuminate\Database\Eloquent\Model as Eloquent;

class WhyChoseUsTbl extends Eloquent 
{
    
    protected $fillable = [ 
        'id',   
        'title',
        'svg',
        'content',
        'created_at',
        'updated_at'
     ];
    
    protected $table = 'why_us';
    protected $casts = [ 
        'id' => 'integer', 
    ];
    protected $primaryKey = 'id';
    protected $dates = [
        'created_at',
        'updated_at',
    ];


    public static function createRow($data=array()){
        if ($data['title']) {
            return self::create([
                'title' => $data['title'],
                'svg' => $data['svg'],
                'content' => $data['content'],
            ]);
        }
    }


    public static function updateRow($data=array()){
        if ($data['id'] && $data['title']) {
            return self::where('id', $data['id'])->update([
                'title' => $data['title'],
                'svg' => $data['svg'],
                'content' => $data['content'],
            ]);
        }
    }

    public static function singleRow($id){
        return self::where('id', $id)->first();
    }


    public static function deleteRow($id){
        return self::where('id', $id)->delete();
    }

    public static function getRowForGuest(){
        return self::get();
    }

    

}
    
?>