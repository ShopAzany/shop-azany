<?php
    class Paypal {
        //public static $paypalEnv       = 'sandbox';
        public static $paypalEnv       = 'production';
        //public static $paypalURL       = 'https://api.sandbox.paypal.com/v1/';
        public static $paypalURL       = 'https://www.paypal.com/cgi-bin/webscr';

        
        //public static $paypalClientID  = 'AR_FD6fsgzz2AJwT1LPHUvRZN5FWZ7fX0pJ_3RBPGRx7i05v584BkHS7vVbZx8c2eNQNJqYED8a5T2RW';
       // private static $paypalSecret   = 'EKeF__EtYQtNcjeIv7poaDbNLmoehUVr8Z7kbw9BCcT5PabUlDmAKIHNnbL2cw8PB8nPjQTOU8Twu5U9';

        public static $paypalClientID  = 'ARFNvxNwhBssdsvOss2So8peBiJcLpIdvWGP-ccLYnOqw6BzBPF72nQSndzOw0_DEeJgeg9kqdHYhi6F';
        private static $paypalSecret   = 'ECL5tredsYk7PcBZfLFMKb97d3lgMPMh7WDsOJTsrQ6cYUuu_EpUWuxntzYCaWjPlmSS3hlUvyJ2bZqn';
        
        public static function validate($paymentID, $paymentToken, $payerID, $productID){
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, self::$paypalURL.'oauth2/token');
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_USERPWD, self::$paypalClientID.":".self::$paypalSecret);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
            $response = curl_exec($ch);
            curl_close($ch);
            
            if(empty($response)){
                return false;
            }else{
                $jsonData = json_decode($response);
                $curl = curl_init(self::$paypalURL.'payments/payment/'.$paymentID);
                curl_setopt($curl, CURLOPT_POST, false);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($curl, CURLOPT_HEADER, false);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                    'Authorization: Bearer ' . $jsonData->access_token,
                    'Accept: application/json',
                    'Content-Type: application/xml'
                ));
                $response = curl_exec($curl);
                curl_close($curl);
                
                // Transaction data
                $result = json_decode($response);
                
                return $result;
            }
        
        }
    }
?>