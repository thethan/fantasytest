<?php

namespace App\Services;

use App\User;
use App\Contracts\Services\GetUserTeamsInterface;


class SaveUsersTeamsService implements GetUserTeamsInterface
{
    protected $league;

    protected $yahooService;

    public function __construct(SetUser $service)
    {
        $this->yahooService = $service;
    }

    public function invoke(User $user)
    {
        try {
          $this->yahooService->setUser($user);
          $dto = new UserTeamsDto($this->yahooService->call());

          foreach ($dto->toArray()->all() as $team ) {
              $validator = Validator::make(
                  array('team_id' =>  $team['team_id']),
                  array('team_id' => array('unique:teams,team_id'))
              );

              if($validator->passes()) {
                  $model = new Team($team);
                  $model['user_id'] = $user->id;
                  $model->save();
              }
            }
            return $dto;

        } catch (Exception $e) {
            return throw new \Exception($e->getMessage());
        }

    }
}
