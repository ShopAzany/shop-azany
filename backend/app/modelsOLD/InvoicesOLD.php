<?php


use Illuminate\Database\Eloquent\Model as Eloquent;

class InvoicesOLD extends Eloquent 
{
    
    protected $fillable = [ 
        'id',   
        'login_id',
        'shipping_cost',
        'total',
        'payment_method',
        'coupon_code',
        'status',
        'date_paid',
        'date_refunded',
        'created_at',
        'updated_at'
    ];
    
    protected $table = 'invoices';
    protected $primaryKey = 'id';
    protected $dates = [
        'created_at',
        'updated_at',

    ];

    public static function single($id) {
        return self::where('id', $id)->first();
    }

    public static function alreadyUsed_generic($loginID, $coupon) {
        $info = self::where('coupon_code', $coupon)->where('login_id', $loginID)->first();
        if ($info && $info->coupon_code) {
            return true;
        }

        return false;
    }

    public static function alreadyUsed_user($coupon) {
        return self::where('coupon_code', $coupon)->first();
        if ($info && $info->coupon_code) {
            return true;
        }

        return false;
    }
    
    public static  function insertInvoice($loginID, $shipCost, $total, $pMethod){
        if ($total > 0) {
            $result = self::create([
                'login_id'       => $loginID,
                'shipping_cost'  => $shipCost,
                'total'          => $total,
                'payment_method' => $pMethod,
            ]);

            if ($result AND $coupCode) {
                CouponTbl::updateValidity($loginID, $coupCode);
            }

            return $result;
        }

        return null;
    }

    public static  function markPaid($id, $pMethod) {
        $isPaid = self::single($id);
        if ($isPaid->status != 'Paid'){
            $invoicePay = self::where('id', $id)->update([
                'payment_method' => $pMethod,
                'status' => 'Paid',
                'date_paid' => CustomDateTime::currentTime()
            ]);

            $order = OrdersTbl::singlebByInvoice($id);
            $user = User::where('login_id' , $order->login_id)->first();

            /*
                TO-DO
                - This call is showing error
                self::buyerRewards($user, $pointValue, $order);
            */
            if ($user->referral) {
                self::referralRewards($user, $pointValue, $order);
            }

            return $invoicePay;
        }

        return false;
    }

    public static function buyerRewards($buyerInfo, $pointValue, $order) {
        $order_reward_perc = Configuration::single('order_reward_perc');
        if ($order_reward_perc > 0) {
            $points = ($order_reward_perc * $order->sub_total) / 100;
            $remark = 'Reward on item purchase with order Number #'.$order->order_number.' and order ID #'.$order->order_id;
            
            return Reward_points::createdRecord(
                $buyerInfo->login_id, 
                $order->order_number, 
                null, 
                ($points/$pointValue), // current value converted to points
                'credit', 
                $remark,
                null,
                $order->order_id
            );
        }

        return null;
    }

    public static function referralRewards($buyerInfo, $pointValue, $order) {
        $ref = User::where('login_id', $buyerInfo->referral)->first();
        
        $rewardCounts = Reward_points::rewardCounts($ref->login_id, $order->login_id);
        $referral_reward_count = Configuration::single('referral_reward_count');

        if ($ref->login_id AND $referral_reward_count > $rewardCounts) {
            // Referral rewards
            $downlines = User::userUplines($order->login_id);
            $i = 0;
            $directRef = Configuration::single('referral_direct_reward_perc');
            $indirectRef = Configuration::single('referral_indirect_reward_perc');
            
            foreach ($downlines as $value) {
                $i++;
                if ($i == 1) {
                    $points = ($directRef * $order->sub_total) / 100;
                    $remarkTop = 'referral';
                } else {
                    $points = ($indirectRef * $order->sub_total) / 100;
                    $remarkTop = 'referral level-'.$i;
                }

                $remark = 'Reward from '.$remarkTop.' item purchase with order Number #'.$order->order_number.' and order ID #'.$order->order_id;
                if ($value AND $value->login_id) {       
                    Reward_points::createdRecord(
                        $value->login_id, 
                        $order->order_number, 
                        null, 
                        ($points/$pointValue), // current value converted to points
                        'credit', 
                        $remark,
                        $order->login_id,
                        $order->order_id
                    );
                }
            }

            return true;
        }

        return null;
    }

    public static function updateStatus($id, $action, $pMethod){
        $isPaid = self::single($id);
        if ($isPaid->status != 'Paid'){
        }
        if (strtolower($action) == 'paid') {
            return self::markPaid($id, $pMethod);
        }
        else if(strtolower($action) == 'refunded' AND $isPaid->status == 'Paid') {
            return self::where('id', $id)->update([
                'status' => 'Refunded',
                'date_refunded' => CustomDateTime::currentTime()
            ]);  
        }

        return null;            
    }


    public static function userTransactions($loginID=null) {
        $orderPaid = self::where('login_id', $loginID)->where('status', 1)->sum('amount');
        $processingFee = self::where('login_id', $loginID)->where('status', 1)->sum('processing_fee');

        return array(
            'orderPaid' => $orderPaid, 
            'processingFee' => $processingFee,
            'totalPaid' => $processingFee + $orderPaid
        );
    }

    public static function allTrans(){
        $orderPaid = self::where('status', 1)->sum('amount');
        $processingFee = self::where('status', 1)->sum('processing_fee');

        return array(
            'userTrans' => self::userTransactions($loginID),
            'orderPaid' => $orderPaid,
            'processingFee' => $processingFee,
            'totalPaid' => $processingFee + $orderPaid
        );
    }



}
    
?>