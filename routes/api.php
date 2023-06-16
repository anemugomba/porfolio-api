<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/gestalt', function (Request $request) {
    return response('All good!', 200);
});

Route::get('/environments', function (Request $request) {
    return response(array('APP_NAME' => env('APP_NAME'), 'APP_ENV' => env('APP_ENV'), 'AWS_LOCATION_SERVICE_KEY' => env('AWS_LOCATION_SERVICE_KEY')), 200);
});
