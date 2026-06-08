<?php

namespace App\Enums;

use App\Enums\Concerns\HasLabel;

enum ServerStatus: string
{
    use HasLabel;

    case Online = 'online';
    case Maintenance = 'maintenance';
    case Offline = 'offline';

    public function color(): string
    {
        return match ($this) {
            self::Online => 'success',
            self::Maintenance => 'warning',
            self::Offline => 'danger',
        };
    }
}
