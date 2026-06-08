<?php

namespace App\Http\Controllers\Admin;

use App\Enums\BillingPeriod;
use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PlanController extends Controller
{
    public function index(): View
    {
        return view('admin.plans.index', ['plans' => Plan::orderBy('sort_order')->get()]);
    }

    public function create(): View
    {
        return view('admin.plans.create', ['periods' => BillingPeriod::cases()]);
    }

    public function store(Request $request): RedirectResponse
    {
        Plan::create($this->validated($request));

        return redirect()->route('admin.plans.index')->with('status', __('admin.saved'));
    }

    public function edit(Plan $plan): View
    {
        return view('admin.plans.edit', ['plan' => $plan, 'periods' => BillingPeriod::cases()]);
    }

    public function update(Request $request, Plan $plan): RedirectResponse
    {
        $plan->update($this->validated($request, $plan));

        return redirect()->route('admin.plans.index')->with('status', __('admin.saved'));
    }

    public function destroy(Plan $plan): RedirectResponse
    {
        $plan->delete();

        return back()->with('status', __('admin.deleted'));
    }

    private function validated(Request $request, ?Plan $plan = null): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'slug' => ['nullable', 'string', 'max:120', Rule::unique('plans', 'slug')->ignore($plan?->id)],
            'tagline' => ['nullable', 'string', 'max:160'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'old_price' => ['nullable', 'numeric', 'min:0'],
            'billing_period' => ['required', Rule::enum(BillingPeriod::class)],
            'device_limit' => ['required', 'integer', 'min:1', 'max:100'],
            'trial_days' => ['nullable', 'integer', 'min:0'],
            'features' => ['nullable', 'string'],
            'is_popular' => ['boolean'],
            'is_active' => ['boolean'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);
        $data['billing_months'] = BillingPeriod::from($data['billing_period'])->months();
        $data['features'] = collect(explode("\n", (string) $request->input('features')))
            ->map(fn ($l) => trim($l))->filter()->values()->all();
        $data['is_popular'] = $request->boolean('is_popular');
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }
}
