<?php
use Illuminate\Database\Eloquent\Model as Eloquent;

class CategoryTbl extends Eloquent 
{
	
	protected $fillable = [ 
		'cat_id',	
        'level',
        'mobile_icon',
		'web_icon',
        'cat_name',
        'cat_slug',
        'cat_svg',
        'cat_img',
        'cat_desc',
        'created_at',
        'updated_at'
	 ];
     
	protected $primaryKey = 'cat_id';
    protected $casts = [ 
        'cat_id' => 'integer', 
        'level' => 'integer', 
    ];
	protected $table = 'categories';
  	protected $dates = [
        'created_at',
        'updated_at',
    ];


    public Static function createRecord($name, $descr, $mobileIcon, $webIcon, $catDesc, $catImg){
        return self::create([
            'cat_name' => $name,
            'cat_slug' => Settings::cleanUrl($name),
            'cat_desc' => $descr,
            'mobile_icon' => $mobileIcon,
            'web_icon' => $webIcon,
            'cat_img' => $catImg
        ]);
    }

    

    public Static function removeRecord($catID){
        CategoriesSubChild::removeGParent($catID);
        CategoriesChild::removeParent($catID);
        return self::where('cat_id', $catID)->delete();
    }

    public Static function mainCats($slug){
        return self::where('cat_slug', $slug)->first();
    }

    private function childCategories($catID){
        $wrapperArrays = array();
        foreach (self::subcategories($catID) as $result) {
            $temArray['Subcategory'] = $result;
            $temArray['SubSubcategories'] = self::subSubcategories($result['subcat_id']);
            array_push($wrapperArrays, $temArray);
        }

        return $wrapperArrays;
    }

    public Static function categoryWrap_byID($catID){
        $temArray = array();
        $result = self::where('cat_id', $catID)->get()->first();
        $temArray = $result;
        $temArray['Subcategories'] = self::childCategories($result['cat_id']);

        return $temArray;
    }

    public Static function categoryWrap(){
        $wrapperArrays = array();
        $i = 0;
        foreach (self::get() as $result) {
            $i++;
            if ($i == 11) break;
            $temArray['mainCats'] = $result;
            $temArray['Subcategories'] = self::childCategories($result['cat_id']);
            array_push($wrapperArrays, $temArray);
        }

        return $wrapperArrays;
    }

    


    private function subcategories($catID){
        return CategoriesChild::getCategories($catID);
    }

    private function subSubcategories($subcatID){
        return CategoriesSubChild::getCategories($subcatID);
    }



    public function forSideBarCat($slug){
        $result = self::select('cat_id')->where('cat_slug', $slug)->first();
        if ($result) {
            $results = CategoriesChild::categoryProductCnts($result['cat_id']);
        } 
        else {
            $resultChild = CategoriesChild::getCategory($slug);
            if ($resultChild) {
                $results = CategoriesSubChild::categoryProductCnts($resultChild['subcat_id']);
            }
            else {
                $resultSubCh = CategoriesSubChild::getCategory($slug);
                $results = CategoriesSubChild::categoryProductCnts($resultSubCh['subcat_id']);
            }
        }

        return $results;




        
        // $cat = CategoryTbl::where('cat_slug', $slug)->first();
        // $subCat = CategoriesChild::getCategory($slug);
        // $subCatChild = CategoriesSubChild::getCategory($slug);

        // if ($cat) {
        //     $subCatSidebar = CategoriesChild::getCategories($cat->cat_id);
        //     return $arrayName = array(
        //         'role' => 1,
        //         'action' => $subCatSidebar
        //     );
        // } else if($subCat) {
        //     $subCatChildSidebar = CategoriesSubChild::getCategories($subCat->subcat_id);
        //     return $arrayName = array(
        //         'role' => 2,
        //         'action' => $subCatChildSidebar
        //     );
        // } else if($subCatChild) {
        //     $theSubCat = CategoriesChild::where('subcat_id', $subCatChild->subcat_id)->first();
        //     $subCatChildSidebar = CategoriesSubChild::getCategories($theSubCat->subcat_id);
        //     return $arrayName = array(
        //         'role' => 2,
        //         'action' => $subCatChildSidebar
        //     );
        // } 
    }


    public function catTitle($slug){
        
        $result = CategoriesSubChild::select(
                'categories_sub_child.level', 
                'categories_sub_child.sub_subcat_name as activeCategory', 
                'categories.cat_name', 
                'categories.cat_slug',
                'categories_child.subcat_name', 
                'categories_child.subcat_slug')
                ->where('sub_subcat_slug', $slug)
                ->join('categories', 'categories.cat_id', '=', 'categories_sub_child.cat_id')
                ->join('categories_child', 'categories_child.subcat_id', '=', 'categories_sub_child.subcat_id')
                ->first();
        if ($result) {return $result;}

        $result = CategoriesChild::select(
                'categories_child.level', 
                'categories_child.subcat_name as activeCategory', 
                'categories.cat_name', 
                'categories.cat_slug')
                ->where('subcat_slug', $slug)
                ->join('categories', 'categories.cat_id', '=', 'categories_child.cat_id')
                ->first();

        if ($result) {return $result;}

        $result = self::select('level', 'cat_name', 'cat_slug', 'cat_name as activeCategory')->where('cat_slug', $slug)->first();
        if ($result) {return $result;}
    }



    public function forBreacrum($slug){
        $cat = CategoryTbl::where('cat_slug', $slug)->first();
        $subCat = CategoriesChild::getCategory($slug);
        $subCatChild = CategoriesSubChild::getCategory($slug);

        if ($cat) {
            $breadCrum = $slug;
        } else if($subCat) {
            $theCat = CategoryTbl::where('cat_id', $subCat->cat_id)->first();
            $breadCrum = $theCat->cat_slug.', '.$slug;
        } else if($subCatChild) {
            $theSubCat = CategoriesChild::where('subcat_id', $subCatChild->subcat_id)->first();
            $theCat = CategoryTbl::where('cat_id', $subCatChild->cat_id)->first();
            $breadCrum = $theCat->cat_slug.', '.$theSubCat->subcat_slug.', '.$slug;
        }
        return $breadCrum;
    }


    public Static function getSidebarCategories($slug){
        $result = self::select('cat_id')->where('cat_slug', $slug)->first();
        if ($result) {
            $results = CategoriesChild::categoryProductCnts($result['cat_id']);
        } 
        else {
            $resultChild = CategoriesChild::getCategory($slug);
            if ($resultChild) {
                $results = CategoriesSubChild::categoryProductCnts($resultChild['subcat_id']);
            }
            else {
                $resultSubCh = CategoriesSubChild::getCategory($slug);
                $results = CategoriesSubChild::categoryProductCnts($resultSubCh['subcat_id']);
            }
        }

        return $results;
    }

}

?>