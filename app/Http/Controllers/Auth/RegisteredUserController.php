<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Services\ActivityLogger;
use App\Services\ReferralService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register', [
            'seo' => $this->seo('register'),
            'referral' => request()->query('ref'),
        ]);
    }

    public function store(RegisterRequest $request, ReferralService $referrals): RedirectResponse
    {
        $user = User::create([
            'name' => $request->string('name'),
            'email' => $request->string('email'),
            'password' => Hash::make($request->string('password')),
            'locale' => app()->getLocale(),
        ]);

        $referrals->attach($user, $request->input('referral_code'));

        event(new Registered($user));
        Auth::login($user);
        ActivityLogger::log('user.registered', user: $user);

        return redirect()->route('verification.notice');
    }
}
