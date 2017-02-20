<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Events\UserLoggedIntoFantasy;

/**
 * Class TeamsController
 * @package App\Http\Controllers\Api\Users
 */
class TeamsController extends Controller
{
    /**
     * @return mixed
     */
    public function index()
    {
        event(new UserLoggedIntoFantasy(Auth::user()));
        return response()->json([
            'data' => []
        ]);
    }

    public function roster()
    {

    }
}
