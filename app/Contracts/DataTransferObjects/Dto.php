<?php

namespace App\Contracts\DataTransferObjects;


use Illuminate\Contracts\Support\Arrayable;
use Psr\Http\Message\ResponseInterface;

interface Dto extends Arrayable 
{
    public function setFromResponse(ResponseInterface $response);
}