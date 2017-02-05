<?php


namespace App\Contracts\Services;

use App\Contracts\DataTransferObjects\Dto;
use App\User;

interface GetUserTeamsInterface
{
    /**
     * @param User $user
     * @return Dto
     * @throws \Exception
     */
    public function invoke(User $user);
}
