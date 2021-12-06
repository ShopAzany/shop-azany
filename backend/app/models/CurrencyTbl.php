<?php





use Illuminate\Database\Eloquent\Model as Eloquent;



class CurrencyTbl extends Eloquent 

{

    

    protected $fillable = [ 

        'id',   

        'c_default',

        'country',

        'country_code',

        'code',

        'symbol',

        'created_at',

        'updated_at'

     ];

    

    protected $table = 'currencies';

    protected $casts = [ 

        'id' => 'integer', 

        'c_default' => 'integer', 

    ];

    protected $primaryKey = 'id';

    protected $dates = [

        'created_at',

        'updated_at',

    ];

    public function getAllCountries(){
        return self::pluck('country');//return all roles
    }

    public function getAll(){
        return self::all();//return all roles
    }

    public function getDefault() {

        return self::where('c_default', 1)->first();

    }



    public function insertTable($data) {

        return self::create([

            'country' => $data->country,

            'country_code' => $data->country_code,

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