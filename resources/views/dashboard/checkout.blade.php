<x-layouts.dashboard :title="__('dashboard.checkout.title')">
    <div class="mx-auto max-w-2xl">
        <p class="-mt-2 mb-6 text-sm text-ink-500 dark:text-ink-400">{{ __('dashboard.checkout.subtitle') }}</p>

        <form method="POST" action="{{ route('dashboard.checkout.store', $plan) }}" class="space-y-6">
            @csrf
            <x-card padding="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-ink-400">{{ __('dashboard.subscriptions.plan') }}</p>
                        <p class="text-xl font-semibold text-ink-900 dark:text-white">{{ $plan->name }}</p>
                    </div>
                    <p class="text-2xl font-semibold font-display text-ink-900 dark:text-white">{{ format_price($plan->price, $plan->currency) }}</p>
                </div>
                <ul class="mt-4 grid gap-2 sm:grid-cols-2">
                    <li class="flex items-center gap-2 text-sm text-ink-600 dark:text-ink-300"><x-icon name="check" class="h-4 w-4 text-brand-500" /> {{ trans_choice('pricing.devices', $plan->device_limit, ['count' => $plan->device_limit]) }}</li>
                    @foreach (($plan->features ?? []) as $feature)
                        <li class="flex items-center gap-2 text-sm text-ink-600 dark:text-ink-300"><x-icon name="check" class="h-4 w-4 text-brand-500" /> {{ $feature }}</li>
                    @endforeach
                </ul>
            </x-card>

            <x-card padding="p-6">
                <p class="text-sm font-medium text-ink-700 dark:text-ink-200">{{ __('dashboard.checkout.method') }}</p>
                <div class="mt-3"><x-payment-methods :methods="$methods" /></div>

                <div class="mt-5">
                    <x-field :label="__('dashboard.checkout.promo')" for="promo_code" error="promo_code">
                        <x-input name="promo_code" :value="session('promo_code')" :placeholder="__('dashboard.checkout.promo_placeholder')" icon="ticket" />
                    </x-field>
                </div>
            </x-card>

            <div class="flex items-center justify-between rounded-2xl bg-brand-gradient p-6 text-white shadow-glow">
                <div>
                    <p class="text-sm text-white/80">{{ __('dashboard.checkout.total') }}</p>
                    <p class="text-2xl font-semibold">{{ format_price($plan->price, $plan->currency) }}</p>
                </div>
                <x-button type="submit" variant="white" size="lg">{{ __('dashboard.checkout.pay') }}</x-button>
            </div>
            <p class="text-center text-xs text-ink-400">{{ __('dashboard.checkout.demo_note') }}</p>
        </form>
    </div>
</x-layouts.dashboard>
