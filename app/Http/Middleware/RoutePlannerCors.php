<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoutePlannerCors
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
        if (str_contains($request->getSchemeAndHttpHost(), 'localhost')) {
            $origin = 'http://localhost:3000';
        } else {
            $origin = 'http://anesucain-route-planner.s3-website-us-east-1.amazonaws.com';
        }

        return $next($request)
            ->header('Access-Control-Allow-Origin', $origin)
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE')
            ->header('Access-Control-Allow-Headers', '*');
    }
}
