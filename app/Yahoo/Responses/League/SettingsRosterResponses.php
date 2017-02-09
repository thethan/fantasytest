<?php

namespace App\Yahoo\Responses;


use Illuminate\Support\Collection;
use App\Contracts\Yahoo\ResponseInterface;
use Psr\Http\Message\ResponseInterface as GuzzleResponse;

class SettingsRosterResponses implements ResponseInterface
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
    public function simpleResponse() : Collection
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

        $roster_positions = $response['fantasy_content']['league'][0]['settings']['roster_positions'];
        $collection =  new Collection();
        foreach ($roster_positions as $key => $position){
            $collection->push(['position' => $position['position'], 'count' => $position['count']]);
        }

        return $collection;
    }
}