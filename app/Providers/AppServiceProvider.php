<?php

namespace App\Providers;

use App\Contracts\Services\GetUsersGamesInterface;
use App\Http\Middleware\AuthStateMiddleware;

use App\Services\SaveUsersGameService;
use App\User;
use Illuminate\Auth\AuthManager;
use Illuminate\Auth\TokenGuard;
use Illuminate\Support\ServiceProvider;
use App\Yahoo\Fantasy\Users\Games\Get as GetUsersGames;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        /**
         * @var AuthManager
         */
        $this->app->bind(AuthStateMiddleware::class, function($app){
            $tokenGuard = new TokenGuard($app['auth']->createUserProvider('users'), $this->app['request']);

            return new AuthStateMiddleware($app['auth'], $tokenGuard);
        });


        /**
         * Services
         */
        $this->app->bind(GetUsersGamesInterface::class, function($app){
            $service = new GetUsersGames($app->make(User::class));
            return new SaveUsersGameService($service);
        });
    }
}
