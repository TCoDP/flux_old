@props(['withText' => true, 'class' => ''])

<a href="{{ route('home') }}" {{ $attributes->merge(['class' => 'inline-flex items-center gap-2.5 group '.$class]) }}>
    <span class="relative grid h-9 w-9 place-items-center rounded-xl bg-brand-gradient text-white shadow-glow transition-transform duration-300 group-hover:scale-105">
        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M13 2 4.5 13.5H11l-1 8.5 9-12h-6.5l.5-8Z" fill="currentColor" stroke="none" opacity="0.95"/>
        </svg>
    </span>
    @if ($withText)
        <span class="text-lg font-semibold font-display tracking-tight text-ink-900 dark:text-white">{{ settings('site_name', 'Flux') }}</span>
    @endif
</a>
