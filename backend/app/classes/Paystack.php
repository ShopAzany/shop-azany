<?php
    class Paystack {
        public static $jsUrl = 'https://js.paystack.co/v1/inline.js';
        public static $verifyUrl = 'https://api.paystack.co/transaction/verify/';
        
        public static $key = 'pk_test_72b0fb2bfc1c34e34f94f325d4df4a2dc5c574b2';
        public static $bearer = 'sk_test_0c72d7f1ce05f5497730fe1e508ef063654aebaa';
        // public static $key = 'pk_live_44d0aaffcf8a1a5cce4de5389ed8d903fc229cdb';
        // public static $bearer = 'sk_live_7b8c2354b52e4553ed200015656e3be42ad49316';
        
        public static function validate($orderNumber){
            $result = array();
            //The parameter after verify/ is the transaction reference to be verified
            $url = self::$verifyUrl.$orderNumber;
            //echo $gwaySingle['mer_code'];exit();
            $auth = 'Authorization: Bearer '.self::$bearer;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            curl_setopt(
              $ch, CURLOPT_HTTPHEADER, [$auth]
            );

            $request = curl_exec($ch);
            if(curl_error($ch)){
                echo 'error:' . curl_error($ch);
            }

            curl_close($ch);

            if ($request) {
                $result = json_decode($request, true);
            }
                
            return $result;
        }
    }
?>