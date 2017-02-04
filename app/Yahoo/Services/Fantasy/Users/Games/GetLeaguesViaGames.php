<?php

namespace App\Yahoo\Fantasy\Users\Games;


use App\Contracts\Yahoo\SetUser as SetUserInterface;
use App\Yahoo\YahooService;

class GetLeaguesViaGames extends YahooService implements SetUserInterface
{
    public $uriParams = ['game_id' => null];

    protected $uri = 'https://fantasysports.yahooapis.com/fantasy/v2/users;use_login=1/games;game_keys={game_id}/leagues';
}