<?php

namespace App\Enums;

use App\Enums\Concerns\HasLabel;

enum PromoType: string
{
    use HasLabel;

    case Percent = 'percent';
    case Fixed = 'fixed';
}
