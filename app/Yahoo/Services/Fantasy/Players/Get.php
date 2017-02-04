<?php


namespace App\Yahoo\Fantasy\Players;

use App\Yahoo\YahooService;

class Get extends YahooService
{
    public $uriParams = ['league_key' => null];
    protected $uri = 'https://fantasysports.yahooapis.com/fantasy/v2/league/{league_key}/players';
}