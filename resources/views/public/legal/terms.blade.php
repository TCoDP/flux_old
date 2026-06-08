<x-layouts.public :seo="$seo">
    <x-page-header :title="__('legal.terms.title')" />

    <div class="mx-auto max-w-3xl px-5 pb-20 sm:px-8">
        <p class="text-lg leading-relaxed text-ink-500 dark:text-ink-300">{{ __('legal.terms.intro') }}</p>
        <p class="mt-3 text-sm text-ink-400">{{ __('legal.updated', ['date' => now()->isoFormat('D MMMM YYYY')]) }}</p>

        <div class="prose prose-slate dark:prose-invert mt-10 max-w-none prose-headings:font-display prose-headings:font-semibold prose-h2:text-xl">
            @foreach (__('legal.terms.sections') as $section)
                <h2>{{ $section['h'] }}</h2>
                <p>{{ $section['b'] }}</p>
            @endforeach
        </div>
    </div>
</x-layouts.public>
