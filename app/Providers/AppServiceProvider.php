<?php

namespace App\Providers;

use App\Http\Middleware\AuthStateMiddleware;
use App\DataTransferObjects\Users\Games\UsersGamesDto;
use App\Contracts\Yahoo\Services\Leagues\GetLeaguesContract;
use App\Contracts\Yahoo\Services\Users\GetUserGamesContract;
use App\Contracts\Yahoo\Services\Users\GetUserTeamsContract;

use App\Yahoo\Responses\User\GetTeamsResponse;
use Illuminate\Auth\TokenGuard;
use Illuminate\Auth\AuthManager;
use Illuminate\Support\ServiceProvider;
use App\Yahoo\Responses\Leagues\SettingsResponse;
use App\Yahoo\Responses\User\TeamResponseForSaving;
use App\Yahoo\Services\Fantasy\Leagues\GetSettings;
use App\Yahoo\Services\Fantasy\Users\Games\GetTeams;
use App\Yahoo\Services\Fantasy\Users\Games\Get as GetUsersGames;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
      
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        /**
         *
         */
        $this->app->bind(AuthStateMiddleware::class, function($app){
            $tokenGuard = new TokenGuard($app['auth']->createUserProvider('users'), $this->app['request']);
            return new AuthStateMiddleware($app['auth'], $tokenGuard);
        });


        /**
         * Responses
         */
        $this->app->bind(GetUserGamesContract::class, function($app){
           return new GetUsersGames(new UsersGamesDto());
        });

        /**
         * Responses
         */
        $this->app->bind(GetUserTeamsContract::class, function($app){
            return new GetTeams(new GetTeamsResponse());
        });

        $this->app->bind(GetLeaguesContract::class, function($app){
            return new GetSettings(new SettingsResponse());
        });
    }
}
