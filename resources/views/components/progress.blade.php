@props(['value' => 0, 'color' => 'brand'])

@php
    $value = max(0, min(100, (int) $value));
    $fills = [
        'brand' => 'bg-brand-gradient',
        'success' => 'bg-emerald-500',
        'warning' => 'bg-amber-500',
        'danger' => 'bg-red-500',
    ];
@endphp

<div {{ $attributes->merge(['class' => 'h-2 w-full overflow-hidden rounded-full bg-ink-100 dark:bg-white/10']) }}>
    <div class="h-full rounded-full transition-all duration-500 {{ $fills[$color] ?? $fills['brand'] }}" style="width: {{ $value }}%"></div>
</div>
