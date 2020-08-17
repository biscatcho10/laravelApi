<?php

use Illuminate\Http\Request;
use Illuminate\Routing\RouteGroup;
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

Route::post('register', 'Auth\AuthController@register');
Route::post('login', 'Auth\AuthController@login');

Route::group(['middleware' => 'jwt.auth'], function () {
    Route::group(['namespace' => 'Auth'], function () {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@getAuthUser');
    });

    Route::group(['namespace' => 'API'], function () {
        Route::resource('books', 'BookController');
    });
});
