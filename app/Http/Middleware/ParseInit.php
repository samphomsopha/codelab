<?php

namespace App\Http\Middleware;

use Closure;
use Parse\ParseClient;

class ParseInit
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
        ParseClient::initialize( config('parse.app_id'), config('parse.api_key'), config('parse.master_key'));
        return $next($request);
    }
}
