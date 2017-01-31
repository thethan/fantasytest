<?php


namespace App\Contracts\Services;


use App\User;

interface SetUser extends ServiceInterface
{
    public function setUser(User $user);
}
