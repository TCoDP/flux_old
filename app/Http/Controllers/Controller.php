<?php

namespace App\Http\Controllers;

use App\Services\SeoService;

abstract class Controller
{
    /**
     * Resolve SEO meta for a page in the current locale.
     *
     * @param  array<string, mixed>  $overrides
     * @return array<string, mixed>
     */
    protected function seo(string $page, array $overrides = []): array
    {
        return app(SeoService::class)->for($page, $overrides);
    }
}
