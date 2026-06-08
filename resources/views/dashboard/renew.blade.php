<x-layouts.dashboard :title="__('dashboard.renew.title')">
    <div class="mx-auto max-w-2xl">
        <p class="-mt-2 mb-6 text-sm text-ink-500 dark:text-ink-400">{{ __('dashboard.renew.subtitle') }}</p>

        <form method="POST" action="{{ route('dashboard.subscriptions.renew.store', $subscription) }}" class="space-y-6">
            @csrf
            <x-card padding="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-ink-400">{{ __('dashboard.subscriptions.plan') }}</p>
                        <p class="text-xl font-semibold text-ink-900 dark:text-white">{{ $subscription->plan->name }}</p>
                    </div>
                    <p class="text-2xl font-semibold font-display text-ink-900 dark:text-white">{{ format_price($subscription->plan->price, $subscription->plan->currency) }}</p>
                </div>
                @if ($subscription->ends_at)
                    <p class="mt-3 text-sm text-ink-500 dark:text-ink-400">{{ __('dashboard.subscriptions.until') }} {{ $subscription->ends_at->isoFormat('D MMMM YYYY') }}</p>
                @endif
            </x-card>

            <x-card padding="p-6">
                <p class="text-sm font-medium text-ink-700 dark:text-ink-200">{{ __('dashboard.checkout.method') }}</p>
                <div class="mt-3"><x-payment-methods :methods="$methods" /></div>
            </x-card>

            <div class="flex items-center justify-between rounded-2xl bg-brand-gradient p-6 text-white shadow-glow">
                <div>
                    <p class="text-sm text-white/80">{{ __('dashboard.checkout.total') }}</p>
                    <p class="text-2xl font-semibold">{{ format_price($subscription->plan->price, $subscription->plan->currency) }}</p>
                </div>
                <x-button type="submit" variant="white" size="lg">{{ __('dashboard.renew.submit') }}</x-button>
            </div>
            <p class="text-center text-xs text-ink-400">{{ __('dashboard.checkout.demo_note') }}</p>
        </form>
    </div>
</x-layouts.dashboard>
