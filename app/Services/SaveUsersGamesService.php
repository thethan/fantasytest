<?php

namespace App\Services;

use App\DataTransferObjects\Users\Games\UsersGamesDto;
use App\Game;
use App\User;
use App\Contracts\Yahoo\SetUser;
use App\Contracts\Services\GetUsersGamesInterface;
use Illuminate\Support\Facades\Validator;
use League\Flysystem\Exception;

class SaveUsersGameService implements GetUsersGamesInterface
{
    protected $yahooService;

    public function __construct(SetUser $service)
    {
        $this->yahooService = $service;
    }

    /**
    * @return UsersGamesDto
    * @throws Exception
    **/
    public function getUsersGames(User $user)
    {
        try {
            $this->yahooService->setUser($user);
            $dto = new UsersGamesDto($this->yahooService->call());

            foreach ($dto->toArray()->all() as $game ) {
                $validator = Validator::make(
                    array('game_id' =>  $game['game_id']),
                    array('game_id' => array('unique:games,game_id'))
                );

                if($validator->passes()) {
                    $model = new Game($game);
                    $model->save();
                }
            }
            return $dto;
        } catch (\Exception $exception) {
            return throw new Exception($exception->getMessage());
        }

    }
}
