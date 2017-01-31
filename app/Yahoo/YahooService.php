<?php

namespace App\Yahoo;

use App\User;
use GuzzleHttp\Client;
use App\Yahoo\Oauth\RefreshToken;
use App\Contracts\Services\SetUser;
use Psr\Http\Message\ResponseInterface;
use App\Contracts\Services\ServiceInterface;


abstract class YahooService implements ServiceInterface, SetUser
{

    public $uriParams = [];

    protected $user;

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

    public function __construct(User $user = null)
    {
        $this->client = new Client();
        $this->user = $user;
    }

    protected function getAuthToken()
    {
        return $this->user->yahooToken->access_token;
    }

    /**
     * @return mixed
     */
    protected function getAuthTokenType()
    {
        return $this->user->yahooToken->token_type;
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
            if($this->reauthorize()) {
                $this->call();
            }
        } else {
            return $this->response;
        }
        return $this;
    }

    public function setUser(User $user)
    {
        $this->user = $user;
    }

    protected function buildOptions()
    {
        $this->options = array_merge($this->headers, $this->body);
        $this->options['http_errors'] = false;
    }

    protected function appendUri()
    {
        foreach($this->uriParams as $key => $param){
            $this->uri = str_replace("{".$key."}", $param, $this->uri);
        }
    }

    protected function build()
    {
        $this->appendUri();
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

        return $refreshToken->call();
    }


}
