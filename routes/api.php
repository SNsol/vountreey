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

Route::group(['prefix' => 'v1', 'middleware' => 'cors'], function() {
    Route::post('register', 'Api\AuthController@register');
	Route::post('login', 'Api\AuthController@login');
	// Password Reset Routes...
    Route::post('forgot_password/email', 'Api\ForgotPasswordController@sendResetLink');
});

Route::group(['prefix' => 'v1','middleware' => ['api', 'cors']], function() {
	Route::post('change-password', 'Api\AuthController@changePassword');
	Route::post('add-project', 'Api\ProjectController@addProject');
	Route::post('project-list', 'Api\ProjectController@projectList');
	Route::post('update-project', 'Api\ProjectController@updateProject');
	Route::post('project-details', 'Api\ProjectController@projectDetails');
	Route::post('remove-project', 'Api\ProjectController@removeProject');


	Route::post('add-hour', 'Api\HourController@addHour');
});
