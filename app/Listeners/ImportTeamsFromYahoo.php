<?php

namespace App\Listeners;

use App\Events\UserLeaguesImported;
use App\Events\UserTeamsImported;
use App\Team;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Validator;

class ImportTeamsFromYahoo implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserTeamsImported  $event
     * @return void
     */
    public function handle(UserLeaguesImported $event)
    {
        $validator = Validator::make(
            array('team_key' => $event->dto->toArray()['league_id']),
            array('team_key' => array('unique:teams,team_key'))
        );

        if ($validator->passes()) {

            $model = new Team([
                    'name' => $event->dto->toArray()['name'],
                    'team_key' => $event->dto->toArray()['team_key'],
                    'logo' => $event->dto->toArray()['logo'],
                    'user_id' => $event->user->id,
                ]
            );
            $event->league->teams()->save($model);
        } else {
            $model = Team::where('team_key', $event->dto->toArray()['team_key'])->firstOrFail();
        }
    }
}
