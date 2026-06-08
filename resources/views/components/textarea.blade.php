@props(['name' => null, 'rows' => 4])

@php
    $hasError = $name && $errors->has($name);
    $base = 'w-full rounded-xl bg-white dark:bg-ink-900/50 border px-4 py-3 text-sm text-ink-900 dark:text-white placeholder-ink-400 transition outline-none focus:ring-2 '
        .($hasError
            ? 'border-red-400 focus:border-red-400 focus:ring-red-500/20'
            : 'border-ink-200 dark:border-white/10 focus:border-brand-400 focus:ring-brand-500/20');
@endphp

<textarea @if ($name) name="{{ $name }}" id="{{ $name }}" @endif rows="{{ $rows }}"
    {{ $attributes->merge(['class' => $base]) }}>{{ $slot }}</textarea>
