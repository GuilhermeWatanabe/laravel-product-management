<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductAPIController;
use Illuminate\Support\Facades\Route;

Route::name('api.')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::name('api.')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::apiResource('/products', ProductAPIController::class);
    });
});