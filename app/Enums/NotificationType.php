<?php

namespace App\Enums;

use App\Enums\Concerns\HasLabel;

enum NotificationType: string
{
    use HasLabel;

    case System = 'system';
    case Billing = 'billing';
    case Security = 'security';
    case Promo = 'promo';

    public function icon(): string
    {
        return match ($this) {
            self::System => 'bell',
            self::Billing => 'credit-card',
            self::Security => 'shield',
            self::Promo => 'gift',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::System => 'neutral',
            self::Billing => 'info',
            self::Security => 'danger',
            self::Promo => 'brand',
        };
    }
}
