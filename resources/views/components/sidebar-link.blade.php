@props(['href' => '#', 'icon' => 'sparkles', 'active' => false])

<a href="{{ $href }}"
   {{ $attributes->merge(['class' => 'group flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm font-medium transition '.($active
        ? 'bg-brand-500/10 text-brand-700 dark:text-brand-200 ring-1 ring-brand-500/15'
        : 'text-ink-500 hover:bg-ink-100 hover:text-ink-900 dark:text-ink-400 dark:hover:bg-white/5 dark:hover:text-white')]) }}>
    <x-icon :name="$icon" class="h-5 w-5 shrink-0 {{ $active ? 'text-brand-500' : '' }}" />
    <span class="truncate">{{ $slot }}</span>
</a>
