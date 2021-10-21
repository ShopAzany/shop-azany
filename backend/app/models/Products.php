<?php
use Illuminate\Database\Eloquent\Model as Eloquent;

class Products extends Eloquent 
{
    
    protected $fillable = [ 
        'pid',  
        'seller_id',  
        'sku',
        'position',
        'category', 
        'name',
        'sub_title',
        'brand',
        'size',
        'material',
        'pro_condition',
        'features',
        'manufacture_country',
        'manufacture_state',
        'stock',
        'tags',     
        'description',
        'est_delivery_date',    
        'return_policy',    
        'domestic_policy',    
        'inter_policy',    
        'warranty', 
        'pro_location_country', 
        'pro_location_state', 
        'shipping_fee', 
        'shipping_method', 
        'allow_shipping_outside', 
        'status', 
        'featured_img', 
        'images',   
        'created_at',
        'updated_at'
     ];
     
    protected $primaryKey = 'pid';
    protected $casts = [ 
        'pid' => 'integer', 
        'seller_id' => 'integer', 
        'sold' => 'integer', 
        'domestic_policy' => 'integer', 
        'inter_policy' => 'integer',
        'allow_shipping_outside' => 'integer',
    ];
    protected $table = 'products';
    protected $dates = [
        'created_at',
        'updated_at',
    ];


    public static function singleById($pid){
        return self::where('pid', $pid)->where('status', 'Active')->first();
    }


    public static function singleProduct($pid){
        return self::where('pid', $pid)->first();
    }

    public static function singleProductForSeller($sellerID, $pid){
        return self::where('pid', $pid)->where('seller_id', $sellerID)->first();
    }


    public static function sellerProduct($pageLimit, $offset, $sellerID){
        return self::take($pageLimit)->offset($offset)->whereRaw("seller_id = '$sellerID' AND status != 'Removed'")->orderBy('pid', 'DESC')->get();
    }

    public static function sellerProductCount($sellerID){
        return self::whereRaw("seller_id = '$sellerID' AND status != 'Removed'")->count();
    }


    public static function adminProductList($pageLimit, $offset){
        return self::take($pageLimit)->offset($offset)->orderBy('pid', 'DESC')->get();
    }


    public static function adminRecentAdded(){
        return self::selectRaw("products.*, product_variations.sales_price, product_variations.quantity - product_variations.order_count AS quantity")
            ->leftJoin('product_variations', 'product_variations.pid', 'products.pid')
            ->take(10)->orderBy('pid', 'DESC')->get();
    }


    public static function productBySeller($sellerID){
        return self::where('seller_id', $sellerID)->orderBy('pid', 'DESC')->get(); 
    }




    public function byCategory($category, $take, $offset){
        return self::selectRaw(self::selectOpt())->take($take)->offset($offset)
                ->whereRaw(self::categoryQuery($category))
                ->orderBy('updated_at', 'DESC')->get();
    }

    public function byCategoryCount($category){
        return self::selectRaw(self::selectOpt())
                ->whereRaw(self::categoryQuery($category))->count();
    }

    private function selectOpt(){
        return "pid, position, category, name, featured_img, images, status, created_at";
    }

    private function categoryQuery($category){
        return "status='Active' AND category LIKE '%$category%'";
    }


    public static function homeFeatureProducts($featureCat){
        return self::whereRaw(self::categoryQuery($featureCat))->get();
    }


    public static function createRow($sellerID, $data){
        if ($sellerID && $data->category && $data->title && $data->description) {
            return self::create([
                'seller_id'                 =>  $sellerID,  
                'category'                  =>  $data->category,
                'name'                      =>  $data->title,
                'sub_title'                 =>  $data->sub_title,
                'brand'                     =>  $data->brand,
                'size'                      =>  $data->size,
                'material'                  =>  $data->material,
                'features'                  =>  $data->features,
                'pro_condition'                 =>  $data->pro_condition,
                'manufacture_country'       =>  $data->manufacture_country,
                'manufacture_state'         =>  $data->manufacture_state,
                'description'               =>  $data->description,
                'status'                    =>  'Draft',
                'featured_img'              =>  $data->featured_img,
                'images'                    =>  $data->images
            ]);
        }
    }

