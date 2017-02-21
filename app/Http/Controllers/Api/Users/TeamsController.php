<?php


namespace App\Http\Controllers\Api\Users;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Events\UserLoggedIntoFantasy;


class TeamsController extends Controller
{
    /**
     * @return mixed
     */
    public function index()
    {

        event(new UserLoggedIntoFantasy(Auth::user()));
        dump('hello');
        return response()->json([
            'data' => []
        ]);
    }

    public function roster()
    {

    }
}
