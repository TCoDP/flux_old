<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PayoutStatus;
use App\Http\Controllers\Controller;
use App\Models\Referral;
use App\Models\ReferralPayout;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ReferralController extends Controller
{
    public function index(): View
    {
        return view('admin.referrals.index', [
            'referrals' => Referral::with('referrer', 'referred')->latest()->paginate(15),
            'payouts' => ReferralPayout::with('user')->latest()->take(20)->get(),
            'pendingTotal' => ReferralPayout::where('status', PayoutStatus::Pending)->sum('amount'),
        ]);
    }

    public function approve(ReferralPayout $payout): RedirectResponse
    {
        $payout->update(['status' => PayoutStatus::Paid, 'processed_at' => now()]);

        return back()->with('status', __('admin.saved'));
    }
}
