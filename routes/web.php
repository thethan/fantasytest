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

    return redirect('https://api.login.yahoo.com/oauth2/request_auth?client_id=' . env('CONSUMER_KEY') . '&redirect_uri=https://salarycaptaincrunch.com/api/callback?api_token='.Auth::user()->api_token.'&response_type=token&language=en-us');

})->middleware('auth');



Route::get('games', function(){
    $client = new GuzzleHttp\Client();
    $res = $client->request('GET', 'https://api.login.yahoo.com/oauth2/request_auth?client_id=' . env('CONSUMER_KEY') . '&redirect_uri=https://salarycaptaincrunch.com/api/callback?api_token='.Auth::user()->api_token.'&response_type=token&language=en-us', [
        'auth' => ['user', 'pass']
    ]);
//    359.l.242042
})->middleware('auth');


Route::group(['prefix' => 'yahoo'], function(){
    Route::get('yahoo', function (){
        $client = new GuzzleHttp\Client();
//        $res = $client->request('POST', 'https://api.login.yahoo.com/oauth2/request_auth?client_id='.env('CONSUMER_KEY'), [
//            'form_params' => [
//                'client_id' => env('CONSUMER_KEY'),
//                'response_type' => 'code',
//                'redirect_uri' => '/api/yahoo/callback'
//            ]
//        ]);
//        print $res->getBody()->getContents();
        return redirect('https://api.login.yahoo.com/oauth2/request_auth?client_id='. env('CONSUMER_KEY') .'&redirect_uri=https://salarycaptaincrunch.com/api/yahoo/callback&response_type=code&language=en-us&state='.Auth::user()->api_token);
    })->middleware('auth');

    Route::get('players', function(){
        $players = new App\Yahoo\Fantasy\Players\Get();
        $response = $players->call();
        dump($response);
    })->middleware('auth');
});
Auth::routes();

Route::get('/home', 'HomeController@index');
