<?php

namespace App\Contracts\Yahoo;

use App\Exceptions\YahooServiceException;
use Psr\Http\Message\ResponseInterface;

interface ServiceInterface
{
    /**
     * @throws YahooServiceException
     * @return ResponseInterface
     */
   public function call();
}
