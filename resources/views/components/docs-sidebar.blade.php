@props(['platforms' => []])

@php $current = request()->route('platform'); @endphp

<div x-data="{ q: '' }" class="space-y-4">
    <div class="relative">
        <x-icon name="search" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-ink-400" />
        <input type="text" x-model="q" placeholder="{{ __('docs.search_placeholder') }}"
               class="w-full rounded-xl border border-ink-200 dark:border-white/10 bg-white dark:bg-ink-900/50 py-2.5 pl-9 pr-3 text-sm text-ink-900 dark:text-white placeholder-ink-400 outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/20">
    </div>

    <nav class="flex flex-col gap-1">
        <a href="{{ route('docs.index') }}"
           class="flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm font-medium transition {{ request()->routeIs('docs.index') ? 'bg-brand-500/10 text-brand-700 dark:text-brand-200' : 'text-ink-500 hover:bg-ink-100 hover:text-ink-900 dark:text-ink-400 dark:hover:bg-white/5 dark:hover:text-white' }}">
            <x-icon name="document" class="h-5 w-5 shrink-0" />
            {{ __('docs.all_platforms') }}
        </a>

        @foreach ($platforms as $slug => $icon)
            <a href="{{ route('docs.platform', ['platform' => $slug]) }}"
               x-show="q === '' || '{{ mb_strtolower(__('docs.platforms.'.$slug.'.name')) }}'.includes(q.toLowerCase())"
               class="flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm font-medium transition {{ $current === $slug ? 'bg-brand-500/10 text-brand-700 dark:text-brand-200 ring-1 ring-brand-500/15' : 'text-ink-500 hover:bg-ink-100 hover:text-ink-900 dark:text-ink-400 dark:hover:bg-white/5 dark:hover:text-white' }}">
                <x-icon :name="$icon" class="h-5 w-5 shrink-0 {{ $current === $slug ? 'text-brand-500' : '' }}" />
                {{ __('docs.platforms.'.$slug.'.name') }}
            </a>
        @endforeach
    </nav>
</div>
