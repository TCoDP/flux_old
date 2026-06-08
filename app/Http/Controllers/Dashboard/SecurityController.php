<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\ActivityLogger;
use App\Services\TwoFactorService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password as PasswordRule;

class SecurityController extends Controller
{
    public function edit(Request $request, TwoFactorService $twoFactor): View
    {
        $user = $request->user();
        $setup = null;

        if ($secret = $request->session()->get('2fa.secret')) {
            $setup = [
                'secret' => $secret,
                'qr' => $twoFactor->qrSvg($twoFactor->otpauthUrl($user, $secret)),
                'recovery' => $request->session()->get('2fa.recovery', []),
            ];
        }

        return view('dashboard.security', [
            'user' => $user,
            'setup' => $setup,
            'sessions' => $request->user()->activityLogs()
                ->whereIn('action', ['user.login', 'user.login.2fa'])
                ->latest()
                ->take(6)
                ->get(),
        ]);
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', PasswordRule::defaults()],
        ]);

        $request->user()->update(['password' => Hash::make($request->string('password'))]);
        ActivityLogger::log('user.password.changed');

        return back()->with('status', __('dashboard.security.password_updated'));
    }

    public function enableTwoFactor(Request $request, TwoFactorService $twoFactor): RedirectResponse
    {
        $request->session()->put('2fa.secret', $twoFactor->generateSecret());
        $request->session()->put('2fa.recovery', $twoFactor->recoveryCodes());

        return back();
    }

    public function confirmTwoFactor(Request $request, TwoFactorService $twoFactor): RedirectResponse
    {
        $request->validate(['code' => ['required', 'string']]);

        $secret = $request->session()->get('2fa.secret');

        if (! $secret || ! $twoFactor->verify($secret, $request->string('code'))) {
            return back()->withErrors(['code' => __('auth.two_factor_invalid')]);
        }

        $request->user()->forceFill([
            'two_factor_secret' => $secret,
            'two_factor_recovery_codes' => $request->session()->get('2fa.recovery'),
            'two_factor_confirmed_at' => now(),
        ])->save();

        $request->session()->forget(['2fa.secret', '2fa.recovery']);
        $request->session()->put('auth.2fa_confirmed', true);
        ActivityLogger::log('user.2fa.enabled');

        return back()->with('status', __('dashboard.security.two_factor_enabled'));
    }

    public function disableTwoFactor(Request $request): RedirectResponse
    {
        $request->validate(['password' => ['required', 'current_password']]);

        $request->user()->forceFill([
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'two_factor_confirmed_at' => null,
        ])->save();

        ActivityLogger::log('user.2fa.disabled');

        return back()->with('status', __('dashboard.security.two_factor_disabled'));
    }
}
