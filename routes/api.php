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
Route::group(['namespace' => 'V1', 'prefix' => 'v1'], function () {
    Route::group([
        'prefix' => 'user',
        'middleware' => ['auth:api']
    ], function (): void {
        Route::post('/info/get/{user_id}', 'UserInfoController@index')->name('user.info.get');
        Route::post('/info/store/{user_id}', 'UserInfoController@store')->name('user.info.store');
        Route::post('/info/update/{user_id}', 'UserInfoController@update')->name('user.info.update');
    });

    // ログイン前の処理
    Route::group([], function (): void {
        Route::post('/register/first_auth','UserRegisterController@first_auth')->name('register.first_auth');
        Route::post('/register/second_auth','UserRegisterController@second_auth')->name('register.second_auth');
        Route::post('/login/first_auth','UserLoginController@first_auth')->name('login.first_auth');
        Route::post('/login/second_auth','UserLoginController@second_auth')->name('login.second_auth');
        Route::post('/forgot_password/first_auth','UserForgotPasswordController@first_auth')->name('forgot_password.first_auth');
        Route::post('/forgot_password/second_auth','UserForgotPasswordController@second_auth')->name('forgot_password.second_auth');
        Route::post('/forgot_password/update','UserForgotPasswordController@update')->name('forgot_password.update');
    });
});