    public static function updateProduct($sellerID, $data){
        return self::where('pid', $data->pid)->update([
            'seller_id'                 =>  $sellerID,  
            'category'                  =>  $data->category,
            'name'                      =>  $data->title,
            'sub_title'                 =>  $data->sub_title,
            'brand'                     =>  $data->brand,
            'size'                      =>  $data->size,
            'material'                  =>  $data->material,
            'features'                  =>  $data->features,
            'pro_condition'             =>  $data->pro_condition,
            'manufacture_country'       =>  $data->manufacture_country,
            'description'               =>  $data->description,
            'status'                    =>  'Pending',
            'featured_img'              =>  $data->featured_img,
            'images'                    =>  $data->images
        ]);
    }

    public static function updatePricing($data=array()){
        return self::where('pid', $data->pid)->update([
            'regular_price'      =>  $data->regular_price,
            'sales_price'         =>  $data->sales_price,
            'quantity'           =>  $data->quantity,
            'inter_policy'      =>  $data->inter_policy,
            'domestic_policy'    =>  $data->domestic_policy
        ]);
    }

    public static function updateShipping($data=array()){
        return self::where('pid', $data->pid)->update([
            'pro_location_country'              =>  $data->pro_location_country,
            'pro_location_state'              =>  $data->pro_location_state,
            'allow_shipping_outside'    =>  $data->allow_shipping_outside,
            'shipping_fee'                  =>  $data->shipping_fee,
            'shipping_method'                  =>  $data->shipping_method
        ]);
    }




    public function productPriceVariation($sellerID, $data=array()) {

        if (count($data) > 0) {
            Products::where('pid', $data['pid'])->update([
                'domestic_policy' => $data['domestic_policy'],
                'inter_policy' => $data['inter_policy']
            ]);

            ProductVariation::where('pid', $data['pid'])->delete();
            foreach ($data['morePriceVariations'] as $value) {
                $explVar = null;
                if ($value['variation']) {
                    $explVar = array_filter(explode('|', $value['variation']));
                }
                $sales_price = $value['sales_price']?:0;
                $regular_price = $value['regular_price']?:0;

                $discount = 0;
                if ($regular_price > $sales_price) {
                    $discount = round((($regular_price - $sales_price) / $regular_price) * 100);
                }
                $varionData = array(
                    'pid' => $data['pid'], 
                    'seller_id' => $sellerID,
                    'vName' => $explVar ? $explVar[0] : $explVar,
                    'vValue' => $explVar ? $explVar[1] : $explVar,
                    'quantity' => $value['quantity'],
                    'sales_price' => $sales_price,
                    'regular_price' =>  $regular_price,
                    'discount' => $discount
                );

                ProductVariation::createRecord($varionData);
            }

            return true; 
        }

        return null;
    }


    public function removeProduct($id){
        return self::where('pid', $id)->update([
            'status' => 'Removed'
        ]);
    }


    public static function lastRow($sellerID){
        return self::where('seller_id', $sellerID)->orderBy('pid', 'DESC')->first();
    }


    public static function homeProByCountry($country, $loginID){
        $takeProByCountry = self::where('pro_location_country', $country)->where('status', 'Active')->take(4)->get();
        $newProByCountry = array();
        foreach ($takeProByCountry as $value) {
            $value['variation'] = ProductVariation::firstProdID($value->pid);
            $value['rate_number'] = ProductRatingTbl::countRate($value->pid);
            $value['average_rate'] = ProductRatingTbl::starAverageCal($value->pid);
            $value['isFavorite'] = SavedProductsTbl::isFavorite($value->pid, $loginID);

            array_push($newProByCountry, $value);
        }
        return $newProByCountry;
    }


    public static function featProBan($cat, $proNum, $loginID){
        $feaProBanner = self::whereRaw("category LIKE '%$cat%'")->where('status', 'Active')->take($proNum)->get();
        $newFeaProBanner = array();
        foreach ($feaProBanner as $value) {
            $value['variation'] = ProductVariation::firstProdID($value->pid);
            $value['isFavorite'] = SavedProductsTbl::isFavorite($value->pid, $loginID);

            array_push($newFeaProBanner, $value);
        }
        return $newFeaProBanner;
    }


