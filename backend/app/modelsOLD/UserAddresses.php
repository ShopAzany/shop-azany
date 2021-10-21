<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class UserAddresses extends Eloquent {
    
    protected $fillable = [ 
        'id',
        'login_id',
        'street_addr',
        'city',
        'state',
        'country',
        'add_status',
        'created_at',
        'updated_at',
    ];
    
    protected $table = 'user_addresses';
    protected $primaryKey = 'id';
    protected $dates = [
        'created_at',
        'updated_at',

    ];

    public function createRecord($loginID, $data){
        $status = 0;
        $default = self::defaultAddress($loginID);

        if($data->defaultAdd) {
            self::statusUpdate($loginID);
            $status = 1;
        }
        elseif(!$default) {
            $status = 1;
        }

        if ($data->street_addr && $data->city && $data->state) {
            return self::create([
                'login_id' => $loginID,
                'street_addr' => $data->street_addr,
                'city' => $data->city,
                'state' => $data->state,
                'country' => $data->country,
                'add_status' => $status
            ]);
        } 
        return null;
    }



    public function setDefult($id, $loginID){
        self::statusUpdate($loginID);
        return self::where('id', $id)->update(['add_status' => 1]);
    }

    public function statusUpdate($loginID) {
        return self::where('login_id', $loginID)->update(['add_status' => 0]);
    }

    public function deleteAddr($id){
        return self::where('id', $id)->delete();
    }

    public function defaultAddress($loginID){
        return self::where('login_id', $loginID)->where('add_status', 1)->first();
    }

    public function addresses($loginID){
        return self::where('login_id', $loginID)->orderBy('add_status', 'DESC')->get();
    }

    public function single($id){
        return self::where('id', $id)->first();
    }


    public function updateRecord($loginID, $data){
        if ($data->defaultAdd) {
            self::statusUpdate($loginID);
            $status = 1;
        } else {
            $status = 0;
        }

        return self::where('id', $data->id)->update([
            'street_addr' => $data->street_addr,
            'city' => $data->city,
            'state' => $data->state,
            'country' => $data->country,
            'add_status' => $status
        ]);
    }

    public function lastAddress($loginID){
        return self::where('login_id', $loginID)->orderBy('id', 'DESC')->first();
    }



}
?>