@php
    $items = [
        ['href' => route('home'), 'icon' => 'home', 'label' => __('nav.home'), 'active' => request()->routeIs('home')],
        ['href' => route('pricing'), 'icon' => 'currency', 'label' => __('nav.pricing'), 'active' => request()->routeIs('pricing')],
        ['href' => route('docs.index'), 'icon' => 'document', 'label' => __('nav.docs_short'), 'active' => request()->routeIs('docs.*')],
        ['href' => route('blog.index'), 'icon' => 'chat', 'label' => __('nav.blog'), 'active' => request()->routeIs('blog.*')],
        ['onclick' => "window.dispatchEvent(new CustomEvent('open-menu'))", 'icon' => 'menu', 'label' => __('nav.menu')],
    ];
@endphp

<x-bottom-nav :items="$items" />
