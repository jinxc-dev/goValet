<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        }

        return $file_name;
    }

    public function deleteFile($path) {
        \Storage::delete($path);
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
}