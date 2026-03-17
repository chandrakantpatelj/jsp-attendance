<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PunchController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:api')->group(function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::get('/user/status', [AuthController::class, 'status']);
        Route::post('/punch/action', [PunchController::class, 'action']);
        Route::get('/punch/history', [PunchController::class, 'history']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});

