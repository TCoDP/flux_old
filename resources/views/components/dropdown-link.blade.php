@props(['href' => '#', 'icon' => null, 'active' => false])

<a href="{{ $href }}" {{ $attributes->merge(['class' => 'flex items-center gap-2.5 rounded-lg px-3 py-2 text-sm transition '.($active ? 'bg-brand-500/10 text-brand-600 dark:text-brand-300' : 'text-ink-600 hover:bg-ink-100 hover:text-ink-900 dark:text-ink-300 dark:hover:bg-white/5 dark:hover:text-white')]) }}>
    @if ($icon)<x-icon :name="$icon" class="h-4.5 w-4.5" />@endif
    {{ $slot }}
</a>
