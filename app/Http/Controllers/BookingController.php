<?php

namespace App\Http\Controllers;

use App\Parking;
use App\PaymentDetail;
use App\PurchasedDetail;
use App\Vehicle;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BookingController extends Controller
{
    use HelperController;

    public function pay(Request $request) {
        $user_id = $this->getAuthUserId($request);
        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => "User is not Authed"]);
        }
        $token = $request->token;

        \Stripe\Stripe::setApiKey("sk_test_bNdusoN6ZkcByEUJK1OcRqx5");
        $parkingInfo = Parking::where('id', $request->parking_id)->first();
        $host = User::where('id', $parkingInfo->user_id)->first();
        $user = User::where('id', $user_id)->first();

        try {
            $charge = \Stripe\Charge::create(array(
                "amount" => $parkingInfo->rate * 100, // Amount in cents
                "currency" => "usd",
                "source" => $token,
                "description" => "Parking Charges",
                // "destination" => array(
                //     "amount"=>($parkingInfo->rate * 100) - 2,
                //     "account" => $host->stripe_user_id,
                // ),
            ));
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
        $query->whereHas('parking', function($q) {
            $q->where('availability', request('type'));
        });
        $info = $query
                    ->where('user_id', $user_id)
                    ->where('is_canceled', 0)
                    ->where('parking_date', '>=', date('Y-m-d'))
                    ->orderBy('parking_date')
                    ->get();
        return response()->json(['status' => true, 'data' => $info]);
    }

    public function getPurchasedMonthly(Request $request) {
        $user_id = $this->getAuthUserId($request);
        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => "User is not Authed"]);
        }
        $query = PurchasedDetail::with('vehicle', 'parking', 'payment');
        $query->whereHas('parking', function($q) {
            $q->where('availability', '<', 3);
        });
        $query->whereHas('vehicle', function($q) {
            $q->where('id', '>', 0);
        });
        $info = $query
                    ->where('user_id', $user_id)
                    ->where('is_canceled', 0)
                    ->orderBy('parking_date')
                    ->get();
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




}
