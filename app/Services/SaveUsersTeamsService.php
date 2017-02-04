<?php

namespace App\Services;

use App\User;
use App\Contracts\Yahoo\SetUser;
use App\DataTransferObjects\Users\Games\UsersTeamsDto;
use App\Team;
use Illuminate\Support\Facades\Validator;
use App\Contracts\Services\GetUserTeamsInterface;

/**
 * Class SaveUsersTeamsService
 * @package App\Services
 */
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
          $dto = new UsersTeamsDto($this->yahooService->call());

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

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

    }
}
