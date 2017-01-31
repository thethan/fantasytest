<?php

namespace App\Services;

use App\User;
use App\Contracts\Yahoo\SetUser;
use App\Contracts\Services\GetUsersGamesInterface;
use League\Flysystem\Exception;

class SaveUsersGameService implements GetUsersGamesInterface
{
    public function __construct(SetUser $service)
    {
        $this->call = $service;
    }

    public function getUsersGames(User $user)
    {
        try {
            $this->call->setUser($user);
            $response = $this->call->call();
            dump($response);
        } catch (\Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }
}