<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PaymentController extends Controller
{
    public function index(Request $request): View
    {
        $payments = Payment::with('user', 'plan')
            ->when($request->string('status')->toString(), fn ($q, $s) => $q->where('status', $s))
            ->when($request->string('method')->toString(), fn ($q, $m) => $q->where('method', $m))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.payments.index', [
            'payments' => $payments,
            'statuses' => PaymentStatus::cases(),
            'totalPaid' => Payment::where('status', PaymentStatus::Paid)->sum('amount'),
        ]);
    }

    public function show(Payment $payment): View
    {
        return view('admin.payments.show', ['payment' => $payment->load('user', 'plan', 'subscription', 'promoCode')]);
    }

    public function update(Request $request, Payment $payment): RedirectResponse
    {
        $data = $request->validate(['status' => ['required', Rule::enum(PaymentStatus::class)]]);

        $payment->update([
            'status' => $data['status'],
            'paid_at' => $data['status'] === PaymentStatus::Paid->value ? ($payment->paid_at ?? now()) : null,
        ]);

        return back()->with('status', __('admin.saved'));
    }
}
