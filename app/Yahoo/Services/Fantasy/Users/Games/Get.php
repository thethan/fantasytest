<?php

namespace App\Yahoo\Services\Fantasy\Users\Games;

use App\Contracts\Yahoo\Services\Users\GetUserGamesContract;
use App\DataTransferObjects\Users\Games\UsersGamesDto;
use App\Yahoo\YahooService;

class Get extends YahooService implements GetUserGamesContract
{
    protected $uri = 'https://fantasysports.yahooapis.com/fantasy/v2/users;use_login=1/games';

    public function __construct(UsersGamesDto $dto)
    {
        parent::__construct();
        $this->responseClass = $dto;
    }
}