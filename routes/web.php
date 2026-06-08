<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\TwoFactorChallengeController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\Public\AboutController;
use App\Http\Controllers\Public\BlogController;
use App\Http\Controllers\Public\ContactController;
use App\Http\Controllers\Public\FaqController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\LegalController;
use App\Http\Controllers\Public\PricingController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public website (locale-prefixed: /ru/..., /en/...)
|--------------------------------------------------------------------------
*/

// Root + bare locale switch helper (session based, non-prefixed).
Route::get('/', function () {
    return redirect('/'.session('locale', config('app.locale')));
})->name('root');

Route::get('locale/{locale}', [LocaleController::class, 'switch'])
    ->where('locale', 'ru|en')
    ->name('locale.switch');

// SEO endpoints (locale-agnostic).
Route::get('sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

Route::prefix('{locale}')->where(['locale' => 'ru|en'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('about', [AboutController::class, 'index'])->name('about');
    Route::get('pricing', [PricingController::class, 'index'])->name('pricing');
    Route::get('faq', [FaqController::class, 'index'])->name('faq');

    Route::get('contacts', [ContactController::class, 'index'])->name('contact');
    Route::post('contacts', [ContactController::class, 'send'])
        ->middleware('throttle:6,1')
        ->name('contact.send');

    Route::get('blog', [BlogController::class, 'index'])->name('blog.index');
    Route::get('blog/{article}', [BlogController::class, 'show'])->name('blog.show');

    Route::get('legal/privacy', [LegalController::class, 'privacy'])->name('legal.privacy');
    Route::get('legal/terms', [LegalController::class, 'terms'])->name('legal.terms');
});

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store'])->middleware('throttle:10,1');

    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store'])->middleware('throttle:10,1');

    Route::get('two-factor-challenge', [TwoFactorChallengeController::class, 'create'])->name('two-factor.login');
    Route::post('two-factor-challenge', [TwoFactorChallengeController::class, 'store'])->middleware('throttle:10,1');

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->middleware('throttle:6,1')->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.store');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', [EmailVerificationPromptController::class, '__invoke'])->name('verification.notice');
    Route::get('verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
        ->middleware(['signed', 'throttle:6,1'])->name('verification.verify');
    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')->name('verification.send');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});
