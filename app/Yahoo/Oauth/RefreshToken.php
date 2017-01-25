<?php

namespace App\Yahoo\Oauth;

use App\Exceptions\YahooServiceException;
use App\Yahoo\YahooService;
use App\YahooToken;
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
        try {
            $token = Auth::user()->yahooToken;

            parent::call();
            $array = json_decode($this->response->getBody()->getContents(), true);
            dump($array);
            $token->fill($array);
            $token->save();

        } catch (\Exception $e){
            throw new YahooServiceException('Failure to get Refresh Token');
        }
        return true;
    }

}