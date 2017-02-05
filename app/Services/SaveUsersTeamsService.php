<?php

namespace App\Services;

use App\Contracts\Yahoo\SetUriParams;
use App\Game;
use App\League;
use App\Team;
use App\User;
use App\Yahoo\Responses\User\LeagueResponse;
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

            $model = $model->validateAndSave($gameArray);
            $this->saveTeam($user, $gameArray['teams'], $model);
        }
        return true;
    }

    protected function saveleague(User $user, Game $game, array $data)
    {
        $response = $this->getLeague($user, $data['team_key']);
        $league = new League();
        if ($league->validateAndSave(
            ['name' => $response['name'], 'league_id' => (int) $response['league_id'], 'game_id' => $game->id]
        )){
            return $game->leagues()->save(new League(['name' => $response['name'], 'league_id' => $response['league_id'], 'game_id' => $game->id]));

        }
        return League::where('league_id', $response['league_id'])->first();
    }

    protected function getLeague(User $user, $team_key)
    {
        $league_key = explode('.t.', $team_key);

        $this->leagueService->setUser($user);
        $this->leagueService->setUriParams('league_key', $league_key[0]);
        $response = new LeagueResponse($this->leagueService->call());
        return $response->simpleResponse()->first(); // Should also be the only
    }


    protected function saveTeam(User $user, Collection $teamsCollection, Game $game)
    {
        foreach ($teamsCollection->all() as $teamArray) {
            $model = new Team();
            $leagueArray['league_id'] = $teamArray['league_id'];
            unset($teamArray['league_id']);

            $teamArray['user_id'] = $user->id;
            $league = $this->saveleague($user, $game, $teamArray);

            $teamArray['league_id'] = $league->id;
            $model->validateAndSave($teamArray);
            dump($model);
        }
        return true;
    }


}
