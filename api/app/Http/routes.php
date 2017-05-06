<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return 'GOOGLE MAP TEST';
});

Route::group(['middleware' => ['mapApi']], function () {
    //inserting geocode and route information
    Route::post('route', [
        'as' => 'route', 'uses' => 'RouteController@insert'
    ]);

    //getting specific geocode and route information
    Route::get('route/{token}', [
        'as' => 'route', 'uses' => 'RouteController@get'
    ]);
});
