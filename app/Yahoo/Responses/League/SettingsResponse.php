<?php

namespace App\Yahoo\Responses\Leagues;

use App\Contracts\Yahoo\ResponseInterface;
use Illuminate\Support\Collection;
use Psr\Http\Message\ResponseInterface as GuzzleResponse;

class SettingsResponse implements ResponseInterface
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

        return new Collection([$response['fantasy_content']['league'][1]['league'][0]]);
    }

}
