<?php

namespace App\Http\Controllers;

use App\Parking;
use App\PaymentDetail;
use App\PurchasedDetail;
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

        \Stripe\Stripe::setApiKey("sk_test_ycrFkbDFj65ONW3rOQn2P3vx");
        $parkingInfo = Parking::where('id', $request->parking_id)->first();
        $host = User::where('id', $parkingInfo->user_id)->first();
        $user = User::where('id', $user_id)->first();

        try {
            $charge = \Stripe\Charge::create(array(
                "amount" => $parkingInfo->rate * 100, // Amount in cents
                "currency" => "usd",
                "source" => $token,
                "description" => "Parking Charges",
                "destination" => array(
                    "amount"=>($parkingInfo->rate * 100) - 2,
                    "account" => $host->stripe_user_id,
                ),
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
                $purchased->parking_date = $request->parking_date;
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
            }
        } catch (\Stripe\Error\Card $e) {

        }

    }

}
