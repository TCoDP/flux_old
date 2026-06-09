@props(['seo' => []])

@php
    $bottomNav = [
        ['href' => route('home'), 'icon' => 'home', 'label' => __('nav.home'), 'active' => request()->routeIs('home')],
        ['href' => route('pricing'), 'icon' => 'currency', 'label' => __('nav.pricing'), 'active' => request()->routeIs('pricing')],
        ['href' => route('docs.index'), 'icon' => 'document', 'label' => __('nav.docs_short'), 'active' => request()->routeIs('docs.*')],
        ['href' => route('blog.index'), 'icon' => 'chat', 'label' => __('nav.blog'), 'active' => request()->routeIs('blog.*')],
        auth()->check()
            ? ['href' => route('dashboard.home'), 'icon' => 'user', 'label' => __('nav.cabinet'), 'active' => false]
            : ['href' => route('login'), 'icon' => 'user', 'label' => __('nav.login'), 'active' => request()->routeIs('login')],
    ];
@endphp

<x-layouts.base :seo="$seo">
    <div class="relative overflow-x-clip">
        <x-navbar />
        <main>
            {{ $slot }}
        </main>
        <x-footer />
        <div class="h-20 lg:hidden" aria-hidden="true"></div>
    </div>

    <x-bottom-nav :items="$bottomNav" />
</x-layouts.base>
