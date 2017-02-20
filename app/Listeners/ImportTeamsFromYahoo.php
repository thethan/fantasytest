<?php

namespace App\Listeners;

use App\Game;
use App\Team;
use App\Events\UserLeaguesImported;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Queue\ShouldQueue;


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
     * @param UserLeaguesImported $event
     */
    public function handle(UserLeaguesImported $event)
    {
        $validator = Validator::make(
            array('team_key' => $event->dto->toArray()['team_key']),
            array('team_key' => array('unique:teams,team_key'))
        );

        if ($validator->passes()) {
            $game = Game::where('game_id', $event->dto->toArray()['game_id'])->firstOrFail();
            $model = new Team([
                    'name' => $event->dto->toArray()['name'],
                    'team_key' => $event->dto->toArray()['team_key'],
                    'logo' => $event->dto->toArray()['logo'],
                    'game_id' => $game->id,
                    'user_id' => $event->user->id,
                ]
            );
            $event->league->teams()->save($model);
        } else {
            $model = Team::where('team_key', $event->dto->toArray()['team_key'])->firstOrFail();
        }


    }
}
