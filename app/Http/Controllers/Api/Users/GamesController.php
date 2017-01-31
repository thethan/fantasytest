<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Contracts\Services\GetUsersGamesInterface;

class GamesController extends Controller
{
    protected $service;


    public function __construct(GetUsersGamesInterface $usersGameService)
    {
        $this->service = $usersGameService;
    }

    /**
     *
     */
    public function index()
    {
        return $this->service->getUsersGames(Auth::user());
    }
}
