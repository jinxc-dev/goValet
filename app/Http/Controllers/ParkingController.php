<?php

namespace App\Http\Controllers;

use App\Parking;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ParkingController extends Controller
{
    use HelperController;

    public function register(Request $request){
        
        $user_id = $this->getAuthUserId($request);
        
        if ($user_id == 0) 
            return response()->json(['status' => 'error', 'message' => "User is not Authed"]);

        if (Parking::where('user_id', $user_id)->count() >= 6) 
            return response()->json(['status' => 'error', 'message' => "Vehicle is overflow"]);

        $data = $request->all();
        $data['image'] = $this->saveImage("parking/{$user_id}", $request, 'image');
        $data['user_id'] = $user_id;
        $data['capacity'] = $request->parking_spots;

        Parking::create($data);

        return response()->json(['status' => true, 'data' => $data]);
    }

    /**
     * get parking info by id
     */
    public function get(Request $request) {
        $user_id = $this->getAuthUserId($request);
        
        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => "User is not Authed"]);
        }
        $v_item = Parking::where('id', $request->id)->first();
        $count = $this->getBookedSpots($request->id);
        $v_item->currentCnt = $count;
        return response()->json(['status' => true, 'data' => $v_item]);
    }

    /**
     * get parking list by user.
     */
    public function getByUser(Request $request) {
        $user_id = $this->getAuthUserId($request);
        
        if ($user_id == 0) {
            return response()->json(['status' => false, 'message' => "User is not Authed"]);
        }
        $v_item = Parking::where('user_id', $user_id)->get();

        return response()->json(['status' => true, 'data' => $v_item]);
    }

    /**
     * search parking by distance 
     */
    public function searchParking(Request $request) {
        $user_id = $this->getAuthUserId($request);
        
        if ($user_id == 0) {
            return response()->json(['status' => 'error', 'message' => "User is not Authed"]);
        }

        // $_items = Parking::whereIn('availability', $request->type)->get();        

        $select = '*, ( 6371 * acos( cos( radians("' . $request->lat . '") ) *
            cos( radians(latitude) ) *
            cos( radians(longitude) - radians("' . $request->lng . '") ) + 
            sin( radians("' . $request->lat . '") ) *
            sin( radians(latitude) ) ) ) 
            AS distance';
        $_items = DB::table('parkings')->selectRaw($select)
                ->having('distance', '<', 50)
                ->whereIn('availability', $request->type)->get();
        return response()->json(['status' => true, 'data' => $_items]);
    }

    public function update(Request $request) {
        $user_id = $this->getAuthUserId($request);
        
        if ($user_id == 0 || $user_id != $request->user_id) {
            return response()->json(['status' => 'error', 'message' => "User is not Authed"]);
        }

        $image = $request->imageName;
        if($request->hasfile('image')) {
            $this->deleteImage($image);
            $image = $this->saveImage("parking/{$user_id}", $request, 'image');
        } 
        $parking = Parking::where('id', $request->id)->first();
        $parking->name = $request->name;
        $parking->from_time = $request->from_time;
        $parking->to_time = $request->to_time;
        $parking->image = $image;
        $parking->capacity = $request->availability;
        $parking->rate = $request->rate;
        $parking->save();
        return response()->json(['status' => true, 'data' => "Update Success"]);
    }

    
    public function delete($id, $u_id, Request $request) {

        $user_id = $this->getAuthUserId($request);
        
        if ($user_id == 0 || $user_id != $u_id) {
            return response()->json(['status' => 'error', 'message' => "User is not Authed"]);
        }
        $count = $this->getBookedSpots($id);
        if ($count == 0) {
            $item = Parking::where('id', $id)->first();
            $this->deleteImage($item->image);
            $item->delete();
            return response()->json(['status' => true, 'message' => "Parking delete is done successfully"]);
        } 

        return response()->json(['status' => false, 'message' => "Parking delete is failed.\nBooking vehicle is already existed"]);
    }

}
