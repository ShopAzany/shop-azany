<?php
use Illuminate\Database\Eloquent\Model as Eloquent;

class CategoryBanner extends Eloquent 
{
    
    protected $fillable = [ 
        'id',   
        'title',
        'category',
        'banner',
        'link',
        'created_at',
        'updated_at'
     ];
    protected $primaryKey = 'id';
    protected $table = 'category_banner';
    protected $dates = [
        'created_at',
        'updated_at',
    ];


    public Static function getSIngle($category){
        return self::where('category', $category)->first();
    }

    public Static function removeRecord($id){
        return self::where('id', $id)->delete();
    }

    public Static function createRecord($title, $category, $banner, $link){
        return self::create([
            'title' => $title,
            'category' => $category,
            'banner' => $banner,
            'link' => $link,
        ]);
    }

    public Static function allBannerAds(){
        return self::orderBy('id', 'DESC')->get();
    }

    public Static function getCategoryBanners($slug){
        return self::where('category', $slug)->first();
    }

}

?>