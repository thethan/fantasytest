<?php

namespace App\Services;

use App\User;
use App\Contracts\Yahoo\SetUser;
use App\Contracts\Services\GetUsersGamesInterface;

class SaveUsersGameService implements GetUsersGamesInterface
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