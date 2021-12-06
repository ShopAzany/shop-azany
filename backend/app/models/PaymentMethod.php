<?php
    use Illuminate\Database\Eloquent\Model as Eloquent;

    class PaymentMethod extends Eloquent {
        
        protected $fillable = [ 
            'id',   
            'type',
            'gateway',
            'mer_id',
            'mer_code',
            'bearer',
            'name',
            'descr',
            'url',
            'status',
            'created_at',
            'updated_at'
        ];
        
        protected $table = 'payment_method';
        protected $casts = [ 
            'id' => 'integer',
            'status' => 'integer',
        ];
        protected $primaryKey = 'id';   
        protected $dates = [
            'created_at',
            'updated_at',
        ];

        //
        public static function allRecords(){
            return self::orderBy('id', 'DESC')->get();
        }

        //
        public static function getRecords(){
            return self::where('status', 1)->get();
        }
        //single by gateway
        public static function gatewaySIngle($gateway){
            return self::where('gateway', $gateway)->first();
        }

        //single by id
        public static function singleRow($id){
            return self::where('id', $id)->first();
        }

        //
        public static function deleteRecord($id){
            return self::where('id', $id)->delete();
        }

        //
        public static function createRecord($data){
            $info = self::gatewaySIngle($data->gateway);
            if (!$info && ($data->gateway && $data->name)) {
                return self::create([
                    'type' => $data->type,
                    'gateway' => $data->gateway,
                    'mer_id' => $data->mer_id,
                    'mer_code' => $data->mer_code,
                    'bearer' => $data->bearer,
                    'name' => $data->name,
                    'descr' => $data->descr,
                    'url' => $data->url
                ]);
            } else {
                return null;
            }            
        }
        //
        public static function updateRecord($data){
            return self::where('id', $data->id)->update([
                'type' => $data->type,
                'gateway' => $data->gateway,
                'mer_id' => $data->mer_id,
                'mer_code' => $data->mer_code,
                'bearer' => $data->bearer,
                'name' => $data->name,
                'descr' => $data->descr,
                'url' => $data->url,
                'status' => ($data->status == 'Active') ? 1 : 0
            ]);
        }

    }   
?>