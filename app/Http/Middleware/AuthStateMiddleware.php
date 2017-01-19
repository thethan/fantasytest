<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Auth\TokenGuard;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Contracts\Auth\Guard;

class AuthStateMiddleware extends Authenticate
{

    protected $guard;

    public function __construct(Auth $auth, Guard $guard = null)
    {
        /**
         * @var TokenGuard
         */
        $this->guard = $guard;
        parent::__construct($auth);
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$guards)
    {
        $credentials['api_token'] = $request->input('state') ?: $request->input('api_token');
        $request->replace(['api_token' => $credentials['api_token']]);

        return parent::handle($request, $next, 'api');
//        if (!$this->guard->validate($credentials)) {
//            throw new AuthenticationException();
//        }

//        return $next($request);
    }
}
