@props(['href' => '#', 'active' => false])

<a href="{{ $href }}"
   {{ $attributes->merge(['class' => 'relative text-sm font-medium transition-colors '.($active
        ? 'text-ink-900 dark:text-white'
        : 'text-ink-500 hover:text-ink-900 dark:text-ink-300 dark:hover:text-white')]) }}>
    {{ $slot }}
    @if ($active)
        <span class="absolute -bottom-1.5 left-0 right-0 mx-auto h-0.5 w-5 rounded-full bg-brand-gradient"></span>
    @endif
</a>
