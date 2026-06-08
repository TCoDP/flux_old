<?php

use App\Http\Controllers\Docs\DocumentationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Documentation (locale-prefixed)
|--------------------------------------------------------------------------
| Platforms: windows, macos, linux, android, ios, android-tv, smart-tv, routers
*/

Route::prefix('{locale}/docs')->where(['locale' => 'ru|en'])->name('docs.')->group(function () {
    Route::get('/', [DocumentationController::class, 'index'])->name('index');
    Route::get('{platform}', [DocumentationController::class, 'platform'])
        ->where('platform', 'windows|macos|linux|android|ios|android-tv|smart-tv|routers')
        ->name('platform');
});
