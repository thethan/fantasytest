<?php

namespace App\Yahoo;

use App\Yahoo\Oauth\RefreshToken;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Psr\Http\Message\ResponseInterface;


abstract class YahooService
{

    protected $client;

    protected $authorization_type = 'Bearer';

    protected $uri;

    protected $body;

    protected $options;

    protected $method = 'GET';

    protected $headers;

    /**
     * @var ResponseInterface
     */
    protected $response;

    public function __construct($uri = null)
    {
        $this->client = new Client(['base_uri' => 'https://api.login.yahoo.com']);
    }

    protected function getAuthToken()
    {
        return Auth::user()->yahooToken->auth_token;
    }

    /**
     * @return mixed
     */
    protected function getAuthTokenType()
    {
        return Auth::user()->yahooToken->token_type;
    }

    /**
     * @return array
     */
    protected function getAuthorizationHeader()
    {
        return ['Authorization' => ucfirst($this->getAuthTokenType()). ' '. $this->getAuthToken()];
    }

    /**
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function call()
    {
        $this->build();
        $this->response = $this->client->request($this->method, $this->uri, $this->options);

        return $this->handleResponse();
    }

    protected function handleResponse()
    {
        if ($this->response->getStatusCode() === 401){
            $this->reauthorize();
            $this->build();
            $this->call();
        } else {
            return $this->response;
        }
    }

    protected function buildOptions()
    {
        $this->options = array_merge($this->headers, $this->body);
    }

    protected function build()
    {
        $this->appendJson();
        $this->makeHeaders();
        $this->makeBody();
        $this->buildOptions();
    }

    protected function makeHeaders()
    {
        $this->headers = ['headers' => array_merge([], $this->getAuthorizationHeader())];
    }

    protected function makeBody()
    {
        $this->body = [];
    }


    protected function appendJson()
    {
        $this->uri =  (strpos($this->uri, '?') !== false) ? $this->uri .'&format=json' : $this->uri . '?format=json';
    }

    protected function reauthorize()
    {
        $refreshToken = new RefreshToken();
        $refreshToken->call();
    }


}
