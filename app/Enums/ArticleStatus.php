<?php

namespace App\Enums;

use App\Enums\Concerns\HasLabel;

enum ArticleStatus: string
{
    use HasLabel;

    case Draft = 'draft';
    case Published = 'published';

    public function color(): string
    {
        return match ($this) {
            self::Published => 'success',
            self::Draft => 'neutral',
        };
    }
}
