<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;
// use App\Http\Middleware\MoesifSenderThread;

use Illuminate\Support\Facades\Auth;

class MoesifLaravel
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $userId = null, $sessionId = null)
    {
        // do action before response


        //calling middleware from controller.
        //$this->middleware('moesif:userId,sessionToken');

        // this gets all headers in array key value pairs.
        // $request->headers->all()

        $response = $next($request);


        if (is_null($userId)) {
            Log::info('no user id passed in');

            if (is_null($request->user())) {
                Log::info('no user id passed in');
            } else {
                $userId = $request->user();
            }
        }

        $user = Auth::user();

        Log::info('user=' . $user);

        if (is_null($sessionId)) {
            Log::info('no sessionId passed in');
        }

        Log::info('inside MoesifLaravel middleware start request');
        Log::info('verb=' . $request->method());
        Log::info('url=' . $request->fullUrl());
        Log::info('ip=' . $request->ip());
        Log::info('header=' . implode(', ', $request->headers->keys()));
        Log::info('user from request=' . $request->user());

        $user = Auth::user();

        Log::info('userId=' . $user['id']);

        Log::info('sessionId=' . $request->session()->getId());

        Log::info('res_headers=' . implode(', ', $response->headers->keys()));
        Log::info('res_body=' . $response->content());
        Log::info('res_status=' . $response->status());

        // do action after response

        // $worker = new MoesifSenderThread();
        // // $thread = new WorkerThread();
        // $thread->wait()->run($request->headers);

        return $response;
    }
}
