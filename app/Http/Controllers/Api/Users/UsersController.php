<?php

namespace App\Http\Controllers\Api\Users;

use App\DataTransferObjects\Users\Teams\TeamInfoFromResponseDto;
use App\Events\UserLoggedIntoFantasy;
use App\Game;
use App\Http\Controllers\Controller;
use App\Yahoo\Responses\Leagues\SettingsResponse;
use App\Yahoo\Services\Fantasy\Leagues\GetSettings;
use Illuminate\Support\Facades\Auth;

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

        return response()->json(['data' => ['user' => Auth::user(), 'games' => Auth::user()->games() ]]);
    }

}
