<?php

namespace App\DataTransferObjects\Users\Games;

use App\Contracts\DataTransferObjects\Dto;
use Psr\Http\Message\ResponseInterface;

class UsersGamesDto implements Dto
{
    protected $games;

    public function __construct(ResponseInterface $response)
    {
        $this->setFromResponse($response);
    }

    public function setFromResponse(ResponseInterface $response)
    {
        $mainBody = json_decode($response->getBody()->getContents(), true);

        dump($mainBody);
    }

    public function toArray()
    {
        // TODO: Implement toArray() method.
    }


}