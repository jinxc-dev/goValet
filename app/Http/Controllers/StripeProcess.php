<?php

namespace App\Http\Controllers;

class StripeProcess {
    private static $key = "sk_test_bNdusoN6ZkcByEUJK1OcRqx5";
    static function createProduct($p_name) {
        \Stripe\Stripe::setApiKey(self::$key);

        $product = \Stripe\Product::create([
            'name' => $p_name,
            'type' => 'service',
            'description' => 'Govalet Parking Place'
        ]);
    }

    static function createPlan($p_id, $p_name, $amount) {
        \Stripe\Stripe::setApiKey(self::$key);

        $plan = \Stripe\Plan::create([
          'product' => $p_id,
          'nickname' => "monthly booking for " . $p_name,
          'interval' => 'month',
          'currency' => 'usd',
          'amount' => $amount,
        ]);
        return $plan;
    }

    static function createCustomer($email, $token) {
        \Stripe\Stripe::setApiKey(self::$key);

        $customer = \Stripe\Customer::create([
            'email' => $email,
            'description' => 'Customer for ' . $email,
            'source' => $token,
        ]);
        return $customer;
    }

    static function createSubscripe($cus_id, $plan_id) {
        \Stripe\Stripe::setApiKey(self::$key);

        $subscription = \Stripe\Subscription::create([
            'customer' => $cus_id,
            'items' => [['plan' => $plan_id]],
        ]);

        return $subscription;
    }
}