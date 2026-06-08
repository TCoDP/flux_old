<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleCategory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request): View
    {
        $query = Article::query()
            ->published()
            ->forLocale(app()->getLocale())
            ->with('category', 'author')
            ->latest('published_at');

        if ($category = $request->string('category')->toString()) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $category));
        }

        if ($search = $request->string('q')->toString()) {
            $query->where(fn ($q) => $q->where('title', 'like', "%{$search}%")
                ->orWhere('excerpt', 'like', "%{$search}%"));
        }

        return view('public.blog.index', [
            'seo' => $this->seo('blog'),
            'articles' => $query->paginate(9)->withQueryString(),
            'categories' => ArticleCategory::withCount(['articles' => fn ($q) => $q->published()])->get(),
            'activeCategory' => $category,
        ]);
    }

    public function show(string $locale, string $article): View
    {
        $article = Article::where('slug', $article)->firstOrFail();

        abort_unless($article->status->value === 'published', 404);

        $article->increment('views');

        return view('public.blog.show', [
            'seo' => $this->seo('blog', [
                'title' => $article->meta_title ?: $article->title,
                'description' => $article->meta_description ?: $article->excerpt,
                'og_image' => $article->cover_image,
            ]),
            'article' => $article->load('category', 'author'),
            'related' => Article::published()
                ->forLocale(app()->getLocale())
                ->where('id', '!=', $article->id)
                ->when($article->category_id, fn ($q) => $q->where('category_id', $article->category_id))
                ->latest('published_at')
                ->take(3)
                ->get(),
        ]);
    }
}
