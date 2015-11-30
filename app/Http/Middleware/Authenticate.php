<?php

namespace App\Http\Middleware;

use Closure;
use Parse\ParseUser;
use Parse\ParseClient;

class Authenticate
{

    protected $current_user;


    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->current_user = ParseUser::getCurrentUser();
        if (!$this->current_user)
        {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->route('login');
            }
        }

        return $next($request);
    }
}
