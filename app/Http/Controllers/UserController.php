<?php

namespace App\Http\Controllers;

use App\User;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\StripeProcess;

class UserController extends Controller
{
    use HelperController;

    public function login(Request $request) {
        $user = User::where('email', $request->email)->first();
        $isAuthed = false;
        if ($user){
            if (Hash::check($request->password, $user->password)) {
                $request->session()->put('user_id', $user->id);
                $isAuthed = true;
            }
        }
        return response()->json(['authed' => $isAuthed]);
    }

    public function logout(Request $request) {
        $request->session()->flush();
    }
    
    public function check(Request $request) {
        
        if ($request->session()->has('user_id')) {
            $id = $request->session()->get('user_id');
            $user = $this->getUserById($id);
            return response()->json(['authed' => true, 'user' => $user]);
        } else {
            return response()->json(['authed' => false]);
        }        
    }

    public function getUserById($id) {
        $user = User::where('id', $id)->first();
        if ($user) {
            return $user;
        } else {
            return array();
        }
    }

    public function register(Request $request){
        
        $validation = Validator::make($request->all(), [
            'first_name' => 'required',
            'email' => 'required|email|max:255',
            'password' => 'required',
            'phone' => 'required'
        ]);

        if($validation->fails())
            return response()->json(['status' => false, 'message' => $validation->messages()->first()]);

        if (User::where('email', $request->email)->exists()) {
            return response()->json(['status' => false, 'message' => "User already exist. Try again!"]);
        } else {
            $avatarUrl = '';
            $user = new User();
            $user->uuid = $this->uuid4();
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->phone = $request->phone;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->type = $request->user_type;
            $user->avatar = $this->saveImage('avatars', $request, 'avatar');
            $user->save();
            // $user = app()->make(\Snowfire\Beautymail\Beautymail::class);
            // $user->send('emails.email_welcome', ['user'=>$createUser], function($message) use ($createUser)
            // {
            //     $message
            //         ->from('noreply@goparkingvalet.com')
            //         ->to($createUser->email, $createUser->first_name)
            //         ->subject('Welcome!');
            // });

            return response()->json(['status' => true, 'data' => $user]);
        }
        return response()->json(['status' => true, 'message' => 'Reset link sent your email address.']);
    }


}
