<?php
use Illuminate\Database\Eloquent\Model as Eloquent;

class Admin_bank extends Eloquent 
{
	
	protected $fillable = [ 
        'id',  
		'currency',	
        'bank',
        'account_name',
        'account_number',
        'account_type',    
        'created_at',
        'updated_at'
	 ];
     
	protected $primaryKey = 'id';
    protected $casts = [ 
        'id' => 'integer', 
    ];
	protected $table = 'admin_bank';
  	protected $dates = [
        'created_at',
        'updated_at'
    ];


    public function userAccounts($userID){
        return self::where('login_id', $userID)->get();
    }

    public function single($id){
        return self::where('id', $id)->first();
    }




    public function getByCurr($curr){
        return self::where('currency', $curr)->orderBy('id', 'DESC')->get();
    }

}

?>