<?php

namespace App\Yahoo\Fantasy\Users\Games;

use App\Yahoo\YahooService;

class Get extends YahooService
{
    protected $uri = 'https://fantasysports.yahooapis.com/fantasy/v2/users;use_login=1/games';
}