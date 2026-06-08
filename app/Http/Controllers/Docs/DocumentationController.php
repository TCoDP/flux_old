<?php

namespace App\Http\Controllers\Docs;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class DocumentationController extends Controller
{
    /** Platform slug => icon name. Order defines the docs navigation. */
    public const PLATFORMS = [
        'windows' => 'windows',
        'macos' => 'apple',
        'linux' => 'linux',
        'android' => 'android',
        'ios' => 'apple',
        'android-tv' => 'tv',
        'smart-tv' => 'tv',
        'routers' => 'router',
    ];

    public function index(): View
    {
        return view('docs.index', [
            'seo' => $this->seo('docs'),
            'platforms' => self::PLATFORMS,
        ]);
    }

    public function platform(string $locale, string $platform): View
    {
        abort_unless(array_key_exists($platform, self::PLATFORMS), 404);

        return view('docs.platform', [
            'seo' => $this->seo('docs', [
                'title' => __('docs.platforms.'.$platform.'.name'),
            ]),
            'platform' => $platform,
            'icon' => self::PLATFORMS[$platform],
            'platforms' => self::PLATFORMS,
        ]);
    }
}
