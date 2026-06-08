<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PromoType;
use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\PromoCode;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PromoCodeController extends Controller
{
    public function index(): View
    {
        return view('admin.promocodes.index', ['promocodes' => PromoCode::with('plan')->latest()->get()]);
    }

    public function create(): View
    {
        return view('admin.promocodes.create', ['plans' => Plan::all(), 'types' => PromoType::cases()]);
    }

    public function store(Request $request): RedirectResponse
    {
        PromoCode::create($this->validated($request));

        return redirect()->route('admin.promocodes.index')->with('status', __('admin.saved'));
    }

    public function edit(PromoCode $promocode): View
    {
        return view('admin.promocodes.edit', [
            'promocode' => $promocode, 'plans' => Plan::all(), 'types' => PromoType::cases(),
        ]);
    }

    public function update(Request $request, PromoCode $promocode): RedirectResponse
    {
        $promocode->update($this->validated($request, $promocode));

        return redirect()->route('admin.promocodes.index')->with('status', __('admin.saved'));
    }

    public function destroy(PromoCode $promocode): RedirectResponse
    {
        $promocode->delete();

        return back()->with('status', __('admin.deleted'));
    }

    private function validated(Request $request, ?PromoCode $promo = null): array
    {
        $data = $request->validate([
            'code' => ['required', 'string', 'max:32', Rule::unique('promo_codes', 'code')->ignore($promo?->id)],
            'type' => ['required', Rule::enum(PromoType::class)],
            'value' => ['required', 'numeric', 'min:0'],
            'min_amount' => ['nullable', 'numeric', 'min:0'],
            'plan_id' => ['nullable', 'exists:plans,id'],
            'max_uses' => ['nullable', 'integer', 'min:1'],
            'per_user_limit' => ['nullable', 'integer', 'min:1'],
            'starts_at' => ['nullable', 'date'],
            'expires_at' => ['nullable', 'date', 'after_or_equal:starts_at'],
            'is_active' => ['boolean'],
        ]);

        $data['code'] = Str::upper($data['code']);
        $data['is_active'] = $request->boolean('is_active');
        $data['per_user_limit'] = $data['per_user_limit'] ?? 1;

        return $data;
    }
}
