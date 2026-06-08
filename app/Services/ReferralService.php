<?php

namespace App\Services;

use App\Enums\ReferralStatus;
use App\Models\Payment;
use App\Models\Referral;
use App\Models\User;

class ReferralService
{
    /** Reward percentage credited to the referrer on a referred user's payment. */
    public const REWARD_PERCENT = 20;

    /** Link a newly registered user to their referrer by referral code. */
    public function attach(User $referred, ?string $code): void
    {
        if (! $code) {
            return;
        }

        $referrer = User::where('referral_code', $code)->first();

        if (! $referrer || $referrer->id === $referred->id) {
            return;
        }

        $referred->forceFill(['referred_by' => $referrer->id])->save();

        Referral::firstOrCreate(
            ['referred_id' => $referred->id],
            ['referrer_id' => $referrer->id, 'status' => ReferralStatus::Pending],
        );
    }

    /** Credit the referrer when a referred user completes a payment. */
    public function reward(Payment $payment): void
    {
        $referral = Referral::where('referred_id', $payment->user_id)
            ->where('status', '!=', ReferralStatus::Rewarded)
            ->first();

        if (! $referral) {
            return;
        }

        $reward = round($payment->total() * self::REWARD_PERCENT / 100, 2);

        $referral->update([
            'status' => ReferralStatus::Rewarded,
            'reward_amount' => $referral->reward_amount + $reward,
            'confirmed_at' => now(),
        ]);

        $referral->referrer()->increment('balance', $reward);
    }
}
