<?php

namespace App\Enums;

use App\Enums\Concerns\HasLabel;

enum SubscriptionStatus: string
{
    use HasLabel;

    case Pending = 'pending';
    case Trialing = 'trialing';
    case Active = 'active';
    case Expired = 'expired';
    case Canceled = 'canceled';

    public function color(): string
    {
        return match ($this) {
            self::Active => 'success',
            self::Trialing => 'info',
            self::Pending => 'warning',
            self::Expired => 'danger',
            self::Canceled => 'neutral',
        };
    }

    public function isLive(): bool
    {
        return in_array($this, [self::Active, self::Trialing], true);
    }
}
