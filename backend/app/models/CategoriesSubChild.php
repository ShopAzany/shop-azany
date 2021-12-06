<?php
use Illuminate\Database\Eloquent\Model as Eloquent;

class CategoriesSubChild extends Eloquent 
{
	
	protected $fillable = [ 
		'sub_subcat_id',	
		'level',
        'cat_id',
        'subcat_id',
        'sub_subcat_name',
        'sub_subcat_slug',
        'sub_subcat_desc',
        'created_at',
        'updated_at'

	 ];
     
	protected $primaryKey = 'sub_subcat_id';
    protected $casts = [ 
        'sub_subcat_id' => 'integer', 
        'level' => 'integer', 
        'cat_id' => 'integer', 
        'subcat_id' => 'integer',
    ];
	protected $table = 'categories_sub_child';
  	protected $dates = [
        'created_at',
        'updated_at',
    ];

    public Static function createRecord($subCatID, $name, $descr){
        $cadID = CategoriesChild::select('cat_id')->where('subcat_id', $subCatID)->first();
        return self::create([
            'cat_id' => $cadID->cat_id,
            'subcat_id' => $subCatID,
            'sub_subcat_name' => $name,
            'sub_subcat_slug' => Settings::cleanUrl($name),
            'sub_subcat_desc' => $descr
        ]);
    }

    public Static function removeGParent($catID){        
        return self::where('cat_id', $catID)->delete();
    }

    public Static function removeParent($catID){        
        return self::where('subcat_id', $catID)->delete();
    }

    public Static function removeRecord($catID){        
        return self::where('sub_subcat_id', $catID)->delete();
    }

    public Static function getCategory($slug){
        return self::where('sub_subcat_slug', $slug)->get()->first();
    }

    public Static function getCategories($subCatID){
        return self::where('subcat_id', $subCatID)->get();
    }

    public Static function categoryProductCnts($subCatID){
        return self::selectRaw('
                categories_sub_child.level, 
                categories_child.subcat_name as parent, 
                categories_sub_child.sub_subcat_name as name, 
                categories_sub_child.sub_subcat_slug as slug, 
                COUNT(products.pid) AS Total'
            )
            ->where('categories_sub_child.subcat_id', $subCatID)
            ->leftJoin('products', function($join)
                {
                    $join->whereRaw("products.category LIKE CONCAT('%', categories_sub_child.sub_subcat_slug, '%')");
                }
            )
            ->leftJoin('categories_child', 'categories_child.subcat_id', '=', 'categories_sub_child.subcat_id')
            ->groupBy('categories_sub_child.sub_subcat_slug')
            ->orderBy('Total', 'DESC')->get();
    }

}

?>