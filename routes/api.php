<?php

use Illuminate\Http\Request;

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


