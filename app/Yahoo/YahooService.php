<?php

namespace App\Yahoo;

use App\Exceptions\YahooResponseException;
use App\Exceptions\YahooServiceException;
use App\User;
use GuzzleHttp\Client;
use App\Yahoo\Oauth\RefreshToken;
use App\Contracts\Yahoo\SetUser;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use App\Contracts\Yahoo\ServiceInterface;
use App\Contracts\Yahoo\ResponseInterface as YahooResponseInterface;


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

    protected $tries = 0;

    protected $totalTries = 3;

    /**
     * @var \App\Contracts\Yahoo\ResponseInterface
     */
    protected $responseClass;

    /**
     * @var ResponseInterface
     */
    protected $response;

    public function __construct()
    {
        $this->client = new Client();
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
        $this->tries = $this->tries++;
        $this->response = $this->client->request($this->method, $this->returnUrlWithParams(), $this->options);
        return $this->handleResponse();
    }


    protected function handleResponse()
    {
        if ($this->response->getStatusCode() === 401){
            if($this->reauthorize()) {
                $this->call();
            }
        } else if($this->response->getStatusCode() >= 400 && $this->tries < $this->totalTries){
            // Tries start at 0 so less then will show if they are less than or not.
            $this->call();
        }else if ($this->tries >= $this->totalTries) {
            throw new YahooServiceException('Too many tries hitting the Yahoo Service'. $this->uri);
        } else {

            return $this->responseToResponseClass($this->response);
        }
    }

    /**
     * @param ResponseInterface $response
     * @return YahooResponseInterface
     * @throws YahooResponseException
     */
    protected function responseToResponseClass(ResponseInterface $response)
    {
        try {
            return $this->responseClass->setResponse($response);
        } catch (\Exception $exception){
            throw new YahooResponseException($exception->getMessage());
        }
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

    protected function returnUrlWithParams()
    {
        $url = $this->uri;
        foreach($this->uriParams as $key => $param){
            $url = str_replace("{".$key."}", $param, $url);
        }
        return $url;
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

    /**
     *
     */
    protected function appendJson()
    {
        if(strpos($this->uri, 'format=json') === false) {
            $this->uri = (strpos($this->uri, '?') !== false) ? $this->uri . '&format=json' : $this->uri . '?format=json';
        }
    }

    protected function reauthorize()
    {
        $refreshToken = new RefreshToken();

        return $refreshToken->call();
    }


}
