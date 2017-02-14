<?php

namespace App\DataTransferObjects\Users\Games;

use App\Contracts\DataTransferObjects\Dto;
use App\Contracts\Yahoo\ResponseInterface;
use Psr\Http\Message\ResponseInterface as GuzzleResponse;
use Illuminate\Support\Collection;

class UsersTeamsDto implements Dto
{
    protected $teams;

    /**
     * UsersGamesDto constructor.
     * @param ResponseInterface $response
     */



    public function setFrom(GuzzleResponse $response)
    {
        $mainBody = $this->responseToArray($response);
        $this->setTeams($this->drillDownResponse($mainBody));
    }

    /**
     * @param array $response
     * @return mixed
     */
    protected function drillDownResponse(array $response)
    {
        // Need to fix this... but this is what works.
        return $response['fantasy_content']['users'][0]['user'][1];
    }

    /**
     * @param ResponseInterface $response
     * @return array
     */
    protected function responseToArray(ResponseInterface $response)
    {
        return json_decode($response->simpleResponse());
    }

    /**
     * @return mixed
     */
    public function toArray()
    {
       return $this->teams;
    }

    /**
     * @param array $teams
     */
    protected function setTeams(array $teams)
    {
        $array = [];
        unset($teams['teams']['count']);
        // The last key value is 'count' because WHAT?! you cannot use array count in most languages!?
        foreach ($teams['teams'] as $key => $game) {
            $array[] = $game['game'][0];
        }
        $this->teams = new Collection($array);
    }

}
