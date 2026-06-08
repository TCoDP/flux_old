@php
    $groups = [
        __('admin.nav.overview') => [
            ['route' => 'admin.dashboard', 'pattern' => 'admin.dashboard', 'icon' => 'chart', 'label' => __('admin.nav.dashboard')],
            ['route' => 'admin.logs.index', 'pattern' => 'admin.logs.*', 'icon' => 'list', 'label' => __('admin.nav.logs')],
        ],
        __('admin.nav.catalog') => [
            ['route' => 'admin.plans.index', 'pattern' => 'admin.plans.*', 'icon' => 'currency', 'label' => __('admin.nav.plans')],
            ['route' => 'admin.servers.index', 'pattern' => 'admin.servers.*', 'icon' => 'server', 'label' => __('admin.nav.servers')],
            ['route' => 'admin.regions.index', 'pattern' => 'admin.regions.*', 'icon' => 'globe', 'label' => __('admin.nav.regions')],
            ['route' => 'admin.promocodes.index', 'pattern' => 'admin.promocodes.*', 'icon' => 'gift', 'label' => __('admin.nav.promocodes')],
        ],
        __('admin.nav.customers') => [
            ['route' => 'admin.users.index', 'pattern' => 'admin.users.*', 'icon' => 'users', 'label' => __('admin.nav.users')],
            ['route' => 'admin.subscriptions.index', 'pattern' => 'admin.subscriptions.*', 'icon' => 'sparkles', 'label' => __('admin.nav.subscriptions')],
            ['route' => 'admin.payments.index', 'pattern' => 'admin.payments.*', 'icon' => 'credit-card', 'label' => __('admin.nav.payments')],
            ['route' => 'admin.referrals.index', 'pattern' => 'admin.referrals.*', 'icon' => 'gift', 'label' => __('admin.nav.referrals')],
        ],
        __('admin.nav.content') => [
            ['route' => 'admin.articles.index', 'pattern' => 'admin.articles.*', 'icon' => 'document', 'label' => __('admin.nav.articles')],
            ['route' => 'admin.reviews.index', 'pattern' => 'admin.reviews.*', 'icon' => 'star', 'label' => __('admin.nav.reviews')],
            ['route' => 'admin.notifications.index', 'pattern' => 'admin.notifications.*', 'icon' => 'bell', 'label' => __('admin.nav.notifications')],
        ],
        __('admin.nav.system') => [
            ['route' => 'admin.settings.edit', 'pattern' => 'admin.settings.*', 'icon' => 'cog', 'label' => __('admin.nav.settings')],
            ['route' => 'admin.seo.edit', 'pattern' => 'admin.seo.*', 'icon' => 'search', 'label' => __('admin.nav.seo')],
        ],
    ];
@endphp

<nav class="flex flex-col gap-5">
    @foreach ($groups as $label => $items)
        <div>
            <p class="px-3.5 pb-1.5 text-[11px] font-semibold uppercase tracking-wider text-ink-400">{{ $label }}</p>
            <div class="flex flex-col gap-0.5">
                @foreach ($items as $i)
                    <x-sidebar-link :href="route($i['route'])" :icon="$i['icon']" :active="request()->routeIs($i['pattern'])">{{ $i['label'] }}</x-sidebar-link>
                @endforeach
            </div>
        </div>
    @endforeach
</nav>
