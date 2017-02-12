<?php


namespace App\Contracts\Services;

use App\User;
use App\Contracts\DataTransferObjects\Dto;

interface GetUserTeamsInterface
{
    /**
     * @param User $user
     * @return Dto
     * @throws \Exception
     */
    public function invoke(User $user);
}
