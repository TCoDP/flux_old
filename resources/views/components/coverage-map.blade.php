@props(['regions' => collect()])

<div {{ $attributes->merge(['class' => 'reveal relative mt-14 overflow-hidden rounded-3xl ring-hair bg-white dark:bg-ink-900/40 p-6 sm:p-10 shadow-soft']) }}>
    <x-gradient-blob class="-right-20 -top-24 h-72 w-72" />
    <div class="absolute inset-0 -z-10 bg-grid opacity-50 dark:opacity-30"></div>

    <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
        @forelse ($regions as $region)
            <div class="group flex items-center gap-3.5 rounded-2xl border border-ink-100 dark:border-white/5 bg-white/70 dark:bg-ink-950/40 px-4 py-3.5 backdrop-blur transition hover:border-brand-400/40 hover:shadow-soft">
                <span class="grid h-11 w-11 shrink-0 place-items-center rounded-xl bg-ink-50 dark:bg-white/5 text-2xl">
                    {{ $region->flag ?: '🌍' }}
                </span>
                <div class="min-w-0 flex-1">
                    <div class="flex items-center justify-between gap-2">
                        <p class="truncate text-sm font-semibold text-ink-900 dark:text-white">{{ $region->name }}</p>
                        <span class="flex items-center gap-1 text-[11px] font-medium text-emerald-500">
                            <span class="relative flex h-1.5 w-1.5">
                                <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-75"></span>
                                <span class="relative inline-flex h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                            </span>
                            {{ __('home.coverage.online') }}
                        </span>
                    </div>
                    <div class="mt-2 flex items-center gap-2">
                        <div class="h-1.5 flex-1 overflow-hidden rounded-full bg-ink-100 dark:bg-white/10">
                            <div class="h-full rounded-full bg-brand-gradient" style="width: {{ max(8, 100 - (int) $region->load_percent) }}%"></div>
                        </div>
                        <span class="text-[11px] text-ink-400">{{ max(0, 100 - (int) $region->load_percent) }}%</span>
                    </div>
                </div>
            </div>
        @empty
            <p class="col-span-full py-8 text-center text-sm text-ink-400">{{ __('home.coverage.empty') }}</p>
        @endforelse
    </div>
</div>
