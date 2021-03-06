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

Route::post('login', 'UsersController@login');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('users/filter/{related?}', 'UsersController@filter');
Route::post('roles/filter/{related?}', 'RolesController@filter');

Route::post('users/filter', 'UsersController@filter');
Route::post('roles/filter', 'RolesController@filter');


Route::resource('users', 'UsersController');
Route::resource('roles', 'RolesController');
