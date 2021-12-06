<?php
use Illuminate\Database\Eloquent\Model as Eloquent;

class HomeTopCategory extends Eloquent 
{
	
	protected $fillable = [ 
		'id',	
        'category',
        'title',
		'banner',
        'created_at',
        'updated_at'
	 ];
     
	protected $primaryKey = 'id';
    protected $casts = [ 
        'id' => 'integer', 
    ];
	protected $table = 'home_cat_banner';
  	protected $dates = [
        'created_at',
        'updated_at'
    ];
    


    public function singleByCat($category){
        return self::where('category', $category)->first();
    }


    public function createRow($data){
        return self::create([
            'category' => $data['category'],
            'title' => $data['title'],
            'banner' => $data['banner'],
        ]);
    }


}

?>