<?php

namespace App\Services;

use App\DataTransferObjects\Users\Games\UsersGamesDto;
use App\User;
use App\Contracts\Yahoo\SetUser;
use App\Contracts\Services\GetUsersGamesInterface;
use League\Flysystem\Exception;

class SaveUsersGameService implements GetUsersGamesInterface
{
    protected $yahooService;

    public function __construct(SetUser $service)
    {
        $this->yahooService = $service;
    }

    public function getUsersGames(User $user)
    {
        try {
            $this->yahooService->setUser($user);
            $dto = new UsersGamesDto($this->yahooService->call());
            dump($dto->all());

        } catch (\Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }
}