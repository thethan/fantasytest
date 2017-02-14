<?php

namespace App\Http\Controllers\Api\Users;

use App\Contracts\Yahoo\Services\Users\GetUserGamesContract;
use App\Jobs\GetUserGamesJob;
use Illuminate\Contracts\Queue\Job;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Contracts\Services\GetUsersGamesInterface;

class GamesController extends Controller
{
    protected $job;

    /**
     * GamesController constructor.
     * @param GetUserGamesJob $job
     */
    public function __construct()
    {

    }

    /**
     *
     */
    public function index()
    {
        $user = Auth::user();
        $this->dispatch(new GetUserGamesJob($user));
    }
}
