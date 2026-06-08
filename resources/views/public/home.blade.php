<x-layouts.public :seo="$seo">
    {{-- ===================== HERO ===================== --}}
    <section class="relative overflow-hidden pt-16 sm:pt-24">
        <x-gradient-blob class="left-1/2 top-[-10rem] h-[34rem] w-[34rem] -translate-x-1/2 animate-float-slow" />
        <div class="absolute inset-0 -z-10 bg-grid [mask-image:radial-gradient(ellipse_at_top,black,transparent_70%)] opacity-60 dark:opacity-30"></div>

        <div class="mx-auto max-w-7xl px-5 sm:px-8">
            <div class="mx-auto max-w-3xl text-center">
                <span class="inline-flex items-center gap-2 rounded-full glass px-4 py-1.5 text-sm font-medium text-ink-600 dark:text-ink-200">
                    <span class="flex h-2 w-2"><span class="absolute h-2 w-2 animate-ping rounded-full bg-brand-400 opacity-75"></span><span class="h-2 w-2 rounded-full bg-brand-500"></span></span>
                    {{ __('home.hero.badge') }}
                </span>

                <h1 class="mt-6 text-balance text-4xl font-semibold font-display leading-[1.05] tracking-tight text-ink-900 dark:text-white sm:text-6xl">
                    {{ __('home.hero.title_1') }}
                    <span class="text-gradient">{{ __('home.hero.title_2') }}</span>
                </h1>

                <p class="mx-auto mt-6 max-w-2xl text-pretty text-lg leading-relaxed text-ink-500 dark:text-ink-300">
                    {{ __('home.hero.subtitle') }}
                </p>

                <div class="mt-9 flex flex-wrap items-center justify-center gap-3">
                    <x-button :href="route('register')" size="lg" icon-right="arrow-right">{{ __('home.hero.cta_primary') }}</x-button>
                    <x-button :href="route('pricing')" variant="secondary" size="lg">{{ __('home.hero.cta_secondary') }}</x-button>
                </div>
                <p class="mt-4 text-sm text-ink-400">{{ __('home.hero.note') }}</p>
            </div>

            {{-- Hero visual --}}
            <div class="reveal relative mx-auto mt-16 max-w-4xl">
                <div class="absolute -inset-x-10 -top-6 -z-10 h-72 bg-brand-gradient opacity-20 blur-3xl"></div>
                <x-glass-card strong padding="p-2" class="shadow-card">
                    <div class="rounded-2xl bg-ink-950 p-6 sm:p-8">
                        <div class="flex items-center gap-2">
                            <span class="h-3 w-3 rounded-full bg-red-400/80"></span>
                            <span class="h-3 w-3 rounded-full bg-amber-400/80"></span>
                            <span class="h-3 w-3 rounded-full bg-emerald-400/80"></span>
                            <span class="ml-3 text-xs text-white/40">app.flux — {{ __('home.coverage.online') }}</span>
                        </div>
                        <div class="mt-6 grid gap-4 sm:grid-cols-3">
                            <div class="rounded-2xl bg-white/5 p-5 ring-1 ring-white/10">
                                <div class="flex items-center justify-between">
                                    <span class="grid h-10 w-10 place-items-center rounded-xl bg-brand-gradient text-white"><x-icon name="shield" class="h-5 w-5" /></span>
                                    <x-badge color="success" dot>{{ __('home.coverage.online') }}</x-badge>
                                </div>
                                <p class="mt-4 text-sm text-white/50">{{ __('home.hero.title_1') }}</p>
                                <p class="text-2xl font-semibold text-white">256-bit</p>
                            </div>
                            <div class="rounded-2xl bg-white/5 p-5 ring-1 ring-white/10">
                                <p class="text-sm text-white/50">{{ __('home.stats.regions') }}</p>
                                <p class="mt-1 text-3xl font-semibold text-white">{{ settings('regions_count') }}+</p>
                                <div class="mt-4 flex gap-1">
                                    @for ($i = 0; $i < 7; $i++)<span class="h-8 flex-1 rounded bg-brand-gradient" style="opacity: {{ 0.3 + $i * 0.1 }}"></span>@endfor
                                </div>
                            </div>
                            <div class="rounded-2xl bg-white/5 p-5 ring-1 ring-white/10">
                                <p class="text-sm text-white/50">{{ __('home.stats.uptime') }}</p>
                                <p class="mt-1 text-3xl font-semibold text-white">{{ settings('uptime') }}%</p>
                                <div class="mt-5 h-2 overflow-hidden rounded-full bg-white/10">
                                    <div class="h-full rounded-full bg-gradient-to-r from-emerald-400 to-brand-400" style="width: {{ settings('uptime') }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </x-glass-card>
            </div>
        </div>
    </section>

    {{-- ===================== STATS ===================== --}}
    <div class="mx-auto mt-20 max-w-7xl px-5 sm:px-8">
        <div class="reveal grid grid-cols-2 gap-4 lg:grid-cols-4">
            <x-stat icon="server" :value="settings('servers_count').'+'" :label="__('home.stats.servers')" />
            <x-stat icon="globe" :value="settings('regions_count').'+'" :label="__('home.stats.regions')" />
            <x-stat icon="users" :value="settings('users_count')" :label="__('home.stats.users')" />
            <x-stat icon="bolt" :value="settings('uptime').'%'" :label="__('home.stats.uptime')" />
        </div>
    </div>

    {{-- ===================== FEATURES ===================== --}}
    <x-section :eyebrow="__('home.features.eyebrow')" :title="__('home.features.title')" :subtitle="__('home.features.subtitle')" center>
        <div class="mt-14 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ((is_array($f = __('home.features.items')) ? $f : []) as $feature)
                <x-feature :icon="$feature['icon']" :title="$feature['title']">{{ $feature['text'] }}</x-feature>
            @endforeach
        </div>
    </x-section>

    {{-- ===================== COVERAGE ===================== --}}
    <x-section :eyebrow="__('home.coverage.eyebrow')" :title="__('home.coverage.title')" :subtitle="__('home.coverage.subtitle')" center>
        <x-coverage-map :regions="$regions" />
    </x-section>

    {{-- ===================== HOW IT WORKS ===================== --}}
    <x-section :eyebrow="__('home.how.eyebrow')" :title="__('home.how.title')" center>
        <div class="mx-auto mt-14 max-w-2xl">
            @foreach ((is_array($s = __('home.how.steps')) ? $s : []) as $i => $step)
                <x-step :number="$i + 1" :title="$step['title']">{{ $step['text'] }}</x-step>
            @endforeach
        </div>
    </x-section>

    {{-- ===================== PRICING ===================== --}}
    <x-section id="pricing" :eyebrow="__('pricing.eyebrow')" :title="__('pricing.title')" :subtitle="__('pricing.subtitle')" center>
        <x-pricing-grid :plans="$plans" />
    </x-section>

    {{-- ===================== REVIEWS ===================== --}}
    @if ($reviews->isNotEmpty())
        <x-section :eyebrow="__('home.reviews.eyebrow')" :title="__('home.reviews.title')" :subtitle="__('home.reviews.subtitle')" center>
            <div class="mt-14 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($reviews as $review)
                    <x-testimonial :review="$review" />
                @endforeach
            </div>
        </x-section>
    @endif

    {{-- ===================== FAQ ===================== --}}
    <x-section :eyebrow="__('faq.eyebrow')" :title="__('faq.title')" :subtitle="__('faq.subtitle')" center>
        <x-faq-list :limit="6" />
    </x-section>

    {{-- ===================== CTA ===================== --}}
    <div class="mx-auto max-w-7xl px-5 pb-8 sm:px-8">
        <x-cta :title="__('home.cta.title')" :subtitle="__('home.cta.subtitle')">
            <x-button :href="route('register')" variant="white" size="lg">{{ __('home.cta.button') }}</x-button>
            <x-button :href="route('contact')" variant="ghost" size="lg" class="!text-white hover:!bg-white/10">{{ __('home.cta.secondary') }}</x-button>
        </x-cta>
    </div>
</x-layouts.public>
