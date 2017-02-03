<?php


namespace App\Contracts\Services;

use App\User;

interface GetUserTeamsInterface
{
    public function invoke(User $user);
}
