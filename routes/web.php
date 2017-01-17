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

    $client = new GuzzleHttp\Client();
    $res = $client->request('GET', 'https://api.login.yahoo.com/oauth2/request_auth?client_id=' . env('CONSUMER_KEY') . '&redirect_uri=https://salarycaptaincrunch.com/api/callback?api_token='.Auth::user()->api_token.'&response_type=token&language=en-us', [
        'auth' => ['user', 'pass']
    ]);
    echo $res->getBody();
})->middleware('auth');

Auth::routes();

Route::get('/home', 'HomeController@index');
