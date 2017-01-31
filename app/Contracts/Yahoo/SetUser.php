<?php


namespace App\Contracts\Yahoo;


use App\User;

interface SetUser extends ServiceInterface
{
    public function setUser(User $user);
}
