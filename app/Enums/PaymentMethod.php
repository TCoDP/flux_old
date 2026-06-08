<?php

namespace App\Enums;

use App\Enums\Concerns\HasLabel;

enum PaymentMethod: string
{
    use HasLabel;

    case Card = 'card';
    case Sbp = 'sbp';
    case Crypto = 'crypto';

    public function icon(): string
    {
        return match ($this) {
            self::Card => 'credit-card',
            self::Sbp => 'bolt',
            self::Crypto => 'currency',
        };
    }
}
