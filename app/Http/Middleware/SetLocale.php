<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public const SUPPORTED = ['ru', 'en'];

    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->route('locale');

        if (! in_array($locale, self::SUPPORTED, true)) {
            $locale = $request->session()->get('locale');
        }

        if (! in_array($locale, self::SUPPORTED, true)) {
            $locale = $request->getPreferredLanguage(self::SUPPORTED) ?? config('app.locale');
        }

        if (! in_array($locale, self::SUPPORTED, true)) {
            $locale = config('app.locale');
        }

        app()->setLocale($locale);
        \Carbon\Carbon::setLocale($locale);
        $request->session()->put('locale', $locale);

        // Make {locale} an implicit default so route()/url() stay clean across views.
        URL::defaults(['locale' => $locale]);

        return $next($request);
    }
}
