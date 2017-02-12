<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\UserLoggedIntoFantasy' => [
            'App\Listeners\ImportUserDataFromYahoo',
        ],
        'App\Events\UserGamesImported' => [
            'App\Listeners\ImportLeaguesFromYahoo'
        ],
        'App\Events\UserLeaguesImported' => [
            'App\Listeners\ImportTeamsFromYahoo'
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
