<?php

use App\Http\Controllers\Dashboard\ApiTokenController;
use App\Http\Controllers\Dashboard\CheckoutController;
use App\Http\Controllers\Dashboard\ConnectionController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\DeviceController;
use App\Http\Controllers\Dashboard\NotificationController;
use App\Http\Controllers\Dashboard\PaymentController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\PromoCodeController;
use App\Http\Controllers\Dashboard\ReferralController;
use App\Http\Controllers\Dashboard\RenewalController;
use App\Http\Controllers\Dashboard\SecurityController;
use App\Http\Controllers\Dashboard\SubscriptionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| User dashboard (личный кабинет)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified', '2fa'])
    ->prefix('dashboard')
    ->name('dashboard.')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('home');

        // Subscriptions + renewal
        Route::get('subscriptions', [SubscriptionController::class, 'index'])->name('subscriptions.index');
        Route::get('subscriptions/{subscription}', [SubscriptionController::class, 'show'])->name('subscriptions.show');
        Route::get('subscriptions/{subscription}/renew', [RenewalController::class, 'create'])->name('subscriptions.renew');
        Route::post('subscriptions/{subscription}/renew', [RenewalController::class, 'store'])->name('subscriptions.renew.store');

        // Checkout (new plan purchase)
        Route::get('checkout/{plan}', [CheckoutController::class, 'show'])->name('checkout');
        Route::post('checkout/{plan}', [CheckoutController::class, 'store'])->name('checkout.store');

        // Devices
        Route::get('devices', [DeviceController::class, 'index'])->name('devices.index');
        Route::post('devices', [DeviceController::class, 'store'])->name('devices.store');
        Route::delete('devices/{device}', [DeviceController::class, 'destroy'])->name('devices.destroy');

        // Connections (профили подключений)
        Route::get('connections', [ConnectionController::class, 'index'])->name('connections.index');
        Route::get('connections/{connection}', [ConnectionController::class, 'show'])->name('connections.show');
        Route::post('connections/{connection}/regenerate', [ConnectionController::class, 'regenerate'])->name('connections.regenerate');

        // Payments
        Route::get('payments', [PaymentController::class, 'index'])->name('payments.index');
        Route::get('payments/{payment}', [PaymentController::class, 'show'])->name('payments.show');
        Route::get('payments/{payment}/invoice', [PaymentController::class, 'invoice'])->name('payments.invoice');

        // Referral programme
        Route::get('referrals', [ReferralController::class, 'index'])->name('referrals');
        Route::post('referrals/payout', [ReferralController::class, 'requestPayout'])->name('referrals.payout');

        // Promo codes
        Route::get('promocodes', [PromoCodeController::class, 'index'])->name('promocodes.index');
        Route::post('promocodes', [PromoCodeController::class, 'redeem'])->middleware('throttle:10,1')->name('promocodes.redeem');

        // Notifications
        Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
        Route::patch('notifications/{notification}/read', [NotificationController::class, 'read'])->name('notifications.read');
        Route::patch('notifications/read-all', [NotificationController::class, 'readAll'])->name('notifications.read-all');

        // Profile settings
        Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        // Security settings (password + 2FA)
        Route::get('security', [SecurityController::class, 'edit'])->name('security.edit');
        Route::put('security/password', [SecurityController::class, 'updatePassword'])->name('security.password');
        Route::post('security/two-factor', [SecurityController::class, 'enableTwoFactor'])->name('security.2fa.enable');
        Route::post('security/two-factor/confirm', [SecurityController::class, 'confirmTwoFactor'])->name('security.2fa.confirm');
        Route::delete('security/two-factor', [SecurityController::class, 'disableTwoFactor'])->name('security.2fa.disable');

        // API access (Sanctum personal access tokens)
        Route::get('api-tokens', [ApiTokenController::class, 'index'])->name('api-tokens.index');
        Route::post('api-tokens', [ApiTokenController::class, 'store'])->name('api-tokens.store');
        Route::delete('api-tokens/{token}', [ApiTokenController::class, 'destroy'])->name('api-tokens.destroy');
    });
