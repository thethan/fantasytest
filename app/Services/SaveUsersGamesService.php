<?php

namespace App\Services;

use App\DataTransferObjects\Users\Games\UsersGamesDto;
use App\Game;
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
            foreach ($dto->toArray()->all() as $game ) {
                $model = new Game($game);
                $model->save();
            }

        } catch (\Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }
}