<?php

namespace App\DataTransferObjects\Users\Games;

use App\Contracts\DataTransferObjects\Dto;
use Illuminate\Support\Collection;
use Psr\Http\Message\ResponseInterface;

class UsersGamesDto implements \App\Contracts\Yahoo\ResponseInterface
{
    /**
     * @var Collection
     */
    protected $games;

    /**
     * UsersGamesDto constructor.
     * @param ResponseInterface $response
     */
    public function __construct(ResponseInterface $response = null)
    {
        if ($response){
            $this->setResponse($response);
        }
    }

    /**
     * @param ResponseInterface $response
     * @return $this
     */
    public function setResponse(ResponseInterface $response)
    {
        $mainBody = $this->responseToArray($response);
        $this->setGames($this->drillDownResponse($mainBody));
        return $this;
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
     * @param array $games
     */
    protected function setGames(array $games)
    {
        $array = [];
        unset($games['games']['count']);
        // The last key value is 'count' because WHAT?! you cannot use array count in most languages!?
        foreach ($games['games'] as $key => $game) {
            $array[] = $game['game'][0];
        }
        $this->games = new Collection($array);
    }

    public function simpleResponse()
    {
        return $this->games;
    }


}