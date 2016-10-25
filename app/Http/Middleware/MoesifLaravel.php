<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;
// use Aza\Components\Thread;


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
        Log::info('header=' . implode(', ', $request->headers->keys()));
        Log::info('user=' . $request->user());
        Log::info('session=' . $request->getSession());

        $response = $next($request);

        Log::info('res_headers=' . implode(', ', $response->headers->keys()));
        Log::info('res_body=' . $response->content());
        Log::info('res_status=' . $response->status());

        // do action after response


        // $worker = new WorkerThread($request->headers);
        // $thread = new WorkerThread();
        // $thread->wait()->run($request->headers);

        return $response;
    }
}

// class WorkerThread extends Thread {
//
//     public function process() {
//         $param = $this->getParam(0);
//
//         Log::info('inside thread: ');
//     }
//
// }
