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
        $array = [];
        $array['league_id'] = "242042";
        $array['name']  = "Davonte's Peak";
        $array['logo'] = "https://s.yimg.com/lq/i/identity2/profile_96c.png";
        $array['team_key'] = '359.l.242042.t.1';

        event(new UserLoggedIntoFantasy(Auth::user()));

        return response()->json([
            'data' => []
        ]);
    }

    public function roster()
    {
        $service = new GetSettings(new SettingsResponse());
        $service->setUser(Auth::user());

        $service->setUriParams('league_key', '721253');
        $service->setUriParams('game_key', '359');

        $dto = $service->call();
        dump(  $dto);

    }
}
