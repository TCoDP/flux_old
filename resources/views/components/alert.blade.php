@props(['type' => 'info', 'title' => null, 'dismissible' => true])

@php
    $map = [
        'success' => ['icon' => 'check-circle', 'class' => 'bg-emerald-500/10 text-emerald-700 dark:text-emerald-300 ring-emerald-500/20'],
        'error' => ['icon' => 'x', 'class' => 'bg-red-500/10 text-red-700 dark:text-red-300 ring-red-500/20'],
        'warning' => ['icon' => 'bolt', 'class' => 'bg-amber-500/10 text-amber-700 dark:text-amber-300 ring-amber-500/20'],
        'info' => ['icon' => 'sparkles', 'class' => 'bg-sky-500/10 text-sky-700 dark:text-sky-300 ring-sky-500/20'],
    ];
    $cfg = $map[$type] ?? $map['info'];
@endphp

<div x-data="{ show: true }" x-show="show" x-transition
     {{ $attributes->merge(['class' => 'flex items-start gap-3 rounded-xl ring-1 ring-inset px-4 py-3 text-sm '.$cfg['class']]) }}>
    <x-icon :name="$cfg['icon']" class="mt-0.5 h-5 w-5 shrink-0" />
    <div class="flex-1">
        @if ($title)<p class="font-semibold">{{ $title }}</p>@endif
        <div class="{{ $title ? 'mt-0.5 opacity-90' : '' }}">{{ $slot }}</div>
    </div>
    @if ($dismissible)
        <button type="button" @click="show = false" class="opacity-50 hover:opacity-100 transition">
            <x-icon name="x" class="h-4 w-4" />
        </button>
    @endif
</div>
