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

Route::get('callback', function (\Illuminate\Http\Request $request){
    // https://salarycaptaincrunch.com/callback#access_token=iZwqFGCY4Br381U1Zn5grIc0Wo9NRWJlxoUY9_XIZM5oaDU9O6qqYElBcJHp8_U6wkuOoDmqP_7YfQLfVTVnIXK.e_vGH3culuD.heRo4xIIhsSSbk5v1TM6BClQ1lIFcw7vCm50ISyziKzjVJ2.jXqNMMgd_8cZGQ6_2UIxL1r0reTET_m5y5IuP83uPbXEUOIT4QVzNO.M7_gkzO4FcKKjS6u0AJPV73gO92R0wNLaa8odmFa8AoWVQ9CogseiD4ELU89mpo.D2dU9QYDNQI3ClJyHePN4eKUJ.ztw.NGXW3mh8NZkYnPqY5YboAB0zLUUYC9xVD6GLDQwfE1InO7zVN.9k5_4sFpd6eOZ_9ba_tcTiKbLU.QxwxpqqgzzIiIcR9dr9zprvpR3L_in2Sgk4Iw4HvMyBMRXkCzhbFo6vUedCqLGRrx1QjsxTekQtuJndxfPi96EYKIb3hLR060sztfPGJJtH7R902rmCboiPBuUEjfcAu4PRtm3kwPytEgcqaertLCXJgDeXsGCzniok3kFpoCWNTtawnoIBj1kSVArY5AMlxubms3MidESpf.VIEuvBzk_C26xL8A0aB87BHyZEfrE2tLpjdolrzR0aK0_iOFUV.Nj_lnYfLQqFr3GTG1UUpOxGQn5U4i7CFEVGc7okO6z67jju6pL5D6HB2gKB8MLeENN6ANwU8VkOchhcyxHd9AOo2TZOvXMpyfEh9uyjL9WpbaR0L7AV5GJ_bxg5F0zz466qZQNxXQX8ZKyS2noYcCvCOxiBIgj8n7I._bnsjPyElj8Gyko4Rspg6ezwP3QXncJfYa3zopr7lHBg2ExkiXD_r_cNFTu5LetJA_EkdUqMfZ2jJdpjk4DIsg.4l.oLxBfIdy59jTXjWHRu.JwOHnIiwblUi.nc4ER1WDpH.mrZ4iXOCviJ4nkLCVCfEt3TPcJFv6VCnXn1a8Ol0_Su8BE&token_type=bearer&expires_in=3600
    //
    // Save the access Token into a different location
    dump($request->all());
});
