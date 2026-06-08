@props(['question' => ''])

<div x-data="{ open: false }" class="reveal border-b border-ink-200/70 dark:border-white/10">
    <button type="button" @click="open = ! open"
            class="flex w-full items-center justify-between gap-4 py-5 text-left">
        <span class="text-base font-medium text-ink-900 dark:text-white">{{ $question }}</span>
        <span class="grid h-8 w-8 shrink-0 place-items-center rounded-full bg-ink-100 dark:bg-white/5 transition-transform duration-300"
              :class="open && 'rotate-45'">
            <x-icon name="plus" class="h-4 w-4 text-ink-500 dark:text-ink-300" />
        </span>
    </button>
    <div x-show="open" x-collapse x-cloak>
        <p class="pb-5 pr-12 text-sm leading-relaxed text-ink-500 dark:text-ink-400">{{ $slot }}</p>
    </div>
</div>
