<?php
use Illuminate\Database\Eloquent\Model as Eloquent;

class CategoriesChild extends Eloquent 
{
	
	protected $fillable = [ 
		'subcat_id',	
		'level',
        'cat_id',
        'subcat_name',
        'subcat_slug',
        'subcat_desc',
        'created_at',
        'updated_at'
	 ];
     
	protected $primaryKey = 'subcat_id';
    protected $casts = [ 
        'subcat_id' => 'integer', 
        'level' => 'integer', 
        'cat_id' => 'integer', 
    ];
	protected $table = 'categories_child';
  	protected $dates = [
        'created_at',
        'updated_at',
    ];

    public Static function createRecord($catID, $name, $descr){
        return self::create([
            'cat_id' => $catID,
            'subcat_name' => $name,
            'subcat_slug' => Settings::cleanUrl($name),
            'subcat_desc' => $descr,
        ]);
    }

    public Static function removeParent($catID){        
        return self::where('cat_id', $catID)->delete();
    }

    public Static function removeRecord($catID){
        CategoriesSubChild::removeParent($catID);      
        return self::where('subcat_id', $catID)->delete();
    }

    public Static function getCategory($slug){
        return self::where('subcat_slug', $slug)->get()->first();
    }

    public Static function getCategories($catID){
        return self::where('cat_id', $catID)->get();
    }

    public Static function categoryProductCnts($catID){
        return self::selectRaw('
                categories_child.level,
                categories.cat_name as parent,  
                categories_child.subcat_name as name, 
                categories_child.subcat_slug as slug, 
                COUNT(products.pid) AS Total'
            )
            ->where('categories_child.cat_id', $catID)
            ->leftJoin('products', function($join)
                {
                    $join->whereRaw("products.category LIKE CONCAT('%', categories_child.subcat_slug, '%')");
                }
            )
            ->leftJoin('categories', 'categories.cat_id', '=', 'categories_child.cat_id')
            ->groupBy('categories_child.subcat_slug')
            ->orderBy('Total', 'DESC')->get();
    }

}

?>