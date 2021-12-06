<?php
use Illuminate\Database\Eloquent\Model as Eloquent;

class ProductVariation extends Eloquent 
{
    
    protected $fillable = [ 
        'id',  
        'pid',  
        'seller_id', 
        'admin_id', 
        'name',  
        'value',
        'quantity', 
        'order_count', 
        'regular_price', 
        'sales_price',   
        'discount', 
        'created_at',
        'updated_at'
     ];
     
    protected $primaryKey = 'pid';
    protected $casts = [ 
        'id' => 'integer', 
        'pid' => 'integer', 
        'seller_id' => 'integer', 
        'quantity' => 'integer', 
        'order_count' => 'double',
        'regular_price' => 'double', 
        'sales_price' => 'double', 
        'discount' => 'double',
    ];
    protected $table = 'product_variations';
    protected $dates = [
        'created_at',
        'updated_at',
    ];



    public static function singleByPid($pid) {
        return self::selectRaw("product_variations.*, quantity - order_count AS quantity")
            ->where('pid', $pid)->get();
    }


    public static function firstProdID($pid) {
        return self::selectRaw("product_variations.*, quantity - order_count AS quantity")
            ->where('pid', $pid)->first();
    }


    public static function createRecord($data=array()){
        return self::create([
            'pid' => $data['pid'], 
            'seller_id' => $data['seller_id'],
            'name' => $data['vName'],
            'value' => $data['vValue'],
            'quantity' => $data['quantity'],
            'sales_price' => $data['sales_price'],
            'regular_price' =>  $data['regular_price'],
            'discount' => $data['discount']
        ]);
    }

    public static function updateRecord($id, $pid, $vName, $vVar, $qty, $sale_price, $reg_price, $discount, $start_date, $end_date){
        return self::where('id', $id)->update([
            'pid' => $pid,             
            'name' => $vName,            
            'value' => $vVar,            
            'quantity' => $qty,            
            'regular_price' => $reg_price,            
            'sales_price' => $sale_price,            
            'discount' => $discount,         
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