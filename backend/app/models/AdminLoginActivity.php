<?php
use Illuminate\Database\Eloquent\Model as Eloquent;

class AdminLoginActivity extends Eloquent 
{
	
	protected $fillable = [ 
        'id',  
		'admin',	
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
    ];
	protected $table = 'admin_login_activity';
  	protected $dates = [
        'last_access',
        'created_at',
        'updated_at'
    ];


    public static function insertTable($subData=array()){
        if($subData->id){
            $info = self::where('id', $subData->id)->update([
                'id'                    => $subData->id,
                'full_name'             => $subData->full_name,
                'username'              => $subData->username,
                'role'                  => $subData->role,
                'email'                 => $subData->email,
                'phone'                 => $subData->phone,
                'city'                  => $subData->city,
                'country'               => $subData->country,
                'photo'                 => $subData->photo,
                'bio'                   => $subData->bio,
            ]);
        }
        else {
            $info = self::create([
                'id'                    => $subData->id,
                'full_name'             => $subData->full_name,
                'username'              => $subData->username,
                'password'              => $subData->password,
                'role'                  => $subData->role,
                'email'                 => $subData->email,
                'phone'                 => $subData->phone,
                'city'                  => $subData->city,
                'country'               => $subData->country,
                'photo'                 => $subData->photo,
                'bio'                 => $subData->bio,
            ]);

        }

        return $info;
    }


 
    public function single($admin) {
        return self::where('username', $admin)->orWhere('email', $admin)->first();
    }

    public function allLastSeen() {
        return self::orderBy('id', 'DESC')->limit(10)->get();
    }
}

?>