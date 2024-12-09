<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\AuthVerifyController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/**
 * Prefix Here Should : api
 *
 */

// Authentication

Route::controller(AuthVerifyController::class)
    ->group(function () {
        Route::post('/{type}/register', 'register')->middleware(['valid.type']);
        Route::post('/{type}/login', 'login')->middleware(['valid.type']);
        Route::post('/{type}/{method}/verify', 'verify')->middleware(['valid.type', 'valid.method']);
        Route::post('/{type}/resend-code', 'resendCode')->middleware(['valid.type']);
        Route::post('/user/logout', 'logout')->middleware(['auth.any:user', 'type:user']);
        Route::post('/employee/logout', 'logout')->middleware(['auth.any:employee', 'type:employee']);
    });


Route::controller(AuthController::class)
    ->group(function () {
        Route::post('/admin-login', 'login')->middleware(['type:admin']);
        Route::post('/admin-logout', 'logout')->middleware(['auth.any:admin']);
    });

Route::middleware('auth.any:user,employee')->group(function () {
    Route::post('/image', [UserController::class, 'uploadImage']);
    Route::delete('/image', [UserController::class, 'deleteImage']);
});
