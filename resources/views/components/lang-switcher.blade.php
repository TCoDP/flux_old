@php
    $locales = ['ru' => 'Русский', 'en' => 'English'];
    $current = app()->getLocale();
@endphp

<x-dropdown align="right" width="w-40">
    <x-slot:trigger>
        <button type="button" class="inline-flex items-center gap-1.5 rounded-xl px-2.5 h-9 text-sm font-medium text-ink-600 hover:bg-ink-100 dark:text-ink-300 dark:hover:bg-white/5 transition">
            <x-icon name="globe" class="h-4.5 w-4.5" />
            <span class="uppercase">{{ $current }}</span>
        </button>
    </x-slot:trigger>

    @foreach ($locales as $code => $label)
        <a href="{{ locale_url($code) }}"
           class="flex items-center justify-between rounded-lg px-3 py-2 text-sm transition {{ $current === $code ? 'bg-brand-500/10 text-brand-600 dark:text-brand-300' : 'text-ink-600 hover:bg-ink-100 dark:text-ink-300 dark:hover:bg-white/5' }}">
            {{ $label }}
            @if ($current === $code)<x-icon name="check" class="h-4 w-4" />@endif
        </a>
    @endforeach
</x-dropdown>
