@props(['align' => 'right', 'width' => 'w-56'])

@php
    $alignment = $align === 'left' ? 'left-0 origin-top-left' : 'right-0 origin-top-right';
@endphp

<div x-data="{ open: false }" class="relative" @keydown.escape.window="open = false">
    <div @click="open = ! open">{{ $trigger }}</div>

    <div x-show="open" x-cloak @click.outside="open = false"
         x-transition:enter="transition ease-out duration-150"
         x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         class="absolute z-50 mt-2 {{ $width }} {{ $alignment }} rounded-xl glass-strong p-1.5 shadow-card">
        {{ $slot }}
    </div>
</div>
