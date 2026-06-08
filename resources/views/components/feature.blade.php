@props(['icon' => 'sparkles', 'title' => ''])

<div {{ $attributes->merge(['class' => 'reveal group relative rounded-2xl bg-white dark:bg-ink-900/40 ring-hair p-6 shadow-soft transition-all duration-300 hover:-translate-y-1 hover:shadow-card']) }}>
    <span class="grid h-12 w-12 place-items-center rounded-xl bg-brand-500/10 text-brand-600 dark:text-brand-300 transition-transform duration-300 group-hover:scale-110">
        <x-icon :name="$icon" class="h-6 w-6" />
    </span>
    <h3 class="mt-5 text-lg font-semibold text-ink-900 dark:text-white">{{ $title }}</h3>
    <p class="mt-2 text-sm leading-relaxed text-ink-500 dark:text-ink-400">{{ $slot }}</p>
</div>
