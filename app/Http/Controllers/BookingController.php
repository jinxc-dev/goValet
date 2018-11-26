<?php

namespace App\Http\Controllers;

use App\Parking;
use App\PaymentDetail;
use App\PurchasedDetail;
use App\Vehicle;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HelperController;
use App\Http\Controllers\StripeProcess;

class BookingController extends Controller
{
    use HelperController;

    public function pay(Request $request) {
        $user_id = $this->getAuthUserId($request);
        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => "User is not Authed"]);
        }
        $token = $request->token;

        // \Stripe\Stripe::setApiKey("sk_test_bNdusoN6ZkcByEUJK1OcRqx5");
        \Stripe\Stripe::setApiKey("sk_live_wk3a64pOm7kNHH5jYPTj72dT");

        
        $parkingInfo = Parking::where('id', $request->parking_id)->first();
        $host = User::where('id', $parkingInfo->user_id)->first();
        $user = User::where('id', $user_id)->first();

        $amount = $parkingInfo->rate;
        $w_sub_id = 0;
        //. case month payment.
        try {
            if ($parkingInfo->availability < 4) {
                $amount = $this->calcPayAmount($request->booking_date, $amount, 1);
                $w_data = $this->createMonthlySubscription($user, $parkingInfo, $token);
                $w_sub_id = $w_data['sub_id'];
                // return response()->json(['status' => $w_data]);
                $charge = StripeProcess::createChargeByCustomer($w_data['customer_id'], $amount);
            } else {
                $charge = \Stripe\Charge::create(array(
                    "amount" => $amount * 100, // Amount in cents
                    "currency" => "usd",
                    "source" => $token,
                    "description" => "Parking Charges",
                    // "destination" => array(
                    //     "amount"=>($parkingInfo->rate * 100) - 2,
                    //     "account" => $host->stripe_user_id,
                    // ),
                ));
            }
            if ( strcmp ( $charge->status, "succeeded") == 0 ){
                $payment = new PaymentDetail();
                $payment->user_id = $user_id;
                $payment->transaction_on = date('Y-m-d');
                $payment->transaction_id = $charge->id;
                $payment->transaction_request_id = $charge->balance_transaction;
                $payment->note = $charge->description;
                $payment->amount = $charge->amount;
                $payment->card_number = $request->card_number;
                $payment->save();

                $purchased = new PurchasedDetail();
                $purchased->user_id = $user_id;
                $purchased->vehicle_id = $request->vehicle_id;
                $purchased->parking_id = $request->parking_id;
                $purchased->parking_date = $request->booking_date;
                $purchased->transaction_id = $charge->id;
                $purchased->amount = $parkingInfo->rate;
                $purchased->subscription_id = $w_sub_id;
                $purchased->save();

                // $renter = UserDetails::where('id', $request->user_id)->first();

                // $beautymail = app()->make(\Snowfire\Beautymail\Beautymail::class);
                // $beautymail->queue('emails.email_parkingowner', [], function($message) use ($user)
                // {
                //     $message
                //         ->from('noreply@goparkingvalet.com')
                //         ->to($user->email, $user->first_name)
                //         ->subject('GoValet - Request for parking.');
                // });
                return response()->json(['status' => true]);
            } else {
                return response()->json(['status' => false]);
            }
        } catch (\Stripe\Error\Card $e) {
            return response()->json(['status' => false]);
        }

    }

    public function getPurchasedInfo(Request $request) {
        $user_id = $this->getAuthUserId($request);
        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => "User is not Authed"]);
        }

        $query = PurchasedDetail::with('vehicle', 'parking', 'payment');
        $type = $request->type;
        $query->where('user_id', $user_id)
            ->where('is_canceled', 0)
            ->where('parking_date', '>=', date('Y-m-d'))
            ->orderBy('parking_date');
        $query->whereHas('parking', function($q) {
            $q->where('availability', request('type'));
        });
        $info = $query->get();
        return response()->json(['status' => true, 'data' => $info]);
    }

    public function getPurchasedMonthly(Request $request) {
        $user_id = $this->getAuthUserId($request);
        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => "User is not Authed"]);
        }
        $query = PurchasedDetail::with('vehicle', 'parking', 'payment');
        $query->where('user_id', $user_id)
            ->where(function($q){
                $q->where('is_canceled', 0)
                    ->orWhere('expire_date', '>', date('Y-m-d'));
            })
            ->orderBy('parking_date');

        $query->whereHas('parking', function($q) {
            $q->where('availability', '<', 4);
        });
        $query->whereHas('vehicle', function($q) {
            $q->where('id', '>', 0);
        });
        $info = $query->get();
        return response()->json(['status' => true, 'data' => $info]);
    }

    public function getBookingByParkingId($id, Request $request) {
        // $p_id = $request->p_id;
        $parking_info = \App\Parking::where('id', $id)->first();
        
        $user_id = $this->getAuthUserId($request);
        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => "User is not Authed"]);
        }
        //. monthly booking 
        $query = \App\PurchasedDetail::with('vehicle', 'user')
                    ->where('parking_id', $id)
                    ->where('is_canceled', 0);

        if ($parking_info->availability >= 4) {
            $query->where('parking_date', '>=', date('Y-m-d'));
        }
        $items = $query->get();
        return response()->json(['status' => true, 'data' => compact('items', 'parking_info')]);
    }

    /**
     * cancel or terminate process
     */
    public function setTerminateBooking(Request $request) {
        $user_id = $this->getAuthUserId($request);
        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => "User is not Authed"]);
        }
        //. id
        $id = $request->id;
        $purchasedInfo = PurchasedDetail::where('id', $id)->first();
        $subInfo = \App\Subscription::where('id', $purchasedInfo->subscription_id)->first();

        $amount = $this->calcPayAmount(date('Y-m-d'), $purchasedInfo->amount, -1);

        try {
            //. create charge

            $charge = StripeProcess::createChargeByCustomer($subInfo->s_cus_id, $amount);
            //. cancel subscription
            StripeProcess::cancelSubscripe($subInfo->s_sub_id);
            StripeProcess::deleteCustomer($subInfo->s_cus_id);
            $purchasedInfo->is_canceled = 1;
            $purchasedInfo->expire_date =  date('Y-m-d', strtotime('+1 month'));
            $purchasedInfo->save();
            return response()->json(['status' => true, 'data' => ['expire_date' => $purchasedInfo->expire_date, 'amount' => $amount]]);
        }catch (\Stripe\Error\Card $e) {
            return response()->json(['status' => false]);
        }

    }

    public function setCancelBooking(Request $request) {
        $user_id = $this->getAuthUserId($request);
        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => "User is not Authed"]);
        }

        $id = $request->id;
        $purchasedInfo = PurchasedDetail::where('id', $id)->first();
        $diff = HelperController::getDiffHours($purchasedInfo->created_at, date('Y-m-d H:m:s'));
        if ($diff > 24) {
            return response()->json(['status' => false, 'message' => "You can't cancel for this booking.\n Because pass 24 hours over."]);
        }

        //. refund
        try {
            $status = StripeProcess::refund($purchasedInfo->transaction_id);
            if ($status->status == "succeeded") {
                $purchasedInfo->is_canceled = 1;
                $purchasedInfo->expire_date =  date('Y-m-d');
                $purchasedInfo->save();
            }
            return response()->json(['status' => true, 'data' => $status]);
        }catch (\Stripe\Error\Card $e) {
            return response()->json(['status' => false, 'message' => 'Refund Error']);
        }


    }
    /*
    type:    1 => last days of month
            -1 => first days of month
    */
    public function calcPayAmount($date, $rate, $type = 1) {
        $day = (int) substr($date, -2);
        if ($type == 1) {
            $day = 31 - $day;
        }
        $amount = round($rate * $day / 30); 
        return $amount;
    }

    public function createMonthlySubscription($user, $parking_info, $token) {
        $customer = StripeProcess::createCustomer($user->email, $token);
        $sub = StripeProcess::createSubscripe($customer, $parking_info->s_plan_id);

        $data = new \App\Subscription();
        $data->user_id = $user->id;
        $data->s_cus_id = $customer->id;
        $data->s_sub_id = $sub->id;
        $ret = $data->save();
        $lastData = \App\Subscription::latest()->first();
        return [
            'customer_id' => $customer->id,
            'sub_id' => $lastData->id
        ];
    }




}
