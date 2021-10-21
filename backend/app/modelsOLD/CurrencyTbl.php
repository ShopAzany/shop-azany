<?php


use Illuminate\Database\Eloquent\Model as Eloquent;

class CurrencyTbl extends Eloquent 
{
    
    protected $fillable = [ 
        'id',   
        'default',
        'country',
        'code',
        'symbol',
        'created_at',
        'updated_at'
     ];
    
    protected $table = 'currencies';
    protected $primaryKey = 'id';
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function getDefault() {
        return self::where('c_default', 1)->first();
    }

    public function insertTable($data) {
        return self::create([
            'country' => $data->country,
            'code' => $data->code,
            'symbol' => $data->symbol
        ]);
    }

    public function setDefault($id) {
        $info = self::where('c_default', 1)->update([ 'c_default' => 0 ]);
        return self::where('id', $id)->update([ 'c_default' => 1 ]);
    }

}
    
?>