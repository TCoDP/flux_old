<?php

namespace App\Services;

use App\Models\SeoSetting;
use Illuminate\Support\Facades\Cache;

class SeoService
{
    public function __construct(private readonly SettingsService $settings) {}

    /**
     * Resolve SEO meta for a page key in the current locale, merging
     * per-page overrides from the database with project defaults.
     *
     * @param  array<string, mixed>  $overrides
     * @return array<string, mixed>
     */
    public function for(string $page, array $overrides = []): array
    {
        $locale = app()->getLocale();
        $siteName = (string) $this->settings->get('site_name', 'Flux');

        $stored = Cache::rememberForever("flux.seo.{$page}.{$locale}", function () use ($page, $locale) {
            return SeoSetting::where('page', $page)->where('locale', $locale)->first();
        });

        $defaults = [
            'title' => $siteName,
            'description' => (string) $this->settings->get('site_tagline'),
            'keywords' => null,
            'og_image' => asset('images/og-default.svg'),
            'schema' => null,
        ];

        $resolved = array_merge(
            $defaults,
            array_filter([
                'title' => $stored?->title,
                'description' => $stored?->description,
                'keywords' => $stored?->keywords,
                'og_image' => $stored?->og_image,
                'schema' => $stored?->schema,
            ]),
            array_filter($overrides, fn ($v) => $v !== null),
        );

        $resolved['site_name'] = $siteName;
        $resolved['canonical'] = url()->current();
        $resolved['full_title'] = $resolved['title'] === $siteName
            ? $siteName
            : "{$resolved['title']} — {$siteName}";

        return $resolved;
    }

    public function flush(): void
    {
        Cache::flush();
    }
}
