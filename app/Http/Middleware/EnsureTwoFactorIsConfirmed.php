<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Guards against reaching authenticated areas while a two-factor login is
 * still pending in the session (the credentials passed, but the second
 * factor has not yet been confirmed).
 */
class EnsureTwoFactorIsConfirmed
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->session()->has('login.id')) {
            return redirect()->route('two-factor.login');
        }

        return $next($request);
    }
}
