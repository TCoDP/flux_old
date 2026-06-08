<?php

namespace App\Enums\Concerns;

use Illuminate\Support\Str;

/**
 * Shared helpers for backed enums: localized labels, select options and
 * a quick value list. Labels resolve from lang/{locale}/enums.php using the
 * snake-cased enum name as the group key.
 */
trait HasLabel
{
    public function label(): string
    {
        $group = Str::snake(class_basename(static::class));

        return __("enums.{$group}.{$this->value}");
    }

    /**
     * @return array<int, array{value: string, label: string}>
     */
    public static function options(): array
    {
        return array_map(
            fn (self $case) => ['value' => $case->value, 'label' => $case->label()],
            self::cases(),
        );
    }

    /**
     * @return array<int, string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
