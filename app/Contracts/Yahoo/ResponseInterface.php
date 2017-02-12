<?php

namespace App\Contracts\Yahoo;

/**
 * Interface ResponseInterface
 * @package App\Contracts\Yahoo
 */
interface ResponseInterface
{
    /**
     * @return mixed
     */
    public function simpleResponse();

    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     * @return mixed
     */
    public function setResponse(\Psr\Http\Message\ResponseInterface $response);
}
