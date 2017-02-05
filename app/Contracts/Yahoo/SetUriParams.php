<?php

namespace App\Contracts\Yahoo;


interface SetUriParams
{
    /**
     * @param string $key
     * @param string $value
     * @return mixed
     */
    public function setUriParams(string $key, string $value);
}