    public static function todayDeals($loginID){
        $todayDeal = self::select('products.*', 'product_variations.discount', 'product_variations.regular_price', 'product_variations.sales_price')->leftJoin('product_variations', 'product_variations.pid', 'products.pid')->groupBy('product_variations.pid')->orderBy('products.pid', 'DESC')->where('product_variations.discount', '>', 0)->where('products.status', 'Active')->take(4)->get();

        $newTodayDeal = array();
        foreach ($todayDeal as $value) {
            $value['rate_number'] = ProductRatingTbl::countRate($value->pid);
            $value['average_rate'] = ProductRatingTbl::starAverageCal($value->pid);
            $value['variation'] = ProductVariation::firstProdID($value->pid);
            $value['isFavorite'] = SavedProductsTbl::isFavorite($value->pid, $loginID);

            array_push($newTodayDeal, $value);
        }
        return $newTodayDeal;
    }


    public static function recentlyAdded($loginID){
        $result = self::where('status', 'Active')->take(4)->orderBy('pid', 'DESC')->get();

        $newRecentPro = array();
        foreach ($result as $value) {
            $value['variation'] = ProductVariation::firstProdID($value->pid);
            $value['rate_number'] = ProductRatingTbl::countRate($value->pid);
            $value['average_rate'] = ProductRatingTbl::starAverageCal($value->pid);
            $value['isFavorite'] = SavedProductsTbl::isFavorite($value->pid, $loginID);
            array_push($newRecentPro, $value);
        }

        return $newRecentPro;
    }

    public static function recommended($category, $loginID){
        $result = self::whereRaw("status = 'Active' AND category LIKE '%$category%'")->take(4)->orderBy('pid', 'DESC')->get();

        $newRecentPro = array();
        foreach ($result as $value) {
            $value['variation'] = ProductVariation::firstProdID($value->pid);
            $value['rate_number'] = ProductRatingTbl::countRate($value->pid);
            $value['average_rate'] = ProductRatingTbl::starAverageCal($value->pid);
            $value['isFavorite'] = SavedProductsTbl::isFavorite($value->pid, $loginID);
            array_push($newRecentPro, $value);
        }

        return $newRecentPro;
    }


    public static function otherSellerProduct($sellerID, $pid, $loginID){
        $sellerProFour = self::where('seller_id', $sellerID)->where('status', 'active')->where('pid', '!=', $pid)->take(4)->get();
        $newSellerPro = array();
        foreach ($sellerProFour as $value) {
            $value['rate_number'] = ProductRatingTbl::countRate($value->pid);
            $value['average_rate'] = ProductRatingTbl::starAverageCal($value->pid);
            $value['variation'] = ProductVariation::firstProdID($value->pid);
            $value['isFavorite'] = SavedProductsTbl::isFavorite($pid, $loginID);

            array_push($newSellerPro, $value);
        }

        return $newSellerPro;
    }

    public static function OtherSameProduct($cat, $pid, $loginID){
        $sameProFour = self::whereRaw("category LIKE '%$cat%' AND pid != '$pid' AND status = 'Active'")->take(8)->get();
        $newSamePro = array();
        foreach ($sameProFour as $value) {
            $value['rate_number'] = ProductRatingTbl::countRate($value->pid);
            $value['average_rate'] = ProductRatingTbl::starAverageCal($value->pid);
            $value['variation'] = ProductVariation::firstProdID($value->pid);
            $value['isFavorite'] = SavedProductsTbl::isFavorite($pid, $loginID);;

            array_push($newSamePro, $value);
        }

        return $newSamePro;
    }


    //ADMIN UPDATE PRODUCT
    public static function adminUpdateProduct($data=array()){
        if ($data['pid'] && $data['title'] && $data['category']) {
            return self::where('pid', $data['pid'])->update([
                'category' => $data['category'], 
                'name' => $data['title'], 
                'sub_title' => $data['sub_title'], 
                'pro_condition' => $data['pro_condition'], 
                'brand' => $data['brand'], 
                'size' => $data['size'], 
                'material' => $data['material'], 
                'manufacture_country' => $data['manufacture_country'], 
                'features' => $data['features'], 
                'description' => $data['description'], 
            ]);
        }
    }





}

?>