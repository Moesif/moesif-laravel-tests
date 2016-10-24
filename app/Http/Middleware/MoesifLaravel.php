<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class MoesifLaravel
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
        // do action before response

        Log::info('inside MoesifLaravel middleware start request');
        Log::info('verb=' . $request->method());
        Log::info('url=' . $request->fullUrl());
        Log::info('ip=' . $request->ip());
        // Log::info('header=' . $request->$headers.all());
        Log::info('user=' . $request->user());
        Log::info('session=' . $request->getSession());

        $response = $next($request);

        // Log::info('res_headers=' . $response->$headers);
        Log::info('res_body=' . $response->content());
        Log::info('res_status=' . $response->status());

        // do action after response
        // Log::info('inside MoesifLaravel middleware after response=\n' . $response);
        return $response;
    }
}
