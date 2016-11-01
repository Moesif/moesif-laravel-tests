<?php
namespace App\Http\Middleware;

use Closure;

use DateTime;
use DateTimeZone;

use Illuminate\Support\Facades\Log;
// use App\Http\Middleware\MoesifSenderThread;
use Illuminate\Support\Facades\Auth;

use App\Http\Middleware\Moesif\MoesifApi;

require_once(dirname(__FILE__) . "/Moesif/MoesifApi.php");

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


        //calling middleware from controller.
        //$this->middleware('moesif:userId,sessionToken');

        // this gets all headers in array key value pairs.
        // $request->headers->all()
        $t = LARAVEL_START;
        $micro = sprintf("%06d",($t - floor($t)) * 1000000);
        $startDateTime = new DateTime( date('Y-m-d H:i:s.'.$micro, $t) );
        $startDateTime->setTimezone(new DateTimeZone("UTC"));

        Log::info('start time: '. $startDateTime->format('Y-m-d\TH:i:s.uP'));

        $response = $next($request);


        $maskRequestHeaders = config('moesif.maskRequestHeaders');
        $maskRequestBody = config('moesif.maskRequestBody');
        $maskRequestHeaders = config('moesif.maskResponseHeaders');
        $maskRequestBody = config('moesif.maskResponseBody');
        $identifyUserId = config('moesif.identifyUserId');
        $identifySessionId = config('moesif.identifySessionId');

        $user = Auth::user();

        $userId = null;

        if (!is_null($identifyUserId)) {
            $userId = $identifyUserId($request, $response);
        } else if (!is_null($user)) {
            $userId = $user['id'];
        }

        Log::info('user=' . $user);

        Log::info('inside MoesifLaravel middleware start request');
        Log::info('verb=' . $request->method());
        Log::info('url=' . $request->fullUrl());
        Log::info('ip=' . $request->ip());
        Log::info('header=' . implode(', ', $request->headers->keys()));
        Log::info('user from request=' . $request->user());

        $user = Auth::user();

        Log::info('userId=' . $user['id']);

        if ($request->hasSession()) {
            Log::info('sessionId=' . $request->session()->getId());
        } else {
            Log::info('no session');
        }

        // headerbag function all() returns the array dict of headers.

        Log::info('res_status=' . $response->status());

        $configTestVal = config('moesif.testval');
        $configTestFunc = config('moesif.testfunc');
        $applicationId = config('moesif.applicationId');

        Log::info('got config val=' . $configTestVal);
        Log::info('shouldn not have anything=' . config('moesif.notexistval'));
        Log::info('res_headers=' . implode(', ', $response->headers->keys()));
        Log::info('res_body=' . $response->content());
        Log::info('got config func=' . $configTestFunc(10) );
        // do action after response

        $moesifApi = MoesifApi::getInstance($applicationId, ['fork'=>true, 'debug'=>true]);


        $endTime = microTime(true);
        $micro = sprintf("%06d",($endTime - floor($endTime)) * 1000000);
        $endDateTime = new DateTime( date('Y-m-d H:i:s.'.$micro, $endTime) );
        $endDateTime->setTimezone(new DateTimeZone("UTC"));

        $data = [
            'request' => [
                'time' => $startDateTime->format('Y-m-d\TH:i:s.uP'),
                'verb' => $request->method(),
                'url' => $request->fullUrl(),
                'ip' => $request->ip(),
                'headers' => $request->headers->all(),
                'body' => $request->getContent()
            ],
            'response' => [
                'time' => $endDateTime->format('Y-m-d\TH:i:s.uP'),
                'headers' => $response->headers->all(),
                'body' => $response->content(),
                'status' => $response->status()
            ],
        ];
        if (!is_null($userId)) {
            $data['user_id'] = $userId;
        }


        //$d = new DateTime();







        Log::info('end time: '. $d->format(Datetime::ATOM));

        Log::info('end time: ' . $endTime);
        $moesifApi->track($data);

        // $worker = new MoesifSenderThread();
        // // $thread = new WorkerThread();
        // $thread->wait()->run($request->headers);

        return $response;
    }
}
