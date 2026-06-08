<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ArticleStatus;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleCategory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ArticleController extends Controller
{
    public function index(): View
    {
        return view('admin.articles.index', [
            'articles' => Article::with('category', 'author')->latest()->paginate(15),
        ]);
    }

    public function create(): View
    {
        return view('admin.articles.create', [
            'categories' => ArticleCategory::all(),
            'statuses' => ArticleStatus::cases(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Article::create($this->validated($request) + ['author_id' => $request->user()->id]);

        return redirect()->route('admin.articles.index')->with('status', __('admin.saved'));
    }

    public function show(Article $article): RedirectResponse
    {
        return redirect()->route('admin.articles.edit', $article);
    }

    public function edit(Article $article): View
    {
        return view('admin.articles.edit', [
            'article' => $article,
            'categories' => ArticleCategory::all(),
            'statuses' => ArticleStatus::cases(),
        ]);
    }

    public function update(Request $request, Article $article): RedirectResponse
    {
        $article->update($this->validated($request, $article));

        return redirect()->route('admin.articles.index')->with('status', __('admin.saved'));
    }

    public function destroy(Article $article): RedirectResponse
    {
        $article->delete();

        return back()->with('status', __('admin.deleted'));
    }

    private function validated(Request $request, ?Article $article = null): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:190'],
            'slug' => ['nullable', 'string', Rule::unique('articles', 'slug')->ignore($article?->id)],
            'category_id' => ['nullable', 'exists:article_categories,id'],
            'locale' => ['required', 'in:ru,en'],
            'cover_image' => ['nullable', 'string', 'max:255'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'body' => ['nullable', 'string'],
            'status' => ['required', Rule::enum(ArticleStatus::class)],
            'reading_minutes' => ['nullable', 'integer', 'min:1'],
            'meta_title' => ['nullable', 'string', 'max:190'],
            'meta_description' => ['nullable', 'string', 'max:300'],
            'published_at' => ['nullable', 'date'],
        ]);

        $data['slug'] = $data['slug'] ?? Str::slug($data['title']);
        $data['reading_minutes'] = $data['reading_minutes'] ?? 5;

        if ($data['status'] === ArticleStatus::Published->value && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        return $data;
    }
}
