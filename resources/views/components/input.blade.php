@props(['name' => null, 'type' => 'text', 'icon' => null])

@php
    $hasError = $name && $errors->has($name);
    $base = 'w-full rounded-xl bg-white dark:bg-ink-900/50 border px-4 py-2.5 text-sm text-ink-900 dark:text-white placeholder-ink-400 transition outline-none focus:ring-2 '
        .($hasError
            ? 'border-red-400 focus:border-red-400 focus:ring-red-500/20'
            : 'border-ink-200 dark:border-white/10 focus:border-brand-400 focus:ring-brand-500/20');
@endphp

@if ($icon)
    <div class="relative">
        <x-icon :name="$icon" class="pointer-events-none absolute left-3.5 top-1/2 h-4.5 w-4.5 -translate-y-1/2 text-ink-400" />
        <input type="{{ $type }}" @if ($name) name="{{ $name }}" id="{{ $name }}" @endif
            {{ $attributes->merge(['class' => $base.' !pl-11']) }} />
    </div>
@else
    <input type="{{ $type }}" @if ($name) name="{{ $name }}" id="{{ $name }}" @endif
        {{ $attributes->merge(['class' => $base]) }} />
@endif
