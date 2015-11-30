<?php

namespace App\Http\Middleware;

use Closure;

class StartPHPSession
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
        session_start();
        return $next($request);
    }
}
