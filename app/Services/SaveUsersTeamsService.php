<?php

namespace App\Services;

use App\Contracts\Yahoo\SetUriParams;
use App\Game;
use App\League;
use App\Team;
use App\User;
use App\Yahoo\Responses\User\LeagueResponse;
use Illuminate\Database\QueryException;
use League\Flysystem\Exception;
use App\Contracts\Yahoo\SetUser;
use Illuminate\Support\Collection;
use App\Contracts\Services\GetUserTeamsInterface;
use App\Exceptions\ApplicationServiceException;
use App\Yahoo\Responses\User\TeamResponseForSaving;

/**
 * Class SaveUsersTeamsService
 * @package App\Services
 */
class SaveUsersTeamsService implements GetUserTeamsInterface
{
    protected $leagueService;

    protected $yahooService;

    protected $leagueIdsToSave = [];

    public function __construct(SetUser $service, SetUriParams $leagueService)
    {
        $this->yahooService = $service;
        $this->leagueService = $leagueService;
    }

    public function invoke(User $user)
    {
        try {
            $this->yahooService->setUser($user);
            $response = new TeamResponseForSaving($this->yahooService->call());
            $this->saveResponse($user, $response->simpleResponse());

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
        foreach ($gamesCollection->all() as $gameArray) {
            $model = new Game();
            try {
                $model = $model->validateAndSave($gameArray);
                $this->saveTeam($user, $gameArray['teams'], $model);
            } catch (QueryException $e){
                continue;
            }
        }
        return true;
    }

    protected function saveleague(User $user, Game $game, array $data)
    {
        $response = $this->getLeague($user, $data['team_key']);
        $response = $response->simpleResponse()->get(0);

        $leagueArray = ['name' => $response['name'], 'league_id' =>  $response['league_id'], 'game_id' => $game->id];
        $league = new League();
        return $league->validateAndSave($leagueArray);


    }

    protected function getLeague(User $user, $team_key)
    {
        $league_key = explode('.t.', $team_key);

        $this->leagueService->setUriParams('league_key', $league_key[0]);
        $this->leagueService->setUser($user);

        $response = new LeagueResponse($this->leagueService->call());

        return $response; // Should also be the only
    }


    protected function saveTeam(User $user, Collection $teamsCollection, Game $game)
    {
        foreach ($teamsCollection->all() as $teamArray) {
            $model = new Team();

            $teamArray['user_id'] = $user->id;
            $league = $this->saveleague($user, $game, $teamArray);

            $teamArray['league_id'] = $league->id;
            $model->validateAndSave($teamArray);

        }
        return true;
    }


}
