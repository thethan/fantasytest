<?php

namespace App\Listeners;

use App\LeagueRoster;
use App\Events\UserLeaguesImported;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Contracts\Yahoo\Services\Leagues\GetLeaguesContract;


class ImportLeagueRoster implements ShouldQueue
{

    protected $service;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(GetLeaguesContract $service)
    {
        $this->service = $service;
    }

    /**
     * Handle the event.
     *
     * @param  UserLeaguesImported  $event
     * @return void
     */
    public function handle(UserLeaguesImported $event)
    {
        $this->service->setUser($event->user);

        $this->service->setUriParams('league_key', $event->dto->toArray()['league_id']);
        $this->service->setUriParams('game_key',  $event->dto->toArray()['game_id']);

        $dto = $this->service->call();

        // Find the league with the same league_id
        $league = $event->league;
        $settings = $dto->simpleResponse()->first();
        $leagueRosterCount = 0;
        $league->name = $settings['name'];
        $league->draft_status = $settings['draft_status'];
        foreach($settings['roster_positions'] as $roster_position){

            $roster = LeagueRoster::firstOrnew(
                [
                    'position' => $roster_position['roster_position']['position'],
                    'count' => $roster_position['roster_position']['count'],
                    'league_id' => $league->id
                ] );

            $league->roster()->save($roster);

            $leagueRosterCount += $roster_position['roster_position']['count'];
        }

        $league->roster_size = $leagueRosterCount;
        $league->save();
    }
}
