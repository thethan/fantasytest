<?php

namespace App\Yahoo\Fantasy\Users\Games;

use App\Yahoo\YahooService;

class Get extends YahooService
{
    protected $uri = 'http://fantasysports.yahooapis.com/fantasy/v2/users;use_login=1/games';

    public function call()
    {
        dump($this->uri);
        parent::call();

        dump($this->response);
    }
}