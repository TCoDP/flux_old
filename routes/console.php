<?php

use App\Enums\SubscriptionStatus;
use App\Models\Notification;
use App\Models\Subscription;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/*
|--------------------------------------------------------------------------
| Flux maintenance commands (run via the scheduler / queue)
|--------------------------------------------------------------------------
*/

Artisan::command('flux:expire-subscriptions', function () {
    $count = Subscription::query()
        ->whereIn('status', [SubscriptionStatus::Active, SubscriptionStatus::Trialing])
        ->whereNotNull('ends_at')
        ->where('ends_at', '<', now())
        ->update(['status' => SubscriptionStatus::Expired]);

    $this->info("Expired {$count} subscription(s).");
})->purpose('Mark subscriptions whose term has ended as expired');

Artisan::command('flux:renewal-reminders', function () {
    Subscription::query()
        ->with('user', 'plan')
        ->where('status', SubscriptionStatus::Active)
        ->whereNotNull('ends_at')
        ->whereBetween('ends_at', [now(), now()->addDays(3)])
        ->each(function (Subscription $subscription) {
            Notification::firstOrCreate(
                ['user_id' => $subscription->user_id, 'type' => 'billing', 'title' => 'Подписка скоро истечёт'],
                [
                    'body' => 'Подписка «'.$subscription->plan?->name.'» истекает '.$subscription->ends_at?->isoFormat('D MMMM').'. Продлите доступ заранее.',
                    'icon' => 'clock',
                    'action_url' => route('dashboard.subscriptions.index'),
                ],
            );
        });

    $this->info('Renewal reminders dispatched.');
})->purpose('Notify users about subscriptions ending soon');

// Scheduler
Schedule::command('flux:expire-subscriptions')->dailyAt('00:10');
Schedule::command('flux:renewal-reminders')->dailyAt('09:00');
