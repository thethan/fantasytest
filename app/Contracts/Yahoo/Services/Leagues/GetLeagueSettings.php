<?php

namespace App\Contracts\Yahoo\Services\Leagues;

use App\Contracts\Yahoo\ServiceInterface;
use App\Contracts\Yahoo\SetUriParams;
use App\Contracts\Yahoo\SetUser;

interface GetLeagueSettings extends ServiceInterface, SetUriParams, SetUser
{

}
