<?php

namespace App\Yahoo\Oauth;

use App\Yahoo\YahooService;
use Illuminate\Support\Facades\Auth;

class RefreshToken extends YahooService
{
    protected $authorization_type = 'Basic';

    protected $uri = 'https://api.login.yahoo.com/oauth2/get_token';

    protected $method = 'POST';

    /**
     *
     */
    protected function makeHeaders()
    {
        $this->headers = ['headers' =>
            ['Authentication' => 'Basic '.base64_encode(env('CONSUMER_KEY').':'.env('CONSUMER_SECRET'))]
        ];

    }

    protected function makeBody()
    {
        $this->body = ['form_params' =>
            [
                'client_id' => env('CONSUMER_KEY'),
                'client_secret' =>env('CONSUMER_SECRET'),
                'grant_type' => 'refresh_token',
                'redirect_url' => route('yahoo.callback').'?state='.Auth::user()->api_token,
                'refresh_token' => Auth::user()->yahooToken->refresh_token
            ]
        ];
    }

    public function call()
    {
        parent::call();
        $token = Auth::user()->yahooToken;
        $token->delete();
        Auth::user()->yahooToken()->save(json_decode($this->response));
    }

}