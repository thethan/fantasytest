<?php

namespace App\Http\Controllers;

use App\Yahoo\Fantasy\Players\Get as GetPlayers;
use Illuminate\Http\Request;

class PlayersController extends Controller
{

    public function index()
    {
        $service = new GetPlayers();
        return $service->call();
    }

}
