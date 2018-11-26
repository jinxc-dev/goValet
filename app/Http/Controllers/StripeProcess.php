<?php

namespace App\Http\Controllers;

class StripeProcess {
    // private static $key = "sk_test_bNdusoN6ZkcByEUJK1OcRqx5";

    private static $key = "sk_live_wk3a64pOm7kNHH5jYPTj72dT";

    /**
     * product & plan managememnt (create, delete)
     */
    static function createProduct($p_name) {
        \Stripe\Stripe::setApiKey(self::$key);

        $product = \Stripe\Product::create([
            'name' => $p_name,
            'type' => 'service',
            'statement_descriptor' => 'Govalet Parking Place'
        ]);
        return $product;
    }

    static function deleteProduct($p_id) {
        \Stripe\Stripe::setApiKey(self::$key);
        $product = \Stripe\Product::retrieve($p_id);
        $result = $product->delete();
    }

    static function createPlan($p_id, $p_name, $amount) {
        \Stripe\Stripe::setApiKey(self::$key);

        $plan = \Stripe\Plan::create([
          'product' => $p_id,
          'nickname' => "monthly booking for " . $p_name,
          'interval' => 'month',
          'currency' => 'usd',
          'amount' => $amount * 100,
        ]);
        return $plan;
    }
    /**
     * customer managememnt (create, delete)
     */
    static function createCustomer($email, $token) {
        \Stripe\Stripe::setApiKey(self::$key);

        $customer = \Stripe\Customer::create([
            'email' => $email,
            'description' => 'Customer for ' . $email,
            'source' => $token,
        ]);
        return $customer;
    }

    static function deleteCustomer($c_id) {
        \Stripe\Stripe::setApiKey(self::$key);
        $cu = \Stripe\Customer::retrieve($c_id);
        $cu->delete();

    }

    /**
     * subscription managememnt (create, cancel)
     */
    static function createSubscripe($cus_id, $plan_id) {
        \Stripe\Stripe::setApiKey(self::$key);
        $date = strtotime(date('m', strtotime('+1 month')).'/01/'.date('Y').' 00:00:00');
        $subscription = \Stripe\Subscription::create([
            'customer' => $cus_id,
            'items' => [['plan' => $plan_id]],
            'billing_cycle_anchor' => $date,
            'prorate' => false,
        ]);

        return $subscription;
    }

    static function cancelSubscripe($s_id) {
        \Stripe\Stripe::setApiKey(self::$key);

        $sub = \Stripe\Subscription::retrieve($s_id);
        $ret = $sub->cancel();
    }

    static function createChargeByCustomer($c_id, $amount) {
        \Stripe\Stripe::setApiKey(self::$key);
        $charge = \Stripe\Charge::create(array(
            "amount" => $amount * 100,
            "currency" => "usd",
            "customer" => $c_id,
            "description" => "Parking Charges",
            // "destination" => array(
            //     "amount"=>($parkingInfo->rate * 100) - 2,
            //     "account" => $host->stripe_user_id,
            // ),
        ));  
        return $charge;
    }

    // static function createChargeByToken($token, $amount) {
    //     \Stripe\Stripe::setApiKey(self::$key);
    //     $charge = \Stripe\Charge::create(array(
    //         "amount" => $amount * 100,
    //         "currency" => "usd",
    //         "customer" => $customer,
    //         "description" => "Parking Charges",
    //         // "destination" => array(
    //         //     "amount"=>($parkingInfo->rate * 100) - 2,
    //         //     "account" => $host->stripe_user_id,
    //         // ),
    //     ));  
    // }

    static function refund($ch_id) {
        \Stripe\Stripe::setApiKey(self::$key);

        $re = \Stripe\Refund::create([
            "charge" => $ch_id
        ]);
        return $re;
    }
}