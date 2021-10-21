<?php


use Illuminate\Database\Eloquent\Model as Eloquent;

class CategoryVariation extends Eloquent 
{
    
    protected $fillable = [ 
        'id',   
        'category',
        'name',
        'value_obj',
        'created_at',
        'updated_at'
     ];
    
    protected $table = 'category_variation';
    protected $casts = [ 
        'id' => 'integer', 
    ];
    protected $dates = [
        'created_at',
        'updated_at',
    ];


    public function getCategory($category) {
        return self::where('category', $category)->first();
    }


    public function getCategoryVariations($category) {
        $slug = self::getSubChildCategory($category);
        if ($slug) {
            $result = self::where('category', $slug)->first();
        }
        else {
            $result = self::getSubCategory($category);
            if ($result) {
                $result = self::where('category', $result)->first();
            }
            else {
                $result = self::where('category', $category)->first();
            }
        }
        
        return json_decode($result->value_obj, true);
    }

    private function getSubCategory($slug) {
        return CategoriesChild::select('categories.cat_slug')
            ->where('subcat_slug', $slug)
            ->join('categories', 'categories.cat_id', '=', 'categories_child.cat_id')
            ->first()->cat_slug;
    }

    private function getSubChildCategory($slug) {
        return CategoriesSubChild::select('categories.cat_slug')
            ->where('sub_subcat_slug', $slug)
            ->join('categories', 'categories.cat_id', '=', 'categories_sub_child.cat_id')
            ->first()->cat_slug;
    }
    

}
    
?>