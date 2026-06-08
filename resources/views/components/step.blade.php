@props(['number' => 1, 'title' => ''])

<div class="relative flex gap-5">
    <div class="flex flex-col items-center">
        <span class="grid h-10 w-10 shrink-0 place-items-center rounded-full bg-brand-gradient text-sm font-semibold text-white shadow-glow">
            {{ $number }}
        </span>
        <span class="mt-2 w-px flex-1 bg-gradient-to-b from-brand-400/40 to-transparent last:hidden"></span>
    </div>
    <div class="flex-1 pb-10">
        <h4 class="text-base font-semibold text-ink-900 dark:text-white">{{ $title }}</h4>
        <div class="mt-2 space-y-3 text-sm leading-relaxed text-ink-500 dark:text-ink-400">{{ $slot }}</div>
    </div>
</div>
