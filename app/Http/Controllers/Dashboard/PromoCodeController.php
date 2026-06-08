<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\PromoType;
use App\Http\Controllers\Controller;
use App\Models\PromoCode;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PromoCodeController extends Controller
{
    public function index(Request $request): View
    {
        return view('dashboard.promocodes', [
            'redeemed' => $request->user()->payments()
                ->whereNotNull('promo_code_id')
                ->with('promoCode')
                ->latest()
                ->get(),
        ]);
    }

    public function redeem(Request $request): RedirectResponse
    {
        $data = $request->validate(['code' => ['required', 'string', 'max:32']]);

        $promo = PromoCode::where('code', $data['code'])->first();

        if (! $promo || ! $promo->isValid()) {
            return back()->withErrors(['code' => __('dashboard.promocodes.invalid')]);
        }

        // Fixed-value codes top up the wallet directly; percentage codes apply at checkout.
        if ($promo->type === PromoType::Fixed) {
            $request->user()->increment('balance', (float) $promo->value);
            $promo->increment('used_count');

            return back()->with('status', __('dashboard.promocodes.credited'));
        }

        $request->session()->put('promo_code', $promo->code);

        return back()->with('status', __('dashboard.promocodes.saved_for_checkout'));
    }
}
