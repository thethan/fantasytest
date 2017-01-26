<?php


namespace App\Yahoo\Fantasy\Players;

use App\Yahoo\YahooService;

class Get extends YahooService
{
    protected $uri = 'https://fantasysports.yahooapis.com/fantasy/v2/league/{league_key}/players';
}