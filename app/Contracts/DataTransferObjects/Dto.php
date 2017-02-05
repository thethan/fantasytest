<?php

namespace App\Contracts\DataTransferObjects;


use App\Contracts\Yahoo\ResponseInterface;
use Illuminate\Contracts\Support\Arrayable;


interface Dto extends Arrayable 
{
    public function setFromResponse(ResponseInterface $response);
}