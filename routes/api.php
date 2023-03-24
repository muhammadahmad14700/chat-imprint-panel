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

/* 
Route::middleware('auth:api')->get('/user', function (Request $request) {
    //return $request->user();
    Route::post('/logout', 'Api\ApiAuthController@logout')->name('logout.api');
});

Route::post('/login', 'Api\ApiAuthController@login')->name('login.api');
Route::post('/register', 'Api\ApiAuthController@register')->name('register.api'); 
*/
Route::prefix('v1')->group(function () {
    Route::group(['namespace' => 'Api', 'as' => 'api.'], function () {

        Route::post('login', 'LoginController@login')->name('login');
        Route::post('social_login', 'LoginController@social_login')->name('social_login');
        Route::post('register', 'RegisterController@register')->name('register');
        Route::post('social_login_mobile', 'SocialLoginController@social_login_mobile')->name('social_login_mobile');
        Route::post('updateUser', 'AuthenticationController@updateUser')->name('updateUser');
        Route::group(['middleware' => ['auth:api']], function () {
            Route::get('email/verify/{hash}', 'VerificationController@verifycode')->name('verification.verify');
            Route::get('email/resend', 'VerificationController@resend')->name('verification.resend');
            //Route::get('user', 'AuthenticationController@user')->name('user');
            Route::get('update-name', 'AuthenticationController@updateName')->name('update-name');
            Route::get('updatePassword', 'AuthenticationController@updatePassword')->name('updatePassword');
            //Route::post('updateUser', 'AuthenticationController@updateUser')->name('updateUser');
            Route::post('logout', 'LoginController@logout')->name('logout');
            Route::post('social_login', 'LoginController@social_login')->name('social_login');
            
        });

    });
});