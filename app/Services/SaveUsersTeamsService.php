<?php

namespace App\Services;

use App\Exceptions\ApplicationServiceException;
use App\User;
use App\Contracts\Yahoo\SetUser;
use App\Yahoo\Responses\User\TeamResponse;
use App\Contracts\Services\GetUserTeamsInterface;
use App\DataTransferObjects\Users\Games\UsersTeamsDto;
use App\Yahoo\Responses\User\TeamResponseForSaving;
use Hamcrest\Core\Set;
use Illuminate\Support\Collection;
use League\Flysystem\Exception;

/**
 * Class SaveUsersTeamsService
 * @package App\Services
 */
class SaveUsersTeamsService implements GetUserTeamsInterface
{
    protected $leagueService;

    protected $yahooService;

    protected $leagueIdsToSave = [];

    public function __construct(SetUser $service, SetUser $leagueService)
    {
        $this->yahooService = $service;
        $this->leagueService = $leagueService;
    }

    public function invoke(User $user)
    {
        try {
            $this->yahooService->setUser($user);
            $response = new TeamResponseForSaving($this->yahooService->call());
            $this->saveResponse($response->simpleResponse());


        } catch (Exception $e) {
            throw new ApplicationServiceException($e->getMessage());
        }

    }

    /**
     * @param User $user
     * @param Collection $gamesCollection
     */
    protected function saveResponse(User $user, Collection $gamesCollection)
    {
    }

    protected function saveGame()
    {

    }

    protected function getLeague(User $user)
    {

    }

    protected function saveTeam(User $user, array $team)
    {

    }



}
