<?php

namespace App\Contracts\DataTransferObjects;


use Psr\Http\Message\ResponseInterface;

interface Dto
{
    public function setFromResponse(ResponseInterface $response);
}