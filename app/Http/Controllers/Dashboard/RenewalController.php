<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\PaymentMethod;
use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Services\BillingService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RenewalController extends Controller
{
    public function create(Request $request, Subscription $subscription): View
    {
        abort_unless($subscription->user_id === $request->user()->id, 403);

        return view('dashboard.renew', [
            'subscription' => $subscription->load('plan'),
            'methods' => PaymentMethod::cases(),
        ]);
    }

    public function store(Request $request, Subscription $subscription, BillingService $billing): RedirectResponse
    {
        abort_unless($subscription->user_id === $request->user()->id, 403);

        $data = $request->validate([
            'method' => ['required', 'string', 'in:'.implode(',', PaymentMethod::values())],
        ]);

        $payment = $billing->checkout($request->user(), $subscription->plan, PaymentMethod::from($data['method']));
        $billing->markPaid($payment);

        return redirect()
            ->route('dashboard.subscriptions.show', $subscription)
            ->with('status', __('dashboard.renew.success'));
    }
}
