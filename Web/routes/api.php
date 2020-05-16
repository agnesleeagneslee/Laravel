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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('user/showall', 'UserController@showall');

Route::post('login', 'UserController@login');

Route::get('user/{user}', 'UserController@checkLogin');

Route::get('news/showall', 'NewsController@showall');

Route::get('curriculum/showall', 'CurriculumController@showall');

Route::get('login/forgetPW', 'UserController@forgetPW');