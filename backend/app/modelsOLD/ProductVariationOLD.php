<?php
use Illuminate\Database\Eloquent\Model as Eloquent;

class ProductVariationOLD extends Eloquent 
{
    
    protected $fillable = [ 
        'id',  
        'pid',  
        'seller_id',  
        'name',  
        'value',
        'discount',
        'regular_price',
        'sale_price', 
        'sku', 
        'quantity', 
        'created_at',
        'updated_at'
    ];
     
    protected $primaryKey = 'pid';
    protected $table = 'product_variations';
    protected $dates = [
        'created_at',
        'updated_at',
    ];



    public static function singleByPid($pid) {
        return self::where('pid', $pid)->get();
    }


    public static function firstProdID($pid) {
        return self::where('pid', $pid)->first();
    }


    public static function createRecord($pid, $vName, $vVar, $qty, $sale_price, $reg_price, $discount){
        return self::create([
            'pid' => $pid,             
            'name' => $vName,            
            'value' => $vVar,            
            'quantity' => $qty,            
            'regular_price' => $reg_price,            
            'sale_price' => $sale_price,            
            'discount' => $discount
        ]);
    }

    public static function totalProductByQtyInactive($sellerID){
        return self::select('product_variations.*', 'products.status')
            ->leftJoin('products', 'products.pid', 'product_variations.pid')
            ->where('product_variations.seller_id', $sellerID)->where('products.status', '!=', 'Active')->sum('product_variations.quantity');
    }

    public static function totalProductByQtyActive($sellerID){
        return self::select('product_variations.*', 'products.status')
            ->leftJoin('products', 'products.pid', 'product_variations.pid')
            ->where('product_variations.seller_id', $sellerID)->where('products.status', 'Active')->sum('product_variations.quantity');
    }



}

?>