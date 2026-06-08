<x-layouts.dashboard :title="__('dashboard.subscriptions.title')">
    <p class="-mt-2 mb-6 text-sm text-ink-500 dark:text-ink-400">{{ __('dashboard.subscriptions.subtitle') }}</p>

    @if ($subscriptions->isNotEmpty())
        <div class="space-y-4">
            @foreach ($subscriptions as $subscription)
                <x-card padding="p-6">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <span class="grid h-12 w-12 place-items-center rounded-xl bg-brand-500/10 text-brand-600 dark:text-brand-300"><x-icon name="shield" class="h-6 w-6" /></span>
                            <div>
                                <div class="flex items-center gap-2">
                                    <p class="font-semibold text-ink-900 dark:text-white">{{ $subscription->plan->name }}</p>
                                    <x-badge :color="$subscription->status->color()" dot>{{ $subscription->status->label() }}</x-badge>
                                </div>
                                <p class="mt-0.5 text-sm text-ink-400">
                                    {{ format_price($subscription->plan->price, $subscription->plan->currency) }} / {{ $subscription->plan->billing_period->label() }}
                                    @if ($subscription->ends_at) · {{ __('dashboard.subscriptions.until') }} {{ $subscription->ends_at->isoFormat('D MMM YYYY') }}@endif
                                </p>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <x-button :href="route('dashboard.subscriptions.show', $subscription)" variant="secondary" size="sm">{{ __('dashboard.subscriptions.details') }}</x-button>
                            <x-button :href="route('dashboard.subscriptions.renew', $subscription)" size="sm" icon="arrow-path">{{ __('dashboard.home.renew') }}</x-button>
                        </div>
                    </div>
                </x-card>
            @endforeach
        </div>
    @else
        <x-empty-state icon="sparkles" :title="__('dashboard.subscriptions.empty')" :message="__('dashboard.subscriptions.empty_text')">
            <x-slot:action><x-button :href="route('pricing')">{{ __('dashboard.home.choose_plan') }}</x-button></x-slot:action>
        </x-empty-state>
    @endif
</x-layouts.dashboard>
