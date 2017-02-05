<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Contracts\Services\GetUserTeamsInterface;

/**
 * Class TeamsController
 * @package App\Http\Controllers\Api\Users
 */
class TeamsController extends Controller
{
    protected $service;

    /**
     * TeamsController constructor.
     * @param GetUserTeamsInterface $getUsersTeamsService
     */
    public function __construct(GetUserTeamsInterface $getUsersTeamsService)
    {
        $this->service = $getUsersTeamsService;
    }

    /**
     * @return mixed
     */
    public function index()
    {
        $user = (env('APP_ENV') === 'local') ? User::find(1) : Auth::user();

        return $this->service->invoke($user);
    }
}
