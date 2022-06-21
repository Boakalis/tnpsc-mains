<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class XAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next) {

        // check if we have an X-Authorization header present
        if($auth = $request->header('X-Authorization')) {
            $request->headers->set('Authorization', $auth);
        }

        return $next($request);
    }
}
