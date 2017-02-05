<?php

namespace App\Yahoo\Services\Fantasy\Leagues;

use App\Contracts\Yahoo\SetUriParams;
use App\Yahoo\YahooService;

class Get extends YahooService implements SetUriParams
{
    public $uriParams = ['league_key' => null];
    protected $uri = 'https://fantasysports.yahooapis.com/fantasy/v2/league/{league_key}';


    public function setUriParams(string $key, string $value)
    {
        $this->uriParams[$key] = $value;
    }
}