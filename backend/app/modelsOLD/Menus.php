<?php


use Illuminate\Database\Eloquent\Model as Eloquent;

class Menus extends Eloquent 
{
    
    protected $fillable = [ 
        'id',   
        'option_id',
        'role',
        'created_at',
        'updated_at'
     ];
    
    protected $table = 'menus';
    protected $primaryKey = 'id';
    protected $dates = [
        'created_at',
        'updated_at',

    ];

    // public static function deleteRecord($id){
    //     return self::where('id', $id)->delete();
    // }

    public static function createdRecord($optID, $role){
        $exist = self::where('option_id', $optID)->where('role', $role)->first();
        if (!$exist AND ($optID AND $role)){
            return self::create(['option_id' => $optID, 'role' => $role]);
        } else {
            return false;
        }
    }

    // public static function menu(){
    //     $wrapperArrays = array();
    //     $i = 0;
    //     foreach (self::get() as $value) {
    //         $i++;
    //         if ($i == 11) break;
    //         if ($value->role == 'category') {
    //             $temArray['page'] = null;
    //             $temArray['category'] = Category::categoryWrap_byID($value->option_id);
    //             array_push($wrapperArrays, $temArray);
    //         }
    //         else if($value->role == 'page') {
    //             $temArray['category'] = null;
    //             $temArray['page'] = Pages::singleRecord($value->option_id);
    //             array_push($wrapperArrays, $temArray);
    //         }
    //     }

    //     return $wrapperArrays;
    // }


    public static function allRecords(){
        return self::select('menus.*', 'cat_name', 'title')
            ->leftJoin('categories', function($join){
                $join->on('categories.cat_id', '=', 'menus.option_id');
                $join->where('menus.role', '=', 'category');
            })
            ->leftJoin('pages', function($join){
                $join->on('pages.id', '=', 'menus.option_id');
                $join->where('menus.role', '=', 'page');
            })
            ->orderBy('id', 'ASC')->get();
    }

    
}
    
?>