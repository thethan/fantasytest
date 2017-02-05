<?php

namespace App\Yahoo\Responses\User;

use App\Contracts\Yahoo\ResponseInterface;
use Illuminate\Support\Collection;
use Psr\Http\Message\ResponseInterface as GuzzleResponse;


class TeamResponseForSaving implements ResponseInterface
{

    /**
     * @var GuzzleResponse
     */
    protected $response;

    /**
     * @var Collection
     */
    protected $simpleResponse;
    /**
     * TeamResponse constructor.
     * @param GuzzleResponse $response
     */
    public function __construct(GuzzleResponse $response)
    {
        $this->response = $response;
    }

    /**
     * @return Collection
     */
    public function simpleResponse()
    {
        return $this->buildSimpleResponse();
    }

    /**
     * @return Collection
     */
    protected function buildSimpleResponse()
    {
        $this->simpleResponse = new Collection();

        $response = json_decode($this->response->getBody()->getContents(), true);

        $games = $response['fantasy_content']['users'][0]['user'][1]['games'];
        unset($games['count']);

        $gamesCollection = new Collection();
        $leagueCollection = new Collection();

        foreach ($games as $game){
            // Game is index 0
            // Teams is index 1
            $array = $this->getGameInformation($game['game'][0]);
            $array['teams'] = $this->getTeamsInformation($game['game'][1]);
            $gamesCollection->push($array);
        }

        return $gamesCollection;
    }

    protected function getGameInformation(array $array)
    {
        return [
            'game_id' => $array['game_id'],
            'name' => $array['name'],
            'season' => $array['season'],
            'code' => $array['code'],
        ];
    }

    /**
     * @param array $array
     * @return Collection
     */
    protected function getTeamsInformation(array $array) : Collection
    {
        $teamsCollection = new Collection();
//        unset($array['teams'][0]['team']['count']);
        array_pop($array['teams']); // Get rid if the count

        foreach ($array['teams'] as $key => $team) {

            // Seems like auto teams does not exist
            if(array_key_exists(1, $team['team'])) {
                $teamsCollection->push(
                    ['team_key' => $team['team'][0][0]['team_key'],
                        'logo' => $team['team'][0][5]['team_logos'][0]['team_logo']['url'],
                        'name' => $team['team'][0][2]['name'],
                        'league_id' => $this->getLeagueId($team['team'][0][0]['team_key'])

                    ]
                );
            }

        }
        return $teamsCollection;
    }

    /**
     * @param string $teamKey
     */
    protected function getLeagueId(string $teamKey)
    {
        $inforation = explode('.', $teamKey);
        // 0 is the game
        // 1 is 1 because ... yahoo
        // 2 is the league id
        return $inforation[2];
    }
}
