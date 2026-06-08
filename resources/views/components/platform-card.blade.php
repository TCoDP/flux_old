@props(['slug' => 'windows', 'icon' => 'windows', 'href' => '#'])

<a href="{{ $href }}"
   {{ $attributes->merge(['class' => 'group flex items-center gap-4 rounded-2xl bg-white dark:bg-ink-900/40 ring-hair p-5 shadow-soft transition-all duration-300 hover:-translate-y-1 hover:shadow-card']) }}>
    <span class="grid h-12 w-12 place-items-center rounded-xl bg-ink-50 dark:bg-white/5 text-ink-700 dark:text-ink-100 transition group-hover:bg-brand-500/10 group-hover:text-brand-600 dark:group-hover:text-brand-300">
        <x-icon :name="$icon" class="h-6 w-6" />
    </span>
    <div class="flex-1">
        <p class="font-semibold text-ink-900 dark:text-white">{{ __('docs.platforms.'.$slug.'.name') }}</p>
        <p class="text-xs text-ink-400">{{ __('docs.setup_time') }}</p>
    </div>
    <x-icon name="arrow-right" class="h-5 w-5 text-ink-300 transition group-hover:translate-x-1 group-hover:text-brand-500" />
</a>
