<?php

namespace App\Listeners;

use App\Contracts\Yahoo\Services\Users\GetUserTeamsContract;
use App\Events\UserGamesImported;
use App\Events\UserLeaguesImported;
use App\Events\UserTeamsImported;
use App\League;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Validator;

class ImportLeaguesFromYahoo implements ShouldQueue
{

    protected $service;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param  UserGamesImported  $event
     * @return void
     */
    public function handle(UserGamesImported $event)
    {
        $validator = Validator::make(
            array('league_id' => $event->dto->toArray()['league_id']),
            array('league_id' => array('unique:leagues,league_id'))
        );

        if ($validator->passes()) {

            $model = new League([
                    'league_id' => $event->dto->toArray()['league_id'],
                    'game_id' => $event->dto->toArray()['game_id'],
                ]
            );
            $event->game->leagues()->save($model);
        } else {
            $model = League::where('league_id', $event->dto->toArray()['league_id'])->firstOrFail();
        }

        event(new UserLeaguesImported($event->user, $model, $event->dto));

    }
}
