<?php

namespace App\Providers;

use App\Http\Middleware\AuthStateMiddleware;
use App\Service\SaveUsersGameService;
use App\User;
use App\Yahoo\Fantasy\Users\Games\Get as GetUsersGames;
use Illuminate\Auth\AuthManager;
use Illuminate\Auth\TokenGuard;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\ServiceProvider;

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
        $this->app->bind(SaveUsersGameService::class, function($app){
            $service = new GetUsersGames($app->make(User::class));
            return new SaveUsersGameService($service);
        });
    }
}
