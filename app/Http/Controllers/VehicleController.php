<?php

namespace App\Http\Controllers;

use App\Vehicle;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VehicleController extends Controller
{
    use HelperController;

    public function register(Request $request){
        
        $validation = Validator::make($request->all(), [
            'plate_number' => 'required',
        ]);

        if($validation->fails())
            return response()->json(['status' => 'error', 'message' => $validation->messages()->first()]);

        $user_id = $this->getAuthUserId($request);
        
        if ($user_id == 0) 
            return response()->json(['status' => 'error', 'message' => "User is not Authed"]);

        if (Vehicle::where('user_id', $user_id)->count() >= 3) 
            return response()->json(['status' => 'error', 'message' => "Vehicle is overflow"]);

        if (Vehicle::where('plate_number', $request->plate_number)->exists()) {
            return response()->json(['status' => 'error', 'message' => "Vehicle already exist"]);
        } else {
            $model = new Vehicle();
            return $this->save($request, $model, $user_id);            
        }
        return response()->json(['status' => true, 'message' => 'Reset link sent your email address.']);
    }

    public function save(Request $request, $model, $user_id) {
        $model->user_id = $user_id;
        $model->brand = $request->brand;
        $model->model = $request->model;
        $model->plate_number = $request->plate_number;
        $model->expire_date = $request->expire_date;
        $model->photo = $this->saveImage("vehicle/{$user_id}", $request, 'photo');
        $model->save();
        return $model;
    }

    public function get(Request $request) {
        $user_id = $this->getAuthUserId($request);
        
        if ($user_id == 0) {
            return response()->json(['status' => 'error', 'message' => "User is not Authed"]);
        }
        $v_item = Vehicle::where('user_id', $user_id)->get();

        return $v_item;
    }

    public function delete($id, Request $request) {

        $item = Vehicle::where('id', $id)->first();
        $this->deleteFile($item->photo);
        Vehicle::where('id', $id)->delete();
        return $this->get($request);
    }


}
