<?php
/**
 * User: thethan
 * Date: 2/11/17
 * Time: 1:13 PM
 */

namespace App\Contracts\Yahoo\Services\Leagues;


use App\Contracts\Yahoo\ServiceInterface;
use App\Contracts\Yahoo\SetUriParams;
use App\Contracts\Yahoo\SetUser;


interface GetLeaguesContract extends ServiceInterface, SetUriParams, SetUser
{
}