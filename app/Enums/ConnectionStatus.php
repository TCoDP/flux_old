<?php

namespace App\Enums;

use App\Enums\Concerns\HasLabel;

enum ConnectionStatus: string
{
    use HasLabel;

    case Active = 'active';
    case Paused = 'paused';
    case Revoked = 'revoked';

    public function color(): string
    {
        return match ($this) {
            self::Active => 'success',
            self::Paused => 'warning',
            self::Revoked => 'danger',
        };
    }
}
