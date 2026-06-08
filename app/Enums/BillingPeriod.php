<?php

namespace App\Enums;

use App\Enums\Concerns\HasLabel;

enum BillingPeriod: string
{
    use HasLabel;

    case Month = 'month';
    case Quarter = 'quarter';
    case Year = 'year';

    public function months(): int
    {
        return match ($this) {
            self::Month => 1,
            self::Quarter => 3,
            self::Year => 12,
        };
    }
}
