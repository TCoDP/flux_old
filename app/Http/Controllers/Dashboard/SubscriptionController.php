<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index(Request $request): View
    {
        return view('dashboard.subscriptions.index', [
            'subscriptions' => $request->user()->subscriptions()->with('plan')->latest()->get(),
        ]);
    }

    public function show(Request $request, Subscription $subscription): View
    {
        abort_unless($subscription->user_id === $request->user()->id, 403);

        return view('dashboard.subscriptions.show', [
            'subscription' => $subscription->load('plan', 'connections.server.region', 'payments'),
        ]);
    }
}
