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


Route::middleware('api')->group(function () {
    Route::apiResource('/users', \App\Http\Controllers\UserController::class)->only(['index', 'destroy']);
    Route::patch('/users/{user}/details', [\App\Http\Controllers\UserDetailController::class, 'update']);
});
