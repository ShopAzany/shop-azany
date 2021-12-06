<?php


use Illuminate\Database\Eloquent\Model as Eloquent;

class SocialSettingsTbl extends Eloquent 
{
    
    protected $fillable = [ 
        'id',   
        'name',
        'icon',
        'link',
        'status',
        'created_at',
        'updated_at'
    ];
    
    protected $table = 'social_settings';
    protected $primaryKey = 'id';
    protected $dates = [
        'created_at',
        'updated_at',
    ];


    public static function createRow($name, $icon, $link){
        return self::create([
            'name' => $name,
            'icon' => $icon,
            'link' => $link
        ]);
    }

    public static function updateRow($id, $name, $icon, $link, $status){
        return self::where('id', $id)->update([
            'name' => $name,
            'icon' => $icon,
            'link' => $link,
            'status' => $status
        ]);
    }

    public static function deleteRow($id){
        return self::where('id', $id)->delete();
    }


    public static function single($id){
        return self::where('id', $id)->first();
    }

    public static function getForGuest(){
        return self::where('status', 1)->get();
    }

    

}
    
?>