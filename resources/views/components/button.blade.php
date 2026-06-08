@props([
    'variant' => 'primary',
    'size' => 'md',
    'href' => null,
    'icon' => null,
    'iconRight' => null,
    'block' => false,
])

@php
    $base = 'inline-flex items-center justify-center gap-2 font-medium rounded-xl transition-all duration-200 focus-visible:outline-none disabled:opacity-50 disabled:pointer-events-none select-none';

    $sizes = [
        'sm' => 'text-[13px] px-3.5 py-2',
        'md' => 'text-sm px-5 py-2.5',
        'lg' => 'text-base px-6 py-3.5',
    ];

    $variants = [
        'primary' => 'bg-brand-gradient text-white shadow-glow hover:brightness-110 hover:-translate-y-0.5 active:translate-y-0',
        'secondary' => 'glass text-ink-900 dark:text-white hover:shadow-soft ring-hair',
        'outline' => 'border border-ink-200 text-ink-800 hover:border-brand-400 hover:text-brand-600 dark:border-white/10 dark:text-ink-100 dark:hover:border-brand-400',
        'ghost' => 'text-ink-600 hover:bg-ink-100 hover:text-ink-900 dark:text-ink-300 dark:hover:bg-white/5 dark:hover:text-white',
        'white' => 'bg-white text-ink-900 shadow-soft hover:-translate-y-0.5',
        'danger' => 'bg-red-500 text-white hover:bg-red-600 shadow-soft',
    ];

    $classes = implode(' ', [$base, $sizes[$size] ?? $sizes['md'], $variants[$variant] ?? $variants['primary'], $block ? 'w-full' : '']);
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if ($icon)<x-icon :name="$icon" class="h-[1.1em] w-[1.1em]" />@endif
        {{ $slot }}
        @if ($iconRight)<x-icon :name="$iconRight" class="h-[1.1em] w-[1.1em]" />@endif
    </a>
@else
    <button {{ $attributes->merge(['class' => $classes, 'type' => 'button']) }}>
        @if ($icon)<x-icon :name="$icon" class="h-[1.1em] w-[1.1em]" />@endif
        {{ $slot }}
        @if ($iconRight)<x-icon :name="$iconRight" class="h-[1.1em] w-[1.1em]" />@endif
    </button>
@endif
