<?php


use Illuminate\Database\Eloquent\Model as Eloquent;

class PageTbl extends Eloquent 
{
    
    protected $fillable = [ 
        'id',   
        'type',
        'title',
        'overview',
        'contents',
        'url',
        'status',
        'created_at',
        'updated_at'
     ];
    
    protected $table = 'pages';
    protected $primaryKey = 'id';
    protected $dates = [
        'created_at',
        'updated_at',

    ];

    public static function singleRecord($id){
        return self::where('id', $id)->first();                  
    } 

    public static function deleteRecord($id){
        return self::where('id', $id)->delete();                  
    } 

    public static function singleUrl($url){
        return self::where('url', $url)->first();                  
    } 

    public static function createRecord($data){
        $info = self::singleUrl(Settings::cleanUrl($data->title));
        if (!$info && $data->title) {
            return self::create([
                'type' => $data->type,
                'title' => $data->title,
                'contents' => $data->contents,
                'url' => Settings::cleanUrl($data->title)
            ]); 
        } else {
            return false;
        }                         
    } 

    public static function updateRecord($data){
        return self::create([
            'type' => $data->type,
            'title' => $data->title,
            'contents' => $data->contents,
            'url' => Settings::cleanUrl($data->title),
            'status' => ($data->status == 'Active') ? 1 : 0
        ]);                          
    } 

    public static function activePages(){
        return self::where('status', 1)->orderBy('id', 'DESC')->get();                  
    } 

    public static function allPages(){
        return self::orderBy('id', 'DESC')->get();                  
    } 

    public static function allPageCnts(){
        return self::count();                  
    }

    public static function single($pageUrl){
        return PageTbl::where('url', $pageUrl)->get()->first();                  
    }


}
    
?>