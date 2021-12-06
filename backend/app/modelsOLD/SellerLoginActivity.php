<?php
use Illuminate\Database\Eloquent\Model as Eloquent;

class SellerLoginActivity extends Eloquent 
{
	
	protected $fillable = [ 
        'id',
		'seller_id',	
        'ip',
		'browser',
        'os',
        'last_access',
        'created_at',
        'updated_at'
	 ];
     
	protected $primaryKey = 'id';
	protected $table = 'seller_login_activity';
  	protected $dates = [
        'last_access',
        'created_at',
        'updated_at'
    ];

    public Static function singleByID($loginID){
        return self::where('login_id', $loginID)->first();
    }

    public static function insertRow($sellerID){
        return self::where('seller_id', $sellerID)->create([
            'seller_id' => $sellerID,
            'ip' => Visitor::getIP(),
            'browser' => Visitor::getBrowser(),
            'os' => Visitor::getOS(),
            'last_access' => Settings::currentTime()
        ]);
    }
    

}

?>