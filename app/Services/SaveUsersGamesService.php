<?php

namespace App\Service;

use App\Contracts\Services\SetUser;
use App\User;
use App\Yahoo\YahooService;

class SaveUsersGameService
{
    public function __construct(SetUser $service)
    {
        $this->call = $service;
    }

    public function getUsersGames(User $user)
    {
        $this->call->setUser($user);
        $return = $this->call->call()->getBody()->getContents();
        dump($return);
    }
}