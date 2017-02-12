<?php

namespace App\Yahoo\Services\Fantasy\Users\Games;


use App\Yahoo\YahooService;
use App\Contracts\Yahoo\ResponseInterface;
use App\Contracts\Yahoo\Services\Users\GetUserTeamsContract;


class GetTeams extends YahooService implements GetUserTeamsContract
{
    protected $uri = 'https://fantasysports.yahooapis.com/fantasy/v2/users;use_login=1/games/teams';

    public function __construct(ResponseInterface $response)
    {
        parent::__construct();
        $this->responseClass = $response;
    }

}
