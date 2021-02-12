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
Route::group(['prefix' => 'v1'], function() {
    Route::group([
        'prefix' => 'user',
        'middleware' => ['auth']
    ], function() {
        Route::post('/update/{user_id}', 'UserController@update')->name('user.update');
        Route::post('/password/update/first_auth/{user_id}', 'UserPasswordController@first_auth')->name('user.password.update.first_auth');
        Route::post('/password/update/second_auth/{user_id}', 'UserPasswordController@second_auth')->name('user.password.update.second_auth');
        Route::post('/signup/first_auth/{user_id}', 'UserSignupController@first_auth')->name('user.signup.first_auth');
        Route::post('/signup/second_auth/{user_id}', 'UserSignupController@second_auth')->name('user.signup.second_auth');
        Route::post('/graph/get/{user_id}', 'UserGraphController@index')->name('user.graph.get');
        Route::post('/graph/store/{user_id}', 'UserGraphController@store')->name('user.graph.store');
        Route::post('/all/delete/{user_id}', 'UserController@delete')->name('user.all.delete');
    });

    // ログイン前の処理
    Route::group([], function () {
        Route::post('/user/create','UserController@create')->name('user.create');
        Route::post('/login/first_auth','UserLoginController@first_auth')->name('login.first_auth');
        Route::post('/login/second_auth','UserLoginController@second_auth')->name('login.second_auth');
        Route::post('/forgot_password/first_auth','UserForgotPasswordController@first_auth')->name('forgot_password.first_auth');
        Route::post('/forgot_password/second_auth','UserForgotPasswordController@second_auth')->name('forgot_password.second_auth');
        Route::post('/forgot_password/update','UserForgotPasswordController@update')->name('forgot_password.update');
    });
});
