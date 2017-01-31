<?php

namespace App\DataTransferObjects\Users\Games;

use App\Contracts\DataTransferObjects\Dto;
use Psr\Http\Message\ResponseInterface;

class UsersGamesDto implements Dto
{
    protected $games;


    public function setFromResponse(ResponseInterface $response)
    {
        $mainBody = json_decode(json_encode($response->getBody()->getContents()));

        dump($mainBody);
    }


}