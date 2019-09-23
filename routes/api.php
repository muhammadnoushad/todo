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

Route::group(['prefix' => 'auth'], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

});

Route::group(['miidleware' => 'jwt.auth'], function ($router) {

    Route::get('todos', 'TodosController@all');
    Route::post('todos/new', 'TodosController@store');
    Route::get('todos/{id}', 'TodosController@get');
    Route::delete('todo/{id}', 'TodosController@destroy');
    Route::put('todos', 'TodosController@update');
    Route::put('todos/complete/{id}', 'TodosController@mark_complete');
    

});