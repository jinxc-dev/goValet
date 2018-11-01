<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use File;
use Response;

trait HelperController {

    public function saveImage($dir, $request, $name) {
        $image_extensions = array('jpeg', 'png', 'jpg', 'gif','bmp', 'svg');
        $file_name = "";
        if($request->hasfile($name)) {
            $file = $request->file($name);
            $extension = $file->getClientOriginalExtension();
            if (!in_array($extension, $image_extensions)) {
                return response()->json(['status' => 'fail', 'message' => 'Your images must be jpeg, png, jpg, gif, svg!']);
            }
            $file_name = $file->store('public/' . $dir);
        }else {
            if ($name == 'avatar') {
                $file_name = 'images/default-avatar.png';
            } else {
                $file_name = 'images/image-empty.jpg';
            }
        }

        return $file_name;
    }

    public function deleteImage($fileName) {
        $prefix = substr($fileName, 0, 7);
        if ($prefix === "public/") {            
            Storage::delete($fileName);
        }
    }

    public function deleteFile($path) {
        Storage::delete($path);
    }

    public function deleteDirectory($path) {
        Storage::deleteDirectory($path);
    }


    public function getAuthUserId(Request $request){
        if ($request->session()->has('user_id')) {
            $id = $request->session()->get('user_id');
            return $id;
        } else {
            return 0;
        }        
    }

    public function uuid4() {
        $bytes = function_exists('random_bytes') ? random_bytes(16) : openssl_random_pseudo_bytes(16);
        $hash = bin2hex($bytes);
        return $this->uuidFromHash($hash, 4);
    }

    private function uuidFromHash($hash, $version) {
        return sprintf('%08s-%04s-%04x-%04x-%12s',
        // 32 bits for "time_low"
            substr($hash, 0, 8),
        // 16 bits for "time_mid"
            substr($hash, 8, 4),
        // 16 bits for "time_hi_and_version",
        // four most significant bits holds version number
            (hexdec(substr($hash, 12, 4)) & 0x0fff) | $version << 12,
        // 16 bits, 8 bits for "clk_seq_hi_res",
        // 8 bits for "clk_seq_low",
        // two most significant bits holds zero and one for variant DCE1.1
            (hexdec(substr($hash, 16, 4)) & 0x3fff) | 0x8000,
        // 48 bits for "node"
            substr($hash, 20, 12));
    }

    static public function downloadImage($path) {
        if (!File::exists($path)) {
            abort(404);
        }
    
        $file = File::get($path);
        $type = File::mimeType($path);
    
        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);
    
        return $response;
    }

    public function getBookedSpots($p_id) {
        $parking_info = \App\Parking::where('id', $p_id)->first();
        //. monthly booking 
        $query = \App\PurchasedDetail::where('parking_id', $p_id)
                    ->where('is_canceled', 0);

        if ($parking_info->availability >= 4) {
            $query->where('parking_date', '>=', date('Y-m-d'));
        }
        $count = $query->groupBy('vehicle_id')->count();
        return $count;
    }
}