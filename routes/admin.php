<?php

use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\PlanController;
use App\Http\Controllers\Admin\PromoCodeController;
use App\Http\Controllers\Admin\RegionController;
use App\Http\Controllers\Admin\ReferralController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\SeoSettingController;
use App\Http\Controllers\Admin\ServerController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Administration panel
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('users', UserController::class)->except('show');
        Route::resource('plans', PlanController::class)->except('show');
        Route::resource('subscriptions', SubscriptionController::class);
        Route::resource('servers', ServerController::class)->except('show');
        Route::resource('regions', RegionController::class)->except('show');
        Route::resource('promocodes', PromoCodeController::class)->except('show');
        Route::resource('articles', ArticleController::class);
        Route::resource('reviews', ReviewController::class)->except('show', 'create', 'store');

        // Payments — view + status changes only.
        Route::get('payments', [PaymentController::class, 'index'])->name('payments.index');
        Route::get('payments/{payment}', [PaymentController::class, 'show'])->name('payments.show');
        Route::patch('payments/{payment}', [PaymentController::class, 'update'])->name('payments.update');

        // Referral system overview + payouts.
        Route::get('referrals', [ReferralController::class, 'index'])->name('referrals.index');
        Route::patch('referrals/{payout}/approve', [ReferralController::class, 'approve'])->name('referrals.approve');

        // Outgoing notifications (broadcast to users).
        Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
        Route::get('notifications/create', [NotificationController::class, 'create'])->name('notifications.create');
        Route::post('notifications', [NotificationController::class, 'store'])->name('notifications.store');

        // Activity logs (read-only).
        Route::get('logs', [ActivityLogController::class, 'index'])->name('logs.index');

        // Project + SEO settings.
        Route::get('settings', [SettingController::class, 'edit'])->name('settings.edit');
        Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
        Route::get('seo', [SeoSettingController::class, 'edit'])->name('seo.edit');
        Route::put('seo', [SeoSettingController::class, 'update'])->name('seo.update');
    });
