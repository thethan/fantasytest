<?php

namespace App\Contracts\DataTransferObjects;


use Psr\Http\Message\ResponseInterface;
use Illuminate\Contracts\Support\Arrayable;
use App\Contracts\Yahoo\ResponseInterface as YahooResponseInterface;


interface Dto extends Arrayable, YahooResponseInterface
{
}