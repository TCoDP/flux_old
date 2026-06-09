@props(['seo' => [], 'title' => null])

@php
    $bottomNav = [
        ['href' => route('admin.dashboard'), 'icon' => 'chart', 'label' => __('admin.bnav.dashboard'), 'active' => request()->routeIs('admin.dashboard')],
        ['href' => route('admin.users.index'), 'icon' => 'users', 'label' => __('admin.bnav.users'), 'active' => request()->routeIs('admin.users.*')],
        ['href' => route('admin.payments.index'), 'icon' => 'credit-card', 'label' => __('admin.bnav.payments'), 'active' => request()->routeIs('admin.payments.*')],
        ['action' => 'sidebar = true', 'icon' => 'menu', 'label' => __('admin.bnav.more')],
    ];
@endphp

<x-layouts.base :seo="$seo">
    <div x-data="{ sidebar: false }" class="min-h-screen">
        {{-- Desktop sidebar --}}
        <aside class="fixed inset-y-0 left-0 z-40 hidden w-72 flex-col border-r border-ink-200/70 dark:border-white/10 bg-white/60 dark:bg-ink-950/40 backdrop-blur-xl px-5 py-6 lg:flex">
            <div class="flex items-center gap-2.5 px-1.5">
                <x-logo :withText="false" />
                <div>
                    <p class="text-sm font-semibold text-ink-900 dark:text-white">{{ settings('site_name') }}</p>
                    <p class="text-[11px] text-ink-400">{{ __('admin.panel') }}</p>
                </div>
            </div>
            <div class="mt-8 flex-1 overflow-y-auto pr-1">
                <x-admin-nav />
            </div>
            <a href="{{ route('home') }}" class="mt-4 flex items-center gap-2 px-3.5 py-2 text-sm text-ink-400 hover:text-brand-600 dark:hover:text-brand-300 transition">
                <x-icon name="arrow-right" class="h-4 w-4 rotate-180" /> {{ __('nav.home') }}
            </a>
        </aside>

        {{-- Mobile drawer --}}
        <div x-show="sidebar" x-cloak class="fixed inset-0 z-50 lg:hidden">
            <div x-show="sidebar" x-transition.opacity @click="sidebar = false" class="absolute inset-0 bg-ink-950/50 backdrop-blur-sm"></div>
            <aside x-show="sidebar" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
                   class="absolute inset-y-0 left-0 w-72 bg-white dark:bg-ink-950 px-5 py-6 shadow-card overflow-y-auto">
                <div class="flex items-center justify-between">
                    <x-logo />
                    <button @click="sidebar = false" class="text-ink-400"><x-icon name="x" class="h-5 w-5" /></button>
                </div>
                <div class="mt-8"><x-admin-nav /></div>
            </aside>
        </div>

        {{-- Main --}}
        <div class="lg:pl-72">
            <header class="sticky top-0 z-30 flex items-center gap-3 border-b border-ink-200/70 dark:border-white/10 glass px-5 py-3.5 sm:px-8">
                <button @click="sidebar = true" class="grid h-9 w-9 place-items-center rounded-xl text-ink-500 hover:bg-ink-100 dark:hover:bg-white/5 lg:hidden">
                    <x-icon name="menu" class="h-5 w-5" />
                </button>
                <h1 class="flex-1 truncate text-lg font-semibold text-ink-900 dark:text-white">{{ $title }}</h1>
                <div class="flex items-center gap-1.5">
                    <x-theme-toggle />
                    <x-user-menu />
                </div>
            </header>

            <main class="mx-auto max-w-7xl px-5 pt-8 pb-28 sm:px-8 lg:pb-10">
                @if (isset($header))
                    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">{{ $header }}</div>
                @endif
                {{ $slot }}
            </main>
        </div>

        <x-bottom-nav :items="$bottomNav" />
    </div>
</x-layouts.base>
