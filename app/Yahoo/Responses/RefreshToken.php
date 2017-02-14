<?php

namespace App\Yahoo\Responses;

use App\Contracts\Yahoo\ResponseInterface;
use Illuminate\Support\Collection;
use Psr\Http\Message\ResponseInterface as GuzzleResponse;


class RefreshToken implements ResponseInterface
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
     */
    public function __construct()
    {

    }

    public function setResponse(\Psr\Http\Message\ResponseInterface $response)
    {
        $this->response = $response;
    }

    /**
     * @return Collection
     */
    public function simpleResponse()
    {
        return $this->response;
    }




}
