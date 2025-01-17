<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return File::get(public_path() . '/index.html');
});

Route::get('/testmail',function(){
    $details=[
        'title'=>'OK',
        'body'=>'no'
    ];
    \Mail::to('agneslee015@hotmail.com')->send(new \App\Mail\SendMail($details));
    echo "email has been sent";
});