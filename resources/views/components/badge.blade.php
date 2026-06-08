@props(['color' => 'neutral', 'size' => 'md', 'dot' => false])

@php
    $colors = [
        'brand' => 'bg-brand-500/10 text-brand-600 dark:text-brand-300 ring-brand-500/20',
        'success' => 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-300 ring-emerald-500/20',
        'warning' => 'bg-amber-500/10 text-amber-600 dark:text-amber-300 ring-amber-500/20',
        'danger' => 'bg-red-500/10 text-red-600 dark:text-red-300 ring-red-500/20',
        'info' => 'bg-sky-500/10 text-sky-600 dark:text-sky-300 ring-sky-500/20',
        'neutral' => 'bg-ink-500/10 text-ink-600 dark:text-ink-300 ring-ink-500/20',
    ];

    $dots = [
        'brand' => 'bg-brand-500', 'success' => 'bg-emerald-500', 'warning' => 'bg-amber-500',
        'danger' => 'bg-red-500', 'info' => 'bg-sky-500', 'neutral' => 'bg-ink-400',
    ];

    $sizing = $size === 'sm' ? 'text-[11px] px-2 py-0.5' : 'text-xs px-2.5 py-1';
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center gap-1.5 font-medium rounded-full ring-1 ring-inset whitespace-nowrap '.($colors[$color] ?? $colors['neutral']).' '.$sizing]) }}>
    @if ($dot)<span class="h-1.5 w-1.5 rounded-full {{ $dots[$color] ?? $dots['neutral'] }}"></span>@endif
    {{ $slot }}
</span>
