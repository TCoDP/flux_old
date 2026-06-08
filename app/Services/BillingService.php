<?php

namespace App\Services;

use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Enums\SubscriptionStatus;
use App\Models\Notification;
use App\Models\Payment;
use App\Models\Plan;
use App\Models\PromoCode;
use App\Models\Subscription;
use App\Models\User;
use App\Support\Money;
use Illuminate\Support\Facades\DB;

class BillingService
{
    public function __construct(
        private readonly ReferralService $referrals,
        private readonly ConnectionProvisioner $provisioner,
    ) {}

    /** Create a pending payment for a plan, applying an optional promo code. */
    public function checkout(User $user, Plan $plan, PaymentMethod $method, ?PromoCode $promo = null): Payment
    {
        $amount = (float) $plan->price;
        $discount = $promo && $promo->isValid() ? $promo->discountFor($amount) : 0.0;

        return Payment::create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'promo_code_id' => $promo?->id,
            'amount' => $amount,
            'discount' => $discount,
            'currency' => $plan->currency,
            'method' => $method,
            'status' => PaymentStatus::Pending,
        ]);
    }

    /**
     * Settle a payment: activate or extend the subscription, provision a
     * connection profile, reward referrers and notify the user.
     */
    public function markPaid(Payment $payment): Subscription
    {
        return DB::transaction(function () use ($payment) {
            $payment->update(['status' => PaymentStatus::Paid, 'paid_at' => now()]);

            if ($payment->promo_code_id) {
                PromoCode::whereKey($payment->promo_code_id)->increment('used_count');
            }

            $subscription = $this->activateSubscription($payment);

            $payment->update(['subscription_id' => $subscription->id]);

            if ($subscription->connections()->count() === 0) {
                $this->provisioner->provision($subscription);
            }

            $this->referrals->reward($payment);

            Notification::create([
                'user_id' => $payment->user_id,
                'type' => 'billing',
                'title' => __('notifications.payment_success_title'),
                'body' => __('notifications.payment_success_body', ['amount' => Money::format($payment->total(), $payment->currency)]),
                'icon' => 'credit-card',
            ]);

            return $subscription;
        });
    }

    private function activateSubscription(Payment $payment): Subscription
    {
        $plan = $payment->plan;
        $user = $payment->user;

        $subscription = $user->subscriptions()
            ->where('plan_id', $plan->id)
            ->whereIn('status', [SubscriptionStatus::Active, SubscriptionStatus::Trialing, SubscriptionStatus::Expired])
            ->latest('ends_at')
            ->first();

        $base = $subscription && $subscription->ends_at?->isFuture()
            ? $subscription->ends_at
            : now();

        $ends = $base->copy()->addMonths(max(1, $plan->billing_months));

        if ($subscription) {
            $subscription->update([
                'status' => SubscriptionStatus::Active,
                'ends_at' => $ends,
                'canceled_at' => null,
            ]);

            return $subscription;
        }

        return $user->subscriptions()->create([
            'plan_id' => $plan->id,
            'status' => SubscriptionStatus::Active,
            'starts_at' => now(),
            'ends_at' => $ends,
            'auto_renew' => true,
        ]);
    }
}
