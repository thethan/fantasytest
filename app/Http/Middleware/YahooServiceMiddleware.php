<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\AuthenticationException;

/**
 * Class YahooServiceMiddleware
 * @package App\Http\Middleware
 */
class YahooServiceMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::user()->yahooToken->id) {
            return $next($request);
        }

        throw new AuthenticationException('YahooToken is not available for this user.', []);
    }
}
