<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PaymentController extends Controller
{
    public function index(Request $request): View
    {
        return view('dashboard.payments.index', [
            'payments' => $request->user()->payments()->with('plan')->latest()->paginate(12),
        ]);
    }

    public function show(Request $request, Payment $payment): View
    {
        abort_unless($payment->user_id === $request->user()->id, 403);

        return view('dashboard.payments.show', [
            'payment' => $payment->load('plan', 'subscription', 'promoCode'),
        ]);
    }

    public function invoice(Request $request, Payment $payment): Response
    {
        abort_unless($payment->user_id === $request->user()->id, 403);

        return response()
            ->view('dashboard.payments.invoice', ['payment' => $payment->load('plan', 'user')])
            ->header('Content-Type', 'text/html; charset=utf-8');
    }
}
