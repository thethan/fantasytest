<?php


namespace App\Contracts\Services;

use App\User;

interface GetUsersGamesInterface
{
    public function getUsersGames(User $user);
}
