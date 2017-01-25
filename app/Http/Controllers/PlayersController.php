<?php

namespace App\Http\Controllers;

use App\Yahoo\Fantasy\Players\Get;
use Illuminate\Http\Request;

class PlayersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $service = new Get();
        return $service->call();
    }

}
