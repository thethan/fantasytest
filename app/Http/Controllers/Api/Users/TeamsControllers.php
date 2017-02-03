<?php

namespace App\Http\Controllers\Api\Users;


namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Contracts\Services\GetUserTeamsInterface;


class TeamsController extends Controller
{
    protected $service;


    public function __construct(GetUserTeamsInterface $getUsersTeamsService)
    {
        $this->service = $getUsersTeamsService;
    }

    /**
     *
     */
    public function index()
    {
        return $this->service->invoke(Auth::user());
    }
}
