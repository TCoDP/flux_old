<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Docs\DocumentationController;
use App\Http\Middleware\SetLocale;
use App\Models\Article;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $urls = [];

        $routes = ['home', 'about', 'pricing', 'faq', 'contact', 'blog.index', 'legal.privacy', 'legal.terms'];

        foreach (SetLocale::SUPPORTED as $locale) {
            foreach ($routes as $name) {
                $urls[] = ['loc' => route($name, ['locale' => $locale]), 'priority' => $name === 'home' ? '1.0' : '0.7'];
            }

            foreach (array_keys(DocumentationController::PLATFORMS) as $platform) {
                $urls[] = ['loc' => route('docs.platform', ['locale' => $locale, 'platform' => $platform]), 'priority' => '0.6'];
            }

            Article::published()->forLocale($locale)->get()->each(function (Article $article) use (&$urls, $locale) {
                $urls[] = [
                    'loc' => route('blog.show', ['locale' => $locale, 'article' => $article->slug]),
                    'lastmod' => $article->updated_at?->toAtomString(),
                    'priority' => '0.5',
                ];
            });
        }

        return response()
            ->view('sitemap', ['urls' => $urls])
            ->header('Content-Type', 'application/xml');
    }
}
