<x-layouts.public :seo="$seo">
    <x-page-header :eyebrow="__('about.eyebrow')" :title="__('about.title')" :subtitle="__('about.subtitle')" />

    {{-- Mission --}}
    <x-section>
        <div class="reveal mx-auto max-w-4xl">
            <x-glass-card padding="p-8 sm:p-12">
                <h2 class="text-2xl font-semibold font-display text-ink-900 dark:text-white">{{ __('about.mission.title') }}</h2>
                <p class="mt-4 text-lg leading-relaxed text-ink-500 dark:text-ink-300">{{ __('about.mission.text') }}</p>
            </x-glass-card>
        </div>
    </x-section>

    {{-- Values --}}
    <x-section :eyebrow="__('about.values.title')" :title="__('about.values.subtitle')" center>
        <div class="mt-14 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach (__('about.values.items') as $value)
                <x-feature :icon="$value['icon']" :title="$value['title']">{{ $value['text'] }}</x-feature>
            @endforeach
        </div>
    </x-section>

    {{-- Stats --}}
    <x-section :title="__('about.stats.title')" center>
        <div class="mt-12 grid grid-cols-2 gap-4 lg:grid-cols-4">
            <x-stat icon="server" :value="settings('servers_count').'+'" :label="__('home.stats.servers')" />
            <x-stat icon="globe" :value="settings('regions_count').'+'" :label="__('home.stats.regions')" />
            <x-stat icon="users" :value="settings('users_count')" :label="__('home.stats.users')" />
            <x-stat icon="bolt" :value="settings('uptime').'%'" :label="__('home.stats.uptime')" />
        </div>
    </x-section>

    {{-- CTA --}}
    <div class="mx-auto max-w-7xl px-5 pb-8 sm:px-8">
        <x-cta :title="__('about.cta.title')" :subtitle="__('about.cta.subtitle')">
            <x-button :href="route('register')" variant="white" size="lg">{{ __('home.cta.button') }}</x-button>
        </x-cta>
    </div>
</x-layouts.public>
