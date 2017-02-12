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
     * @param GuzzleResponse $response
     * @return $this
     */
    public function setResponse(\Psr\Http\Message\ResponseInterface $response)
    {
        $this->response = $response;
        return $this;
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
        dump($response);exit;
        return new Collection([$response['fantasy_content']['league'][1]['league'][0]]);
    }

}
