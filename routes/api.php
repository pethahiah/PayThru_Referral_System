<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::namespace('API')->group(function () {
    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');
    Route::get('getCountry', 'AuthController@getCountry');
    Route::get('getState/{state}', 'AuthController@getState');
    Route::post('forgot', 'ForgotController@forgot');
    Route::post('reset', 'ForgotController@reset');
   
    
    Route::middleware(['auth:api'])->group(function () {
    // User Update and related activity
       Route::get('getProfile', 'AuthController@getProfile');
       Route::get('logout', 'AuthController@logout');
        Route::post('updateProfile', 'AuthController@updateProfile');
       Route::post('updateUsertype/{id}', 'AuthController@updateUsertype');
      
       });
   });       