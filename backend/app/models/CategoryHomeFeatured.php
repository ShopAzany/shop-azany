<?php
use Illuminate\Database\Eloquent\Model as Eloquent;

class CategoryHomeFeatured extends Eloquent 
{
    
    protected $fillable = [ 
        'id',   
        'title',
        'category',
        'full_width_banner',
        'full_width_banner_link',
        'left_banner',
        'left_banner_link',
        'right_banner',
        'right_banner_link',
        'created_at',
        'updated_at'
     ];
     
    protected $primaryKey = 'id';
    protected $casts = [ 
        'id' => 'integer', 
    ];
    protected $table = 'category_home_featured';
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    

    public function allRecords() {
        return self::orderBy('id', 'DESC')->get();
    }

    public function getSingle($category) {
        return self::where('category', $category)->first();
    }

    public function deleteRecord($id) {
        return self::where('id', $id)->delete();
    }

    public Static function getFeaturedCategories($limit=1){
        $tempArr = array();
        foreach (self::get()->toArray() as $value) {
            $localArr = array(
                'category' => $value, 
                'products' => Products::byCategory($value['category'], $limit, 0)->toArray(), 
            );

            array_push($tempArr, $localArr);
        }

        return $tempArr;
    }

}

?>