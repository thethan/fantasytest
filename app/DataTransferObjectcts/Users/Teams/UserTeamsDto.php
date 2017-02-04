<?php

namespace App\DataTransferObjects\Users\Games;

use App\Contracts\DataTransferObjects\Dto;
use Illuminate\Support\Collection;
use Psr\Http\Message\ResponseInterface;

class UsersTeamsDto implements Dto
{
    protected $teams;

    /**
     * UsersGamesDto constructor.
     * @param ResponseInterface $response
     */
    public function __construct(ResponseInterface $response)
    {
        dump($response->getBody()->getContents());
        $this->setFromResponse($response);
    }

    /**
     * @param ResponseInterface $response
     */
    public function setFromResponse(ResponseInterface $response)
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
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * @return mixed
     */
    public function toArray()
    {
       return $this->teams;
    }

    /**
     * @param array $games
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
