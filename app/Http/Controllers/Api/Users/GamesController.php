<?php

namespace App\Http\Controllers\Api\Users;

use App\Events\UserGamesData;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class GamesController extends Controller
{
    /**
     *
     */
    public function index()
    {
        $user = Auth::user();
        event(new UserGamesData($user));
    }
}
