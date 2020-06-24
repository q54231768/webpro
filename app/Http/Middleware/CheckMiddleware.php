<?php


namespace App\Http\Middleware;

use Closure;

class CheckMiddleware
{


    public function handle($request, Closure $next)
    {
        $request->headers->set('Accept', 'application/json');
        if (!$request->has('id')) {
            return response('hello you');
        }
        return $next($request);
    }
}
