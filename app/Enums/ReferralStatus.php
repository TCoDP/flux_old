<?php

namespace App\Enums;

use App\Enums\Concerns\HasLabel;

enum ReferralStatus: string
{
    use HasLabel;

    case Pending = 'pending';
    case Confirmed = 'confirmed';
    case Rewarded = 'rewarded';

    public function color(): string
    {
        return match ($this) {
            self::Rewarded => 'success',
            self::Confirmed => 'info',
            self::Pending => 'warning',
        };
    }
}
