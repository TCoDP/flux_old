<x-layouts.public :seo="$seo">
    <x-page-header :eyebrow="__('pricing.eyebrow')" :title="__('pricing.title')" :subtitle="__('pricing.subtitle')" />

    <div class="mx-auto max-w-7xl px-5 sm:px-8">
        <x-pricing-grid :plans="$plans" />

        {{-- All plans include --}}
        <div class="reveal mx-auto mt-16 max-w-4xl">
            <x-glass-card padding="p-8">
                <p class="text-center text-sm font-semibold uppercase tracking-wider text-ink-400">{{ __('pricing.all_plans_include') }}</p>
                <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach (['feature_speed' => 'bolt', 'feature_support' => 'chat', 'feature_devices' => 'device-phone', 'feature_nolimit' => 'globe'] as $key => $icon)
                        <div class="flex items-center gap-3">
                            <span class="grid h-10 w-10 shrink-0 place-items-center rounded-xl bg-brand-500/10 text-brand-600 dark:text-brand-300"><x-icon :name="$icon" class="h-5 w-5" /></span>
                            <span class="text-sm font-medium text-ink-700 dark:text-ink-200">{{ __('pricing.'.$key) }}</span>
                        </div>
                    @endforeach
                </div>
            </x-glass-card>
        </div>

        {{-- Guarantee --}}
        <div class="reveal mx-auto mt-6 max-w-4xl">
            <div class="flex flex-col items-center gap-4 rounded-2xl border border-emerald-500/20 bg-emerald-500/5 p-6 text-center sm:flex-row sm:text-left">
                <span class="grid h-12 w-12 shrink-0 place-items-center rounded-xl bg-emerald-500/10 text-emerald-500"><x-icon name="check-circle" class="h-6 w-6" /></span>
                <div>
                    <p class="font-semibold text-ink-900 dark:text-white">{{ __('pricing.guarantee_title') }}</p>
                    <p class="mt-1 text-sm text-ink-500 dark:text-ink-400">{{ __('pricing.guarantee_text') }}</p>
                </div>
            </div>
        </div>
    </div>

    <x-section :eyebrow="__('faq.eyebrow')" :title="__('faq.title')" center>
        <x-faq-list />
    </x-section>
</x-layouts.public>
