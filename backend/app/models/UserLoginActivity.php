<?php
use Illuminate\Database\Eloquent\Model as Eloquent;

class UserLoginActivity extends Eloquent 
{
	
	protected $fillable = [ 
        'id',
		'login_id',	
        'ip',
		'browser',
        'os',
        'last_access',
        'created_at',
        'updated_at'
	 ];
     
	protected $primaryKey = 'id';
    protected $casts = [ 
        'id' => 'integer', 
        'login_id' => 'integer', 
    ];
	protected $table = 'user_login_activity';
  	protected $dates = [
        'last_access',
        'created_at',
        'updated_at'
    ];


    public function hashPass($value){
        return password_hash($value, PASSWORD_DEFAULT);
    }

    public function verifyPass($password, $sqlPass){
       if(password_verify($password, $sqlPass)) {
            return true;            
        } else {           
            return false;
        }    
    }

    public Static function singleByID($loginID){
        return self::where('login_id', $loginID)->first();
    }

    public static function lastSeenChecks($lastSeen){
        return ($lastSeen > CustomDateTime::addDate('-30 minutes')) ? true : false;
    }


    public static function insertRow($loginID){
        return self::create([
            'login_id' => $loginID,
            'ip' => Visitor::getIP(),
            'browser' => Visitor::getBrowser(),
            'os' => Visitor::getOS(),
            'last_access' => Settings::currentTime()
        ]);
    }


    public function single($username){
        return self::where('username', $username)->first();
    }

    public function referrals($username){
        return self::where('referral', $username)->get();
    }


}

?>