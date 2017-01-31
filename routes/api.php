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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::group(['middleware' => 'auth:api'], function () {

    Route::get('callback', function () {
        // https://salarycaptaincrunch.com/callback#access_token=iZwqFGCY4Br381U1Zn5grIc0Wo9NRWJlxoUY9_XIZM5oaDU9O6qqYElBcJHp8_U6wkuOoDmqP_7YfQLfVTVnIXK.e_vGH3culuD.heRo4xIIhsSSbk5v1TM6BClQ1lIFcw7vCm50ISyziKzjVJ2.jXqNMMgd_8cZGQ6_2UIxL1r0reTET_m5y5IuP83uPbXEUOIT4QVzNO.M7_gkzO4FcKKjS6u0AJPV73gO92R0wNLaa8odmFa8AoWVQ9CogseiD4ELU89mpo.D2dU9QYDNQI3ClJyHePN4eKUJ.ztw.NGXW3mh8NZkYnPqY5YboAB0zLUUYC9xVD6GLDQwfE1InO7zVN.9k5_4sFpd6eOZ_9ba_tcTiKbLU.QxwxpqqgzzIiIcR9dr9zprvpR3L_in2Sgk4Iw4HvMyBMRXkCzhbFo6vUedCqLGRrx1QjsxTekQtuJndxfPi96EYKIb3hLR060sztfPGJJtH7R902rmCboiPBuUEjfcAu4PRtm3kwPytEgcqaertLCXJgDeXsGCzniok3kFpoCWNTtawnoIBj1kSVArY5AMlxubms3MidESpf.VIEuvBzk_C26xL8A0aB87BHyZEfrE2tLpjdolrzR0aK0_iOFUV.Nj_lnYfLQqFr3GTG1UUpOxGQn5U4i7CFEVGc7okO6z67jju6pL5D6HB2gKB8MLeENN6ANwU8VkOchhcyxHd9AOo2TZOvXMpyfEh9uyjL9WpbaR0L7AV5GJ_bxg5F0zz466qZQNxXQX8ZKyS2noYcCvCOxiBIgj8n7I._bnsjPyElj8Gyko4Rspg6ezwP3QXncJfYa3zopr7lHBg2ExkiXD_r_cNFTu5LetJA_EkdUqMfZ2jJdpjk4DIsg.4l.oLxBfIdy59jTXjWHRu.JwOHnIiwblUi.nc4ER1WDpH.mrZ4iXOCviJ4nkLCVCfEt3TPcJFv6VCnXn1a8Ol0_Su8BE&token_type=bearer&expires_in=3600
        //
        // Save the access Token into a different location
        return view('auth.callback');
    });

    Route::post('callback', function (\Illuminate\Http\Request $request) {
        $yahoo_token = new \App\YahooToken($request->except('api_token'));
        Auth::user()->yahooToken()->save($yahoo_token);

        redirect('home', 302);
    });

    Route::group(['prefix' => 'yahoo', 'namespace' => 'Api'], function () {
        Route::group(['prefix' => 'users', 'namespace' => 'Users'], function() {
            Route::get('games', 'GamesController@index');
        });
    });
});


Route::group(['prefix' => 'yahoo', 'middleware'=>'authState'], function () {
    Route::post('callback', function (\Illuminate\Http\Request $request) {
        $yahooToken = new \App\YahooToken($request->except('api_token'));
        Auth::user()->yahooToken()->save($yahooToken);

    });

    Route::get('callback', function (\Illuminate\Http\Request $request) {

        // Take the code

        // Call get_token
        $client = new GuzzleHttp\Client();
        $res = $client->request('POST', 'https://api.login.yahoo.com/oauth2/get_token',
            [
                'headers' => ['Authentication' => 'Basic '.base64_encode(env('CONSUMER_KEY').':'.env('CONSUMER_SECRET'))],
                'form_params' => [
                    'grant_type' => 'authorization_code',
                    'client_id' => env('CONSUMER_KEY'),
                    'client_secret' => env('CONSUMER_SECRET'),
                    'redirect_uri' => 'https://salarycaptaincrunch.com/api/yahoo/callback?api_token='.Auth::user()->api_token,
                    'code' => $request->input('code'),
                ]
            ]);

        $body = json_decode($res->getBody()->getContents(), true);
        $yahooToken = new \App\YahooToken($body);
        Auth::user()->yahooToken()->save($yahooToken);
        return redirect('home');
    })->name('yahoo.callback');

    Route::post('callback/refresh', function (\Illuminate\Http\Request $request) {

        // Take the code

        // Call get_token
        $client = new GuzzleHttp\Client();
        $res = $client->request('POST', 'https://api.login.yahoo.com/oauth2/get_token',
            [
                'headers' => ['Authentication' => 'Basic '.base64_encode(env('CONSUMER_KEY').':'.env('CONSUMER_SECRET'))],
                'form_params' => [
                    'grant_type' => 'authorization_code',
                    'client_id' => env('CONSUMER_KEY'),
                    'client_secret' => env('CONSUMER_SECRET'),
                    'redirect_uri' => 'https://salarycaptaincrunch.com/api/yahoo/callback?api_token='.Auth::user()->api_token,
                    'code' => $request->input('code'),
                ]
            ]);

        $body = json_decode($res->getBody()->getContents(), true);
        $yahooToken = new \App\YahooToken($body);
        Auth::user()->yahooToken()->save($yahooToken);

    })->name('yahoo.callback.refresh');



});