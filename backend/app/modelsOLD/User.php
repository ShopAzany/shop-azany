<?php
use Illuminate\Database\Eloquent\Model as Eloquent;

class User extends Eloquent 
{
	
	protected $fillable = [ 
		'login_id',	
		'full_name',
        'email',
        'password',
        'phone',
        'country_code',
        'photo',
        'provider',
        'gender',
        'date_of_birth',
        'status',
        'signup_ip',
        'last_seen_ip',
        'last_seen',
        'created_at',
        'updated_at'
	 ];
     
	protected $primaryKey = 'login_id';
	protected $table = 'users';
  	protected $dates = [
        'last_seen',
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

    public static function singleUser($loginID){
        return self::where('login_id', $loginID)->first();
    }


    public static function createRecord($data=array()){
        return self::create([
            'full_name' => $data->full_name,
            'email' => $data->email,
            'password' => self::hashPass($data->full_name),
            'phone' => $data->phone,
        ]);
    }


    public static function changePassword($loginID, $newPwd){
        return self::where('login_id', $loginID)->update([
            'password' => self::hashPass($newPwd)
        ]);
    }

    public static function singleEmail($email){
        return self::where('email', $email)->first();
    }

    public static function updateEmail($loginID, $email){
        return self::where('login_id', $loginID)->update([
            'email' => $email
        ]);
    }


    public static function socialLogin($data){
        $user = self::where('email', $data->email)->first();

        if ($user) {
            return $user;
        } 
        else {
            return self::create([
                'full_name' => $data->first_name.' '.$data->last_name,
                'email' => $data->email,
                'photo' => $data->picture,
                'provider' => $data->provider
            ]);
        }
    }




}

?>