<?php

namespace App\Http\Middleware;

use Closure;

class AddCspHeader
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
        $response =  $next($request);

        $response->header('Content-Security-Policy', "default-src * 'self'; style-src * 'unsafe-inline'; script-src 'self' 'unsafe-inline' 'unsafe-eval' https://www.googletagmanager.com https://connect.facebook.net https://www.google-analytics.com  https://s.ytimg.com http://www.youtube.com; img-src * data: 'self'; connect-src * 'self'; object-src 'none'; frame-src *;");
        return $response;
    }
}
