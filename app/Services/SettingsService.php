<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingsService
{
    private const CACHE_KEY = 'flux.settings';

    /** @var array<string, mixed>|null */
    private ?array $cache = null;

    /** Sensible defaults so the site renders before anything is configured. */
    public function defaults(): array
    {
        return [
            'site_name' => 'Flux',
            'site_tagline' => 'Защищённое соединение и приватный доступ в интернет',
            'support_email' => 'support@flux.local',
            'support_telegram' => 'https://t.me/flux',
            'support_phone' => '8 800 000-00-00',
            'company_legal' => 'ООО «Флакс»',
            'company_inn' => '0000000000',
            'servers_count' => '180',
            'regions_count' => '42',
            'users_count' => '120 000',
            'uptime' => '99.98',
        ];
    }

    /** @return array<string, mixed> */
    public function all(): array
    {
        if ($this->cache !== null) {
            return $this->cache;
        }

        $stored = Cache::rememberForever(self::CACHE_KEY, function () {
            return Setting::all()->mapWithKeys(fn (Setting $s) => [$s->key => $s->castedValue()])->all();
        });

        return $this->cache = array_merge($this->defaults(), $stored);
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->all()[$key] ?? $default;
    }

    public function set(string $key, mixed $value, string $type = 'string', string $group = 'general'): void
    {
        Setting::updateOrCreate(
            ['key' => $key],
            ['value' => is_array($value) ? json_encode($value) : $value, 'type' => $type, 'group' => $group],
        );

        $this->flush();
    }

    public function flush(): void
    {
        $this->cache = null;
        Cache::forget(self::CACHE_KEY);
    }
}
