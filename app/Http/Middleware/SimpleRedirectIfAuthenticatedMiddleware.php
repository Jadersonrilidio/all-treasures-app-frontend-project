<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SimpleRedirectIfAuthenticatedMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!isset($_SESSION)) session_start();

        return ( isset($_SESSION['id']) and $_SESSION['id'] != '' )
            ? redirect()->route('home')
            : $next($request);
    }
}
