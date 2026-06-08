<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\ActivityLogger;
use App\Services\TwoFactorService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class TwoFactorChallengeController extends Controller
{
    public function create(Request $request): View|RedirectResponse
    {
        if (! $request->session()->has('login.id')) {
            return redirect()->route('login');
        }

        return view('auth.two-factor-challenge', ['seo' => $this->seo('login')]);
    }

    public function store(Request $request, TwoFactorService $twoFactor): RedirectResponse
    {
        $userId = $request->session()->get('login.id');

        if (! $userId || ! ($user = User::find($userId))) {
            return redirect()->route('login');
        }

        $request->validate([
            'code' => ['nullable', 'string'],
            'recovery_code' => ['nullable', 'string'],
        ]);

        $passed = false;

        if ($code = $request->input('code')) {
            $passed = $twoFactor->verify($user->two_factor_secret, $code);
        } elseif ($recovery = $request->input('recovery_code')) {
            $codes = $user->two_factor_recovery_codes ?? [];
            if (in_array($recovery, $codes, true)) {
                $passed = true;
                $user->forceFill([
                    'two_factor_recovery_codes' => array_values(array_diff($codes, [$recovery])),
                ])->save();
            }
        }

        if (! $passed) {
            throw ValidationException::withMessages(['code' => __('auth.two_factor_invalid')]);
        }

        $remember = (bool) $request->session()->pull('login.remember', false);
        $request->session()->forget('login.id');

        Auth::login($user, $remember);
        $request->session()->regenerate();
        $request->session()->put('auth.2fa_confirmed', true);
        $user->forceFill(['last_login_at' => now(), 'last_login_ip' => $request->ip()])->save();
        ActivityLogger::log('user.login.2fa', user: $user);

        return redirect()->intended(route('dashboard.home'));
    }
}
