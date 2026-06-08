<button type="button" @click="$store.theme.toggle()"
        {{ $attributes->merge(['class' => 'relative grid h-9 w-9 place-items-center rounded-xl text-ink-500 hover:text-ink-900 hover:bg-ink-100 dark:text-ink-300 dark:hover:text-white dark:hover:bg-white/5 transition']) }}
        :aria-label="$store.theme.isDark ? '{{ __('common.light_theme') }}' : '{{ __('common.dark_theme') }}'">
    <x-icon name="sun" class="h-5 w-5" x-show="$store.theme.isDark" x-cloak />
    <x-icon name="moon" class="h-5 w-5" x-show="!$store.theme.isDark" x-cloak />
</button>
