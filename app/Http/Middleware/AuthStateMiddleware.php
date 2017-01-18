<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Auth\Guard;

class AuthStateMiddleware
{

    protected $guard;

    public function __construct(Guard $guard)
    {
        $this->guard = $guard;
        $this->input_key = 'state';
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $credentials['api_token'] = $request->input('state');

        if (!$this->guard->validate($credentials)) {
            throw new AuthenticationException();
        }

        return $next($request);
    }
}
