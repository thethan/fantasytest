<?php

namespace App\Http\Controllers;

use App\Yahoo\Fantasy\Players\Get as GetPlayers;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function players()
    {

        $service = new GetPlayers();
        $service->uriParams['league_key'] = '359.l.242042';
        return $service->call();

    }

}
