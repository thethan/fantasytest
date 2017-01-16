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

Route::get('yahoo', function (){

    $client = new GuzzleHttp\Client();
    $res = $client->request('GET', 'https://api.login.yahoo.com/oauth2/request_auth?client_id='.env('CONSUMER_KEY').'&redirect_uri=https://salarycaptaincrunch.com/callback&response_type=token&language=en-us', [
        'auth' => ['user', 'pass']
    ]);
//    echo $res->getStatusCode();
// "200"
//    print_r( $res->getHeader('content-type'));
// 'application/json; charset=utf8'
    echo $res->getBody();
//    https://api.login.yahoo.com/oauth2/request_auth?client_id=dj0yJmk9ak5IZ2x5WmNsaHp6JmQ9WVdrOVNqQkJUMnRYTjJrbWNHbzlNQS0tJnM9Y29uc3VtZXJzZWNyZXQmeD1hYQ--&redirect_uri=http://www.example.com&response_type=token&language=en-us
});
