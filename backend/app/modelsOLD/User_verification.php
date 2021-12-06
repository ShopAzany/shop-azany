<?php
    use Illuminate\Database\Eloquent\Model as Eloquent;

    class User_verification extends Eloquent {
        
        protected $fillable = [ 
            'id',
            'login_id',
            'email_code', 
            'email_verify',
            'email_token_time',
            'sms_code', 
            'sms_verify',
            'sms_token_time',
            'created_at',
            'updated_at',
        ];
        
        protected $table = 'user_verification';
        protected $dates = [
            'created_at',
            'updated_at',
        ];

        public static function insertEmailCode($loginID=null){
            return self::create([
                'login_id' => $loginID,
                'email_code' => Settings::randomNums(3).Settings::randomNums(3),
                'email_token_time' => CustomDateTime::addDate('3 hours')
            ]); 
        }


        public static function forgotPasswordCode($loginID=null){
            return self::create([
                'login_id' => $loginID,
                'email_code' => $loginID.'_'.Settings::randomNums(20),
                'email_token_time' => CustomDateTime::addDate('1 hours')
            ]); 
        }


        public static function insertSMSCode($loginID=null){
            return self::create([
                'login_id' => $loginID,
                'sms_code' => Settings::randomNums(8),
                'sms_token_time' => CustomDateTime::addDate('3 hours')
            ]);
        }

        public function getSingle($code){
            return self::where('email_code', $code)->Orwhere('sms_code', $code)->first();
        }

        public function getSingleEmailCode($loginID, $code){
            return self::where('login_id', $loginID)->where('email_code', $code)->first();
        }

        public static function updateToken($loginID, $code){
            return self::where('login_id', $loginID)->where('email_code', $code)->update([
                'email_verify' => 1
            ]);
        }



        public function verifyEmail($code){
            $user = self::getSingle($code);
            if ($user) {
                if ($user->sms_code) {
                    self::where('sms_code', $code)->update(['sms_verify' => 1]);
                    User::where('login_id', $user->login_id)->update([
                        'status' => 'Active',
                        'phone_verify' => 1
                    ]);
                } else {
                    self::where('email_code', $code)->update(['email_verify' => 1]);
                    User::where('login_id', $user->login_id)->update([
                        'status' => 'Active',
                        'email_verify' => 1
                    ]);
                }
                $user = User::uSingle($user->login_id);
            }
            return $user;
        }

    }
?>