<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');

});


Route::get('yahoo', function () {

    return redirect('https://api.login.yahoo.com/oauth2/request_auth?client_id=' . env('CONSUMER_KEY') . '&redirect_uri=https://salarycaptaincrunch.com/api/callback?api_token='.Auth::user()->api_token.'&response_type=token&language=en-us');

})->middleware('auth');

Auth::routes();

Route::get('/home', 'HomeController@index');
