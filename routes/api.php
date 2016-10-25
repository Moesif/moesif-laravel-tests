<?php

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');


Route::get('/firstapi', function (Request $request) {
    return new JsonResponse( [["foo" => 1, "bar" => [1, 2, 3]], 200, array()]);
});
