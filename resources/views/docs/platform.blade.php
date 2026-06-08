<x-layouts.docs :seo="$seo" :platforms="$platforms">
    <x-breadcrumbs class="mb-6" :items="[['label' => __('nav.docs'), 'href' => route('docs.index')], ['label' => __('docs.platforms.'.$platform.'.name')]]" />

    {{-- Header --}}
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <span class="grid h-14 w-14 place-items-center rounded-2xl bg-brand-gradient text-white shadow-glow"><x-icon :name="$icon" class="h-7 w-7" /></span>
            <div>
                <h1 class="text-2xl font-semibold font-display tracking-tight text-ink-900 dark:text-white">{{ __('docs.platforms.'.$platform.'.name') }}</h1>
                <p class="text-sm text-ink-400">{{ __('docs.setup_time') }}</p>
            </div>
        </div>
        <x-button href="#" icon="arrow-up-right">{{ __('docs.download') }}</x-button>
    </div>
    <p class="mt-5 text-lg leading-relaxed text-ink-500 dark:text-ink-300">{{ __('docs.platforms.'.$platform.'.intro') }}</p>

    {{-- Steps --}}
    <h2 class="mt-12 text-xl font-semibold font-display text-ink-900 dark:text-white">{{ __('docs.steps_title') }}</h2>
    <div class="mt-6">
        @foreach (__('docs.platforms.'.$platform.'.steps') as $i => $step)
            <x-step :number="$i + 1" :title="$step['title']">
                {{ $step['text'] }}
                <div class="mt-3 flex aspect-[16/7] items-center justify-center rounded-xl border border-dashed border-ink-200 bg-gradient-to-br from-brand-500/5 to-accent-400/5 text-ink-300 dark:border-white/10">
                    <span class="flex items-center gap-2 text-xs"><x-icon :name="$icon" class="h-5 w-5" /> {{ __('docs.screenshot') }} {{ $i + 1 }}</span>
                </div>
            </x-step>
        @endforeach
    </div>

    {{-- Config block --}}
    <div class="mt-6 rounded-2xl bg-ink-50 p-6 ring-hair dark:bg-ink-900/40">
        <h3 class="text-base font-semibold text-ink-900 dark:text-white">{{ __('docs.config_title') }}</h3>
        <p class="mt-1 text-sm text-ink-500 dark:text-ink-400">{{ __('docs.config_hint') }}</p>
        <div class="mt-4 grid gap-3 sm:grid-cols-2">
            <x-copy-field :label="__('docs.config_server')" value="msk-01.flux.net" />
            <x-copy-field :label="__('docs.config_token')" value="flux-xxxx-xxxx-xxxx-xxxx" />
        </div>
    </div>

    {{-- Platform FAQ --}}
    <h2 class="mt-12 text-xl font-semibold font-display text-ink-900 dark:text-white">{{ __('docs.platform_faq') }}</h2>
    <div class="mt-2">
        @foreach (__('docs.platforms.'.$platform.'.faq') as $item)
            <x-faq-item :question="$item['q']">{{ $item['a'] }}</x-faq-item>
        @endforeach
    </div>

    {{-- Need help --}}
    <div class="mt-12 flex flex-col items-start gap-4 rounded-2xl bg-brand-gradient p-6 text-white sm:flex-row sm:items-center sm:justify-between">
        <div>
            <p class="text-lg font-semibold">{{ __('docs.need_help') }}</p>
            <p class="mt-1 text-sm text-white/80">{{ __('docs.need_help_text') }}</p>
        </div>
        <x-button :href="route('contact')" variant="white">{{ __('docs.contact_support') }}</x-button>
    </div>
</x-layouts.docs>
