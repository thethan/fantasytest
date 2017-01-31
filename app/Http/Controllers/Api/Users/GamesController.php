<?php

namespace App\Http\Controllers\Api\Users;

use App\Service\SaveUsersGameService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class GamesController extends Controller
{
    protected $service;


    public function __construct(SaveUsersGameService $usersGameService)
    {
        $this->service = $usersGameService;
    }

    public function index()
    {
        $this->service->getUsersGames(Auth::user());
    }
}
