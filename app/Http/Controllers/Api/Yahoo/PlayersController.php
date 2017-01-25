<?php

namespace App\Http\Controllers\Api\Yahoo;

use App\Http\Controllers\Controller;
use App\Yahoo\Fantasy\Players\Get;
use Illuminate\Http\Request;

class PlayersController extends Controller
{
    public function index()
    {
        $service = new Get();
        return $service->call();
    }

}
