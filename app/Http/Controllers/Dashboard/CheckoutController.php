<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\PaymentMethod;
use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\PromoCode;
use App\Services\BillingService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function show(Plan $plan): View
    {
        abort_unless($plan->is_active, 404);

        return view('dashboard.checkout', [
            'plan' => $plan,
            'methods' => PaymentMethod::cases(),
        ]);
    }

    public function store(Request $request, Plan $plan, BillingService $billing): RedirectResponse
    {
        $data = $request->validate([
            'method' => ['required', 'string', 'in:'.implode(',', PaymentMethod::values())],
            'promo_code' => ['nullable', 'string', 'max:32'],
        ]);

        $promo = isset($data['promo_code'])
            ? PromoCode::where('code', $data['promo_code'])->first()
            : null;

        $payment = $billing->checkout($request->user(), $plan, PaymentMethod::from($data['method']), $promo);

        // No live gateway in this environment — settle immediately for demonstration.
        $subscription = $billing->markPaid($payment);

        return redirect()
            ->route('dashboard.subscriptions.show', $subscription)
            ->with('status', __('dashboard.checkout.success'));
    }
}
