<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SeoSetting;
use App\Services\SeoService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SeoSettingController extends Controller
{
    /** Pages that expose SEO overrides. */
    public const PAGES = ['home', 'about', 'pricing', 'faq', 'contact', 'blog', 'docs', 'privacy', 'terms'];

    public function edit(): View
    {
        $existing = SeoSetting::all()->keyBy(fn ($s) => $s->page.'.'.$s->locale);

        return view('admin.seo', [
            'pages' => self::PAGES,
            'locales' => ['ru', 'en'],
            'existing' => $existing,
        ]);
    }

    public function update(Request $request, SeoService $seo): RedirectResponse
    {
        $payload = $request->input('seo', []);

        foreach ($payload as $page => $locales) {
            if (! in_array($page, self::PAGES, true)) {
                continue;
            }

            foreach ($locales as $locale => $fields) {
                if (! in_array($locale, ['ru', 'en'], true)) {
                    continue;
                }

                SeoSetting::updateOrCreate(
                    ['page' => $page, 'locale' => $locale],
                    [
                        'title' => $fields['title'] ?? null,
                        'description' => $fields['description'] ?? null,
                        'keywords' => $fields['keywords'] ?? null,
                        'og_image' => $fields['og_image'] ?? null,
                    ],
                );
            }
        }

        $seo->flush();

        return back()->with('status', __('admin.saved'));
    }
}
