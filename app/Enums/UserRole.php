<?php

namespace App\Enums;

use App\Enums\Concerns\HasLabel;

enum UserRole: string
{
    use HasLabel;

    case User = 'user';
    case Admin = 'admin';

    public function color(): string
    {
        return match ($this) {
            self::Admin => 'brand',
            self::User => 'neutral',
        };
    }
}
