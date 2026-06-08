<?php

namespace App\Support;

class Money
{
    private const SYMBOLS = [
        'RUB' => '₽',
        'USD' => '$',
        'EUR' => '€',
    ];

    public static function format(int|float|string|null $amount, string $currency = 'RUB'): string
    {
        $value = (float) $amount;
        $formatted = number_format($value, self::hasFraction($value) ? 2 : 0, ',', ' ');
        $symbol = self::SYMBOLS[$currency] ?? $currency;

        return trim("{$formatted} {$symbol}");
    }

    public static function symbol(string $currency = 'RUB'): string
    {
        return self::SYMBOLS[$currency] ?? $currency;
    }

    private static function hasFraction(float $value): bool
    {
        return fmod($value, 1.0) !== 0.0;
    }
}
