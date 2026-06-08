<x-layouts.public :seo="$seo">
    <x-page-header :eyebrow="__('blog.eyebrow')" :title="__('blog.title')" :subtitle="__('blog.subtitle')" />

    <div class="mx-auto max-w-7xl px-5 pb-20 sm:px-8">
        {{-- Filters --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('blog.index') }}"
                   class="rounded-full px-4 py-1.5 text-sm font-medium transition {{ ! $activeCategory ? 'bg-brand-gradient text-white' : 'bg-ink-100 text-ink-600 hover:bg-ink-200 dark:bg-white/5 dark:text-ink-300' }}">
                    {{ __('blog.all_categories') }}
                </a>
                @foreach ($categories as $cat)
                    <a href="{{ route('blog.index', ['category' => $cat->slug]) }}"
                       class="rounded-full px-4 py-1.5 text-sm font-medium transition {{ $activeCategory === $cat->slug ? 'bg-brand-gradient text-white' : 'bg-ink-100 text-ink-600 hover:bg-ink-200 dark:bg-white/5 dark:text-ink-300' }}">
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>
            <form method="GET" action="{{ route('blog.index') }}" class="w-full sm:w-64">
                <x-input name="q" :value="request('q')" :placeholder="__('blog.search_placeholder')" icon="search" />
            </form>
        </div>

        @if ($articles->count())
            <div class="mt-10 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($articles as $article)
                    <x-article-card :article="$article" />
                @endforeach
            </div>
            <div class="mt-12">{{ $articles->links() }}</div>
        @else
            <x-empty-state class="mt-10" icon="document" :title="__('blog.empty')" />
        @endif
    </div>
</x-layouts.public>
