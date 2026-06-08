@props(['name' => null])

@php
    $hasError = $name && $errors->has($name);
    $base = 'w-full appearance-none rounded-xl bg-white dark:bg-ink-900/50 border px-4 py-2.5 pr-10 text-sm text-ink-900 dark:text-white transition outline-none focus:ring-2 '
        .($hasError
            ? 'border-red-400 focus:border-red-400 focus:ring-red-500/20'
            : 'border-ink-200 dark:border-white/10 focus:border-brand-400 focus:ring-brand-500/20');
@endphp

<div class="relative">
    <select @if ($name) name="{{ $name }}" id="{{ $name }}" @endif {{ $attributes->merge(['class' => $base]) }}>
        {{ $slot }}
    </select>
    <x-icon name="chevron-down" class="pointer-events-none absolute right-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-ink-400" />
</div>
