<?php
    use Illuminate\Database\Eloquent\Model as Eloquent;

    class SellerVerification extends Eloquent {
        
        protected $fillable = [ 
            'id',
            'seller_id',
            'email_code', 
            'email_verify',
            'email_token_time',
            'sms_code', 
            'sms_verify',
            'sms_token_time',
            'created_at',
            'updated_at',
        ];
        
        protected $table = 'seller_verification';
        protected $dates = [
            'created_at',
            'updated_at',
        ];

        public static function insertEmailCode($sellerID=null){
            return self::create([
                'seller_id' => $sellerID,
                'email_code' => Settings::randomNums(3).Settings::randomNums(3),
                'email_token_time' => CustomDateTime::addDate('3 hours')
            ]); 
        }


        public static function forgotPasswordCode($sellerID=null){
            return self::create([
                'seller_id' => $sellerID,
                'email_code' => $sellerID.'_'.Settings::randomNums(20),
                'email_token_time' => CustomDateTime::addDate('1 hours')
            ]); 
        }


        public static function insertSMSCode($sellerID=null){
            return self::create([
                'seller_id' => $sellerID,
                'sms_code' => Settings::randomNums(8),
                'sms_token_time' => CustomDateTime::addDate('3 hours')
            ]);
        }

        public function getSingle($code){
            return self::where('email_code', $code)->Orwhere('sms_code', $code)->first();
        }

        public function getSingleEmailCode($sellerID, $code){
            return self::where('seller_id', $sellerID)->where('email_code', $code)->first();
        }


        public static function updateToken($sellerID, $code){
            return self::where('seller_id', $sellerID)->where('email_code', $code)->update([
                'email_verify' => 1
            ]);
        }










        public function verifyEmail($code){
            $seller = self::getSingle($code);
            if ($seller) {
                if ($seller->sms_code) {
                    self::where('sms_code', $code)->update(['sms_verify' => 1]);
                    Seller::where('seller_id', $seller->seller_id)->update([
                        'status' => 'Active',
                        'sms_verify' => 1
                    ]);
                } else {
                    self::where('email_code', $code)->update(['email_verify' => 1]);
                    Seller::where('seller_id', $seller->seller_id)->update([
                        'status' => 'Active',
                        'email_verify' => 1
                    ]);
                }
                $seller = Seller::singleSeller($seller->seller_id);
            }
            return $seller;
        }

    }
?>