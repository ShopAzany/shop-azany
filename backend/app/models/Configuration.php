<?php
use Illuminate\Database\Eloquent\Model as Eloquent;

class Configuration extends Eloquent 
{
	
	protected $fillable = [ 
        'id',  
        'week',
        'trending',
        'created_at',
        'updated_at'
	 ];
     
	protected $primaryKey = 'id';
    protected $casts = [ 
        'id' => 'integer', 
    ];
	protected $table = 'configuration';
  	protected $dates = [
        'created_at',
        'updated_at'
    ];


    

    public function bank_details() {
        return json_decode(self::where('id', 1)->first()->bank_details, true);
    }

    public function singleRcd() {
        return self::where('id', 1)->first();
    }


    // public function singleweb($id){
    //     return self::where('id', $id)->first();
    // }


}

?>