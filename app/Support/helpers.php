<?php

use App\Services\SettingsService;
use App\Support\Money;

if (! function_exists('settings')) {
    /**
     * Read a project setting (or the whole service when no key is given).
     */
    function settings(?string $key = null, mixed $default = null): mixed
    {
        $service = app(SettingsService::class);

        return $key === null ? $service : $service->get($key, $default);
    }
}

if (! function_exists('format_price')) {
    function format_price(int|float|string|null $amount, string $currency = 'RUB'): string
    {
        return Money::format($amount, $currency);
    }
}

if (! function_exists('locale_url')) {
    /**
     * Build the current URL switched to a different locale (for the language switcher).
     */
    function locale_url(string $locale): string
    {
        $route = request()->route();

        if ($route && in_array('locale', array_keys($route->parameters()), true)) {
            return route($route->getName(), array_merge($route->parameters(), ['locale' => $locale]));
        }

        return route('locale.switch', ['locale' => $locale]);
    }
}
