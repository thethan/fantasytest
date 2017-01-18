<?php

namespace App\Providers;

use App\Http\Middleware\AuthStateMiddleware;
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

            return new AuthStateMiddleware($tokenGuard);
        });
    }
}
