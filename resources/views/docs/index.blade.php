<x-layouts.docs :seo="$seo" :platforms="$platforms">
    <div>
        <span class="inline-flex items-center gap-2 rounded-full bg-brand-500/10 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-brand-600 dark:text-brand-300">{{ __('docs.eyebrow') }}</span>
        <h1 class="mt-4 text-3xl font-semibold font-display tracking-tight text-ink-900 dark:text-white sm:text-4xl">{{ __('docs.title') }}</h1>
        <p class="mt-3 max-w-2xl text-ink-500 dark:text-ink-300">{{ __('docs.subtitle') }}</p>

        <div class="mt-10 grid gap-4 sm:grid-cols-2">
            @foreach ($platforms as $slug => $icon)
                <x-platform-card :slug="$slug" :icon="$icon" :href="route('docs.platform', ['platform' => $slug])" />
            @endforeach
        </div>
    </div>
</x-layouts.docs>
