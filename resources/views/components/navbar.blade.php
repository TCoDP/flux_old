@php
    $links = [
        ['route' => 'pricing', 'label' => __('nav.pricing'), 'active' => request()->routeIs('pricing')],
        ['route' => 'about', 'label' => __('nav.about'), 'active' => request()->routeIs('about')],
        ['route' => 'docs.index', 'label' => __('nav.docs'), 'active' => request()->routeIs('docs.*')],
        ['route' => 'blog.index', 'label' => __('nav.blog'), 'active' => request()->routeIs('blog.*')],
        ['route' => 'faq', 'label' => __('nav.faq'), 'active' => request()->routeIs('faq')],
    ];
@endphp

<header x-data="{ scrolled: false, mobile: false }"
        @scroll.window="scrolled = window.scrollY > 12"
        @open-menu.window="mobile = true"
        class="sticky top-0 z-50 transition-all duration-300"
        :class="scrolled ? 'glass-strong shadow-soft' : 'bg-transparent'">
    <nav class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-5 py-3.5 sm:px-8">
        <x-logo />

        <div class="hidden items-center gap-8 lg:flex">
            @foreach ($links as $link)
                <x-nav-link :href="route($link['route'])" :active="$link['active']">{{ $link['label'] }}</x-nav-link>
            @endforeach
        </div>

        <div class="flex items-center gap-1.5">
            <x-theme-toggle />
            <x-lang-switcher class="hidden sm:block" />

            @auth
                <x-button :href="route('dashboard.home')" variant="primary" size="sm" class="hidden sm:inline-flex">
                    {{ __('nav.dashboard') }}
                </x-button>
            @else
                <x-button :href="route('login')" variant="ghost" size="sm" class="hidden sm:inline-flex">{{ __('nav.login') }}</x-button>
                <x-button :href="route('register')" variant="primary" size="sm" class="hidden sm:inline-flex">{{ __('nav.register') }}</x-button>
            @endauth
        </div>
    </nav>

    {{-- Mobile drawer --}}
    <div x-show="mobile" x-cloak class="fixed inset-0 z-[70] lg:hidden">
        <div x-show="mobile" x-transition.opacity @click="mobile = false" class="absolute inset-0 bg-ink-950/50 backdrop-blur-sm"></div>
        <div x-show="mobile"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
             class="absolute right-0 top-0 h-full w-80 max-w-[85%] glass-strong p-6 shadow-card">
            <div class="flex items-center justify-between">
                <x-logo />
                <button @click="mobile = false" class="grid h-9 w-9 place-items-center rounded-xl text-ink-500 hover:bg-ink-100 dark:hover:bg-white/5">
                    <x-icon name="x" class="h-5 w-5" />
                </button>
            </div>
            <div class="mt-8 flex flex-col gap-1">
                @foreach ($links as $link)
                    <a href="{{ route($link['route']) }}" class="rounded-xl px-4 py-3 text-base font-medium {{ $link['active'] ? 'bg-brand-500/10 text-brand-600 dark:text-brand-300' : 'text-ink-700 hover:bg-ink-100 dark:text-ink-200 dark:hover:bg-white/5' }}">{{ $link['label'] }}</a>
                @endforeach
            </div>
            <div class="mt-6 flex items-center gap-2">
                <x-theme-toggle />
                <x-lang-switcher />
            </div>
            <div class="mt-6 flex flex-col gap-2.5">
                @auth
                    <x-button :href="route('dashboard.home')" variant="primary" block>{{ __('nav.dashboard') }}</x-button>
                @else
                    <x-button :href="route('login')" variant="secondary" block>{{ __('nav.login') }}</x-button>
                    <x-button :href="route('register')" variant="primary" block>{{ __('nav.register') }}</x-button>
                @endauth
            </div>
        </div>
    </div>
</header>
