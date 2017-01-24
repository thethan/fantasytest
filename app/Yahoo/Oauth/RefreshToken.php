<?php

namespace App\Yahoo\Oauth;

use App\Yahoo\YahooService;
use Illuminate\Support\Facades\Auth;

class RefreshToken extends YahooService
{
    protected $authorization_type = 'Basic';

    protected $uri = '/oauth2/get_token';

    protected $method = 'POST';

    /**
     *
     */
    protected function makeHeaders()
    {
        parent::makeHeaders();
        $this->headers['headers']['Content-Type'] = 'application/x-www-form-urlencoded';
    }

    protected function makeBody()
    {
        $this->body = ['form_params' =>
            [
                'grant_type' => 'refresh_token',
                'redirect_url' => route('yahoo.callback').'?state='.Auth::user()->api_token,
                'refresh_token' => Auth::user()->yahooToken->refresh_token
            ]
        ];
    }

}