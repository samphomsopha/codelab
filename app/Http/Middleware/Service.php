<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Service
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
        try
        {
            $response = next($request);
            $ret = [
                'status' => '',
                'data' => $response
            ];
            var_dump($response);
            if ($response->getStatusCode() == 200)
            {
                $ret['status'] = 'success';
            } else {
                $ret['status'] = 'fail';
            }
            return $response->json($ret)
                ->header('Content-Type', 'text/json');
        }
        catch (HttpException $e)
        {
            echo "HERE2";
            $ret = ['status' => 'fail', 'error' => $e->getMessage()];
            $response->json($ret)
                ->header('Status Code', $e->getCode())
                ->header('Content-Type', 'text/json');
        }

    }
}
