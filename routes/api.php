<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['prefix' => 'user'], function () {
    Route::post('/register','UserController@register');
    Route::post('/login','UserController@login');
    Route::post('/check','UserController@check');
    Route::post('/logout','UserController@logout');       
    Route::get('/activate/{token}','AuthController@activate');
    Route::post('/password','AuthController@password');
    Route::post('/validate-password-reset','AuthController@validatePasswordReset');
    Route::post('/reset','AuthController@reset');
    Route::post('/social/token','SocialLoginController@getToken');
});

Route::group(['prefix' => 'vehicle'], function () {
    Route::post('/register','VehicleController@register');
    Route::get('/get', 'VehicleController@get');
    Route::delete('/delete/{id}', 'VehicleController@delete');
});

Route::group(['prefix' => 'parking'], function () {
    Route::post('/register','ParkingController@register');
    Route::get('/get', 'ParkingController@get');
    Route::get('/searchParking', 'ParkingController@searchParking');
    // Route::delete('/delete/{id}', 'VehicleController@delete');
});

Route::group(['prefix' => 'booking'], function () {
    Route::post('/pay', 'BookingController@pay');
});

Route::get('/country-list', function() {
    return DB::table('apps_countries')->get();
});


// Route::get('storage/{filename}', function ($filename)
// {

//     echo storage_path($filename);
//     return;
    
//     $path = storage_path($filename);
//     return $path;

//     if (!File::exists($path)) {
//         abort(404);
//     }

//     $file = File::get($path);
//     $type = File::mimeType($path);

//     $response = Response::make($file, 200);
//     $response->header("Content-Type", $type);

//     return $response;
// });



