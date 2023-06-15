<?php

use Illuminate\Support\Facades\Route;


Route::post('/route-calculation', [\App\Http\Controllers\RoutePlanner\RoutePlannerController::class, 'routeCalculation']);

Route::get('/addresses', [\App\Http\Controllers\RoutePlanner\RoutePlannerController::class, 'addresses']);

