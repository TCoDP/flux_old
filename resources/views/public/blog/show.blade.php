<x-layouts.public :seo="$seo">
    <article class="mx-auto max-w-3xl px-5 py-12 sm:px-8">
        <x-breadcrumbs :items="[['label' => __('nav.blog'), 'href' => route('blog.index')], ['label' => $article->title]]" />

        <div class="mt-6">
            @if ($article->category)<x-badge color="brand">{{ $article->category->name }}</x-badge>@endif
        </div>
        <h1 class="mt-4 text-balance text-3xl font-semibold font-display tracking-tight text-ink-900 dark:text-white sm:text-4xl">{{ $article->title }}</h1>

        <div class="mt-5 flex items-center gap-3 text-sm text-ink-400">
            @if ($article->author)
                <x-avatar :name="$article->author->name" size="h-8 w-8" />
                <span class="text-ink-600 dark:text-ink-300">{{ $article->author->name }}</span>
                <span>·</span>
            @endif
            <span>{{ $article->published_at?->isoFormat('D MMMM YYYY') }}</span>
            <span>·</span>
            <span>{{ $article->reading_minutes }} {{ __('blog.min') }}</span>
        </div>

        <div class="mt-8 aspect-[16/8] overflow-hidden rounded-2xl bg-gradient-to-br from-brand-500/15 to-accent-400/15">
            @if ($article->cover_image)
                <img src="{{ $article->cover_image }}" alt="{{ $article->title }}" class="h-full w-full object-cover" />
            @else
                <div class="flex h-full w-full items-center justify-center text-brand-400/30"><x-icon name="document" class="h-16 w-16" /></div>
            @endif
        </div>

        <div class="prose prose-slate dark:prose-invert mt-10 max-w-none prose-headings:font-display prose-headings:font-semibold prose-a:text-brand-600">
            {!! $article->body !!}
        </div>
    </article>

    @if ($related->isNotEmpty())
        <x-section :title="__('blog.related')">
            <div class="mt-10 grid gap-6 md:grid-cols-3">
                @foreach ($related as $item)
                    <x-article-card :article="$item" />
                @endforeach
            </div>
        </x-section>
    @endif
</x-layouts.public>
