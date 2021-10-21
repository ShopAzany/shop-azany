<?php


use Illuminate\Database\Eloquent\Model as Eloquent;

class ShippingMethods extends Eloquent 
{
    
    protected $fillable = [ 
        'id',   
        'name',
        'country',
        'description',
        'price',
        'url',
        'status',
        'created_at',
        'updated_at'

     ];
    
    protected $table = 'shipping_methods';
    protected $primaryKey = 'id';
    protected $dates = [
        'created_at',
        'updated_at',

    ];

    public function deleteRecord($id) {
        return self::where('id', $id)->delete();
    }

    public function activeRows() {
        return self::where('status', 1)->orderBy('id', 'ASC')->get();
    }

    //For admin
    public function allRows() {
        return self::orderBy('id', 'DESC')->get();
    }

    //single by id
    public static function singleRow($id){
        return self::where('id', $id)->first();
    }

    public function createRecord($data) {
        return self::create([
            'name' => $data->name,
            'description' => $data->description,
            'price' => $data->price,
            'url' => $data->url,
        ]);
    }

    public function updateRecord($data) {
        return self::where('id', $data->id)->update([
            'name' => $data->name,
            'description' => $data->description,
            'price' => $data->price,
            'url' => $data->url,
            'status' => ($data->status == 'Active') ? 1 : 0
        ]);
    }


}
    
?>