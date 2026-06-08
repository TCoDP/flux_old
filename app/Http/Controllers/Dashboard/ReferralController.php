<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\PayoutStatus;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReferralController extends Controller
{
    public const MIN_PAYOUT = 500;

    public function index(Request $request): View
    {
        $user = $request->user();

        return view('dashboard.referrals', [
            'referrals' => $user->referralsMade()->with('referred')->latest()->get(),
            'payouts' => $user->referralPayouts()->latest()->get(),
            'balance' => $user->balance,
            'referralLink' => route('register', ['locale' => app()->getLocale(), 'ref' => $user->referral_code]),
            'referralCode' => $user->referral_code,
            'invitedCount' => $user->referralsMade()->count(),
            'rewardPercent' => \App\Services\ReferralService::REWARD_PERCENT,
            'minPayout' => self::MIN_PAYOUT,
        ]);
    }

    public function requestPayout(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'amount' => ['required', 'numeric', 'min:'.self::MIN_PAYOUT],
            'method' => ['required', 'string', 'in:card,sbp'],
            'details' => ['required', 'string', 'max:120'],
        ]);

        $user = $request->user();

        if ($data['amount'] > (float) $user->balance) {
            return back()->withErrors(['amount' => __('dashboard.referrals.insufficient')]);
        }

        DB::transaction(function () use ($user, $data) {
            $user->referralPayouts()->create([
                'amount' => $data['amount'],
                'status' => PayoutStatus::Pending,
                'method' => $data['method'],
                'details' => $data['details'],
            ]);

            $user->decrement('balance', $data['amount']);
        });

        return back()->with('status', __('dashboard.referrals.payout_requested'));
    }
}
