@props(['article'])

<a href="{{ route('blog.show', $article->slug) }}"
   {{ $attributes->merge(['class' => 'reveal group flex flex-col overflow-hidden rounded-2xl bg-white dark:bg-ink-900/40 ring-hair shadow-soft transition-all duration-300 hover:-translate-y-1 hover:shadow-card']) }}>
    <div class="aspect-[16/9] overflow-hidden bg-gradient-to-br from-brand-500/15 to-accent-400/15">
        @if ($article->cover_image)
            <img src="{{ $article->cover_image }}" alt="{{ $article->title }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-105" />
        @else
            <div class="flex h-full w-full items-center justify-center text-brand-400/40">
                <x-icon name="document" class="h-12 w-12" />
            </div>
        @endif
    </div>
    <div class="flex flex-1 flex-col p-5">
        @if ($article->category)
            <div><x-badge color="brand">{{ $article->category->name }}</x-badge></div>
        @endif
        <h3 class="mt-3 line-clamp-2 text-lg font-semibold text-ink-900 transition group-hover:text-brand-600 dark:text-white dark:group-hover:text-brand-300">{{ $article->title }}</h3>
        <p class="mt-2 line-clamp-2 flex-1 text-sm text-ink-500 dark:text-ink-400">{{ $article->excerpt }}</p>
        <div class="mt-4 flex items-center gap-2 text-xs text-ink-400">
            <span>{{ $article->published_at?->isoFormat('D MMM YYYY') }}</span>
            <span>·</span>
            <span>{{ $article->reading_minutes }} {{ __('blog.min') }}</span>
        </div>
    </div>
</a>
