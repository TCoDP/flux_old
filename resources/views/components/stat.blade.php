@props(['value' => '', 'label' => '', 'icon' => null, 'trend' => null])

<div {{ $attributes->merge(['class' => 'rounded-2xl bg-white dark:bg-ink-900/40 ring-hair p-5 shadow-soft']) }}>
    <div class="flex items-center justify-between">
        @if ($icon)
            <span class="grid h-10 w-10 place-items-center rounded-xl bg-brand-500/10 text-brand-600 dark:text-brand-300">
                <x-icon :name="$icon" class="h-5 w-5" />
            </span>
        @endif
        @if ($trend)
            <span class="text-xs font-medium text-emerald-500">{{ $trend }}</span>
        @endif
    </div>
    <p class="mt-3 text-2xl font-semibold font-display tracking-tight text-ink-900 dark:text-white">{{ $value }}</p>
    <p class="mt-1 text-sm text-ink-500 dark:text-ink-400">{{ $label }}</p>
</div>
