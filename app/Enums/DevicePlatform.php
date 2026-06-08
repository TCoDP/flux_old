<?php

namespace App\Enums;

use App\Enums\Concerns\HasLabel;

enum DevicePlatform: string
{
    use HasLabel;

    case Windows = 'windows';
    case MacOS = 'macos';
    case Linux = 'linux';
    case Android = 'android';
    case iOS = 'ios';
    case AndroidTV = 'androidtv';
    case SmartTV = 'smarttv';
    case Router = 'router';

    /** Documentation slug for this platform. */
    public function docsSlug(): string
    {
        return match ($this) {
            self::Windows => 'windows',
            self::MacOS => 'macos',
            self::Linux => 'linux',
            self::Android => 'android',
            self::iOS => 'ios',
            self::AndroidTV => 'android-tv',
            self::SmartTV => 'smart-tv',
            self::Router => 'routers',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::Windows => 'windows',
            self::MacOS => 'apple',
            self::Linux => 'linux',
            self::Android => 'android',
            self::iOS => 'apple',
            self::AndroidTV => 'tv',
            self::SmartTV => 'tv',
            self::Router => 'router',
        };
    }
}
