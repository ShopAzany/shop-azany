<?php


use Illuminate\Database\Eloquent\Model as Eloquent;

class HomeSlider extends Eloquent 
{
    
    protected $fillable = [ 
        'id',   
        'title',
        'url',
        'banner',
        'descr',
        'status',
        'created_at',
        'updated_at'
     ];
    
    protected $table = 'home_sliders';
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function singleRecord($id){
        return self::where('id', $id)->first();
    }

    public function getAll(){
        return self::where('status', 1)->where('id', '!=', 1)->orderBy('id', 'DESC')->get();
    }

    public function allby_admin(){
        return self::orderBy('id', 'DESC')->get();
    }

}
    
?>