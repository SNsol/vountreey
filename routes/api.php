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
    Route::post('register', 'Api\AuthController@register');
	Route::post('login', 'Api\AuthController@login');
	// Password Reset Routes...
    Route::post('password/email', 'Api\ForgotPasswordController@sendResetLinkEmail');
    Route::get('password/reset/{token}', 'Api\ResetPasswordController@showResetForm');
    Route::post('password/reset', 'Api\ResetPasswordController@reset');
});

Route::group(['prefix' => 'v1'], function() {
	Route::post('change-password', 'Api\AuthController@changePassword');
});
