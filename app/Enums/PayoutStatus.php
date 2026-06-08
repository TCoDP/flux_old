<?php

namespace App\Enums;

use App\Enums\Concerns\HasLabel;

enum PayoutStatus: string
{
    use HasLabel;

    case Pending = 'pending';
    case Approved = 'approved';
    case Paid = 'paid';
    case Rejected = 'rejected';

    public function color(): string
    {
        return match ($this) {
            self::Paid => 'success',
            self::Approved => 'info',
            self::Pending => 'warning',
            self::Rejected => 'danger',
        };
    }
}
