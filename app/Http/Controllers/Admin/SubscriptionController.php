<?php

namespace App\Http\Controllers\Admin;

use App\Enums\SubscriptionStatus;
use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SubscriptionController extends Controller
{
    public function index(Request $request): View
    {
        $subscriptions = Subscription::with('user', 'plan')
            ->when($request->string('status')->toString(), fn ($q, $s) => $q->where('status', $s))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.subscriptions.index', [
            'subscriptions' => $subscriptions,
            'statuses' => SubscriptionStatus::cases(),
        ]);
    }

    public function create(): View
    {
        return view('admin.subscriptions.create', [
            'users' => User::orderBy('name')->get(),
            'plans' => Plan::all(),
            'statuses' => SubscriptionStatus::cases(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Subscription::create($this->validated($request));

        return redirect()->route('admin.subscriptions.index')->with('status', __('admin.saved'));
    }

    public function show(Subscription $subscription): View
    {
        return view('admin.subscriptions.show', [
            'subscription' => $subscription->load('user', 'plan', 'connections', 'payments'),
        ]);
    }

    public function edit(Subscription $subscription): View
    {
        return view('admin.subscriptions.edit', [
            'subscription' => $subscription,
            'users' => User::orderBy('name')->get(),
            'plans' => Plan::all(),
            'statuses' => SubscriptionStatus::cases(),
        ]);
    }

    public function update(Request $request, Subscription $subscription): RedirectResponse
    {
        $subscription->update($this->validated($request));

        return redirect()->route('admin.subscriptions.index')->with('status', __('admin.saved'));
    }

    public function destroy(Subscription $subscription): RedirectResponse
    {
        $subscription->delete();

        return back()->with('status', __('admin.deleted'));
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'plan_id' => ['required', 'exists:plans,id'],
            'status' => ['required', Rule::enum(SubscriptionStatus::class)],
            'starts_at' => ['nullable', 'date'],
            'ends_at' => ['nullable', 'date'],
            'auto_renew' => ['boolean'],
        ]);

        $data['auto_renew'] = $request->boolean('auto_renew');

        return $data;
    }
}
