<?php
use Illuminate\Database\Eloquent\Model as Eloquent;

class Admin extends Eloquent 
{
	
	protected $fillable = [ 
        'id',  
		'role',	
        'username',
        'password',
        'email',
        'full_name',
        'phone',
        'photo',
        'address',
        'city',
        'state',
        'country',
        'bio',
        'status',
        'ip',
        'last_login_ip',
        'date_added',
        'last_login',
        'updated_date',
        'created_at',
        'updated_at'
	 ];
     
	protected $primaryKey = 'id';
	protected $table = 'admin';
  	protected $dates = [
        'date_added',
        'updated_date',
        'created_at',
        'updated_at'
    ];


    public static function insertTable($subData=array()){
        if($subData['id']){
            $info = self::where('id', $subData['id'])->update([
                'id'                    => $subData['id'],
                'full_name'             => $subData['full_name'],
                'role'                  => $subData['role'],
                'email'                 => $subData['email'],
                'phone'                 => $subData['phone'],
                'address'               => $subData['address'],
                'city'                  => $subData['city'],
                'state'                 => $subData['state'],
                'country'               => $subData['country'],
                'photo'                 => $subData['photo'],
                'bio'                   => $subData['bio'],
            ]);
        }
        else {
            $info = self::create([
                'full_name'             => $subData['full_name'],
                'username'              => $subData['username'],
                'password'              => User::hashPass($subData['username']),
                'role'                  => $subData['role'],
                'email'                 => $subData['email'],
                'phone'                 => $subData['phone'],
                'address'               => $subData['address'],
                'city'                  => $subData['city'],
                'state'                 => $subData['state'],
                'country'               => $subData['country'],
                'photo'                 => $subData['photo'],
                'bio'                   => $subData['bio'],
            ]);

        }

        return $info;
    }


 
    public function single($admin) {
        return self::where('username', $admin)->orWhere('email', $admin)->first();
    }
}

?>