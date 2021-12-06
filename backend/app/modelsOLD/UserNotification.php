<?php
use Illuminate\Database\Eloquent\Model as Eloquent;

class User_notification extends Eloquent 
{
	
	protected $fillable = [ 
        'id',
		'login_id',	
        'actor_id',
        'action',
		'type',
        'action_url',
        'status',
        'created_at',
        'updated_at'
	 ];
     
	protected $primaryKey = 'id';
	protected $table = 'user_notification';
  	protected $dates = [
        'created_at',
        'updated_at'
    ];


    public static function conversasUsers($loginID, $actorID){
        //return User_notification::whereRaw("(login_id=$loginID OR actor_id=$loginID) AND (login_id=$actorID OR actor_id=$actorID) ORDER BY id DESC")->first(); 

        return User_notification::where("login_id", $loginID)->orWhere('actor_id', $loginID)->first();  
    }

    public static function getNots($loginID){
        return User_notification::take(1)->where('login_id', $loginID)->where('status', 0)
            ->orderBy('id', 'DESC')->get();  
    }

    public static function getUnreadNots($loginID){
        return User_notification::whereRaw("login_id=$loginID
                    AND status=0 
                    AND id 
                        IN (SELECT max(id) FROM user_notification
                    GROUP BY actor_id, action_url)
                    ORDER BY id DESC")->count();  
    }


    public static function insertNot($loginID, $actorID, $action, $type, $actionUrl, $noteNumber=null){
        $checkNote = self::conversasUsers($loginID, $actorID);

        if($noteNumber){
            $noteNumber = $noteNumber;
        }
        elseif($checkNote['note_number'] !=null || $checkNote['note_number'] != ''){
            $noteNumber = $checkNote['note_number'];
        }
        else{
            $noteNumber = Settings::randomNums(8);
        }

        $info = User_notification::create([
            'note_number' => $noteNumber,
            'login_id'    => $loginID,
            'actor_id'    => $actorID,
            'action'      => $action,
            'type'        => $type,
            'action_url'  => $actionUrl
        ]);

        return $info;
    }


}

?>