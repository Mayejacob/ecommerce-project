<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\AuthController;
use App\Http\Controllers\Api\v1\ProductController;


Route::group([
    'middleware' => 'auth:sanctum'
], function () {

    Route::withoutMiddleware('auth:sanctum')->prefix('auth/')->group(function () {
        Route::post('login', [AuthController::class, 'signin']);
        Route::post('register', [AuthController::class, 'signup']);
    });

    Route::apiResource('products', ProductController::class);
});