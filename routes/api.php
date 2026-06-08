<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\ConnectionController;
use App\Http\Controllers\Api\V1\DeviceController;
use App\Http\Controllers\Api\V1\PlanController;
use App\Http\Controllers\Api\V1\ProfileController;
use App\Http\Controllers\Api\V1\SubscriptionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API (Sanctum personal access tokens)
|--------------------------------------------------------------------------
*/

// Public endpoints
Route::prefix('v1')->name('api.v1.')->group(function () {
    Route::post('auth/register', [AuthController::class, 'register'])->middleware('throttle:6,1')->name('auth.register');
    Route::post('auth/login', [AuthController::class, 'login'])->middleware('throttle:6,1')->name('auth.login');
    Route::get('plans', [PlanController::class, 'index'])->name('plans');
    Route::get('meta', [\App\Http\Controllers\Api\V1\MetaController::class, 'index'])->name('meta');
});

// Authenticated endpoints
Route::middleware('auth:sanctum')->prefix('v1')->name('api.v1.')->group(function () {
    Route::get('me', [ProfileController::class, 'show'])->name('me');
    Route::post('auth/logout', [AuthController::class, 'logout'])->name('auth.logout');

    Route::get('subscriptions', [SubscriptionController::class, 'index'])->name('subscriptions.index');
    Route::get('subscriptions/{subscription}', [SubscriptionController::class, 'show'])->name('subscriptions.show');

    Route::get('connections', [ConnectionController::class, 'index'])->name('connections.index');
    Route::get('connections/{connection}', [ConnectionController::class, 'show'])->name('connections.show');

    Route::get('devices', [DeviceController::class, 'index'])->name('devices.index');
});

// Lightweight identity endpoint.
Route::middleware('auth:sanctum')->get('/user', fn (Request $request) => $request->user());
