<?php

namespace App\Yahoo\Services\Fantasy\Leagues;

use App\Contracts\Yahoo\ResponseInterface;
use App\Contracts\Yahoo\Services\Leagues\GetLeaguesContract;
use App\Yahoo\YahooService;

class GetSettings extends YahooService implements GetLeaguesContract
{
    public $uriParams = [
        'league_key' => null,
        'game_key' => null
    ];

    protected $uri = 'https://fantasysports.yahooapis.com/fantasy/v2/league/{game_key}.1.{league_key}/settings';

    public function __construct(ResponseInterface $response)
    {
        parent::__construct();

        $this->responseClass = $response;
    }


    public function setUriParams(string $key, string $value)
    {
        $this->uriParams[$key] = $value;
    }
}