<?php

namespace App\Yahoo\Services\Fantasy\Users\Games;


use App\Contracts\Yahoo\SetUser as SetUserInterface;
use App\Yahoo\YahooService;

class GetTeams extends YahooService implements SetUserInterface
{
    protected $uri = 'https://fantasysports.yahooapis.com/fantasy/v2/users;use_login=1/games/teams';
}
