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

Route::group(['prefix' => 'auth'], function () {
    Route::post('/login','AuthController@authenticate');
    Route::post('/logout','AuthController@logout');
    Route::post('/check','AuthController@check');
    Route::post('/register','AuthController@register');
    Route::get('/activate/{token}','AuthController@activate');
    Route::post('/password','AuthController@password');
    Route::post('/validate-password-reset','AuthController@validatePasswordReset');
    Route::post('/reset','AuthController@reset');
    Route::post('/social/token','SocialAuthController@getToken');
});

Route::group(['middleware' => ['jwt.auth']], function () {
  Route::get('/auth/user','AuthController@getAuthUser');
  Route::post('/task','TaskController@store');
  Route::get('/task','TaskController@index');
  Route::delete('/task/{id}','TaskController@destroy');
  Route::get('/task/{id}','TaskController@show');
  Route::patch('/task/{id}','TaskController@update');
  Route::post('/task/status','TaskController@toggleStatus');

    Route::post('/city','CityController@store');
    Route::get('/city','CityController@index');
    Route::delete('/city/{id}','CityController@destroy');
    Route::get('/city/{id}','CityController@show');
    Route::patch('/city/{id}','CityController@update');

    Route::post('/room','RoomController@store');
    Route::get('/room','RoomController@index');
    Route::delete('/room/{id}','RoomController@destroy');
    Route::get('/room/{id}','RoomController@show');
    Route::patch('/room/{id}','RoomController@update');

    Route::post('/images-upload', 'ImagesController@upload');
    Route::get('/images/by_room_id/{id}','ImagesController@getByRoomId');

    Route::post('/room_type','RoomTypeController@store');
    Route::get('/room_type','RoomTypeController@index');
    Route::delete('/room_type/{id}','RoomTypeController@destroy');
    Route::get('/room_type/{id}','RoomTypeController@show');
    Route::patch('/room_type/{id}','RoomTypeController@update');

    Route::post('/condition','ConditionController@store');
    Route::get('/condition','ConditionController@index');
    Route::delete('/condition/{id}','ConditionController@destroy');
    Route::get('/condition/{id}','ConditionController@show');
    Route::patch('/condition/{id}','ConditionController@update');

    Route::get('/configuration/fetch','ConfigurationController@index');
    Route::post('/configuration','ConfigurationController@store');

    Route::get('/user','UserController@index');
    Route::post('/user/change-password','AuthController@changePassword');
    Route::post('/user/update-profile','UserController@updateProfile');
    Route::post('/user/update-avatar','UserController@updateAvatar');
    Route::post('/user/remove-avatar','UserController@removeAvatar');
    Route::delete('/user/{id}','UserController@destroy');
    Route::get('/user/dashboard','UserController@dashboard');

    Route::post('todo','TodoController@store');
    Route::get('/todo','TodoController@index');
    Route::delete('/todo/{id}','TodoController@destroy');
    Route::post('/todo/status','TodoController@toggleStatus');
});
