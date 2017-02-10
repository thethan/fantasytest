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

Route::get('/bridge', function() {
    $pusher = App::make('pusher');

    $pusher->trigger( 'test-channel',
        'test-event',
        array('text' => 'Preparing the Pusher Laracon.eu workshop!'));

//    return view('welcome');
});


Route::get('yahoo', function () {

    return redirect('https://api.login.yahoo.com/oauth2/request_auth?client_id=' . env('CONSUMER_KEY') . '&redirect_uri=https://fantasydraftroom.com/api/callback?api_token='.Auth::user()->api_token.'&response_type=token&language=en-us');

})->middleware('auth');



Route::get('games', function(){
    $client = new GuzzleHttp\Client();
    $client->request('GET', 'https://api.login.yahoo.com/oauth2/request_auth?client_id=' . env('CONSUMER_KEY') . '&redirect_uri=https://fantasydraftroom.com/api/callback?api_token='.Auth::user()->api_token.'&response_type=token&language=en-us', [
        'auth' => ['user', 'pass']
    ]);
})->middleware('auth');


Route::group(['prefix' => 'yahoo'], function(){
    Route::get('yahoo', function (){
        return redirect('https://api.login.yahoo.com/oauth2/request_auth?client_id='. env('CONSUMER_KEY') .'&redirect_uri=https://fantasydraftroom.com/api/yahoo/callback&response_type=code&language=en-us&state='.Auth::user()->api_token);
    })->middleware('auth');



});
Auth::routes();

Route::get('/players', 'HomeController@players')->middleware('auth');
Route::get('/home', 'HomeController@index');
