@php
    $items = [
        ['route' => 'dashboard.home', 'pattern' => 'dashboard.home', 'icon' => 'chart', 'label' => __('dashboard.nav.overview')],
        ['route' => 'dashboard.subscriptions.index', 'pattern' => 'dashboard.subscriptions.*', 'icon' => 'sparkles', 'label' => __('dashboard.nav.subscriptions')],
        ['route' => 'dashboard.connections.index', 'pattern' => 'dashboard.connections.*', 'icon' => 'wifi', 'label' => __('dashboard.nav.connections')],
        ['route' => 'dashboard.devices.index', 'pattern' => 'dashboard.devices.*', 'icon' => 'device-phone', 'label' => __('dashboard.nav.devices')],
        ['route' => 'dashboard.payments.index', 'pattern' => 'dashboard.payments.*', 'icon' => 'credit-card', 'label' => __('dashboard.nav.payments')],
        ['route' => 'dashboard.referrals', 'pattern' => 'dashboard.referrals', 'icon' => 'gift', 'label' => __('dashboard.nav.referrals')],
        ['route' => 'dashboard.promocodes.index', 'pattern' => 'dashboard.promocodes.*', 'icon' => 'ticket', 'label' => __('dashboard.nav.promocodes')],
        ['route' => 'dashboard.notifications.index', 'pattern' => 'dashboard.notifications.*', 'icon' => 'bell', 'label' => __('dashboard.nav.notifications')],
    ];
    $account = [
        ['route' => 'dashboard.profile.edit', 'pattern' => 'dashboard.profile.*', 'icon' => 'user', 'label' => __('dashboard.nav.profile')],
        ['route' => 'dashboard.security.edit', 'pattern' => 'dashboard.security.*', 'icon' => 'shield', 'label' => __('dashboard.nav.security')],
        ['route' => 'dashboard.api-tokens.index', 'pattern' => 'dashboard.api-tokens.*', 'icon' => 'key', 'label' => __('dashboard.nav.api')],
    ];
@endphp

<nav class="flex flex-col gap-1">
    @foreach ($items as $i)
        <x-sidebar-link :href="route($i['route'])" :icon="$i['icon']" :active="request()->routeIs($i['pattern'])">{{ $i['label'] }}</x-sidebar-link>
    @endforeach

    <p class="px-3.5 pb-1 pt-5 text-[11px] font-semibold uppercase tracking-wider text-ink-400">{{ __('dashboard.nav.account') }}</p>
    @foreach ($account as $i)
        <x-sidebar-link :href="route($i['route'])" :icon="$i['icon']" :active="request()->routeIs($i['pattern'])">{{ $i['label'] }}</x-sidebar-link>
    @endforeach
</nav>
