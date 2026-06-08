<x-layouts.dashboard :title="$subscription->plan->name">
    <a href="{{ route('dashboard.subscriptions.index') }}" class="mb-6 inline-flex items-center gap-1.5 text-sm text-ink-500 hover:text-brand-600 dark:text-ink-400">
        <x-icon name="arrow-right" class="h-4 w-4 rotate-180" /> {{ __('common.back') }}
    </a>

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="space-y-6 lg:col-span-2">
            <x-card padding="p-6">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-ink-900 dark:text-white">{{ $subscription->plan->name }}</h3>
                    <x-badge :color="$subscription->status->color()" dot>{{ $subscription->status->label() }}</x-badge>
                </div>
                <dl class="mt-5 grid gap-4 sm:grid-cols-2">
                    <div><dt class="text-xs text-ink-400">{{ __('dashboard.subscriptions.plan') }}</dt><dd class="mt-1 font-medium text-ink-800 dark:text-ink-100">{{ format_price($subscription->plan->price, $subscription->plan->currency) }} / {{ $subscription->plan->billing_period->label() }}</dd></div>
                    <div><dt class="text-xs text-ink-400">{{ __('dashboard.subscriptions.until') }}</dt><dd class="mt-1 font-medium text-ink-800 dark:text-ink-100">{{ $subscription->ends_at?->isoFormat('D MMMM YYYY') ?? '—' }}</dd></div>
                    <div><dt class="text-xs text-ink-400">{{ __('dashboard.home.days_left') }}</dt><dd class="mt-1 font-medium text-ink-800 dark:text-ink-100">{{ $subscription->daysLeft() }}</dd></div>
                    <div><dt class="text-xs text-ink-400">{{ __('dashboard.subscriptions.auto_renew') }}</dt><dd class="mt-1 font-medium text-ink-800 dark:text-ink-100">{{ $subscription->auto_renew ? __('common.yes') : __('common.no') }}</dd></div>
                </dl>
                <div class="mt-6"><x-button :href="route('dashboard.subscriptions.renew', $subscription)" icon="arrow-path">{{ __('dashboard.subscriptions.renew') }}</x-button></div>
            </x-card>

            <x-card padding="p-6">
                <h3 class="text-base font-semibold text-ink-900 dark:text-white">{{ __('dashboard.nav.connections') }}</h3>
                <div class="mt-4 space-y-3">
                    @forelse ($subscription->connections as $connection)
                        <div class="flex items-center justify-between rounded-xl border border-ink-100 dark:border-white/5 px-4 py-3">
                            <div class="flex items-center gap-3">
                                <span class="grid h-9 w-9 place-items-center rounded-lg bg-brand-500/10 text-brand-600 dark:text-brand-300"><x-icon name="wifi" class="h-4 w-4" /></span>
                                <div>
                                    <p class="text-sm font-medium text-ink-800 dark:text-ink-100">{{ $connection->name }}</p>
                                    <p class="text-xs text-ink-400">{{ $connection->server?->region?->name ?? '—' }}</p>
                                </div>
                            </div>
                            <x-badge :color="$connection->status->color()">{{ $connection->status->label() }}</x-badge>
                        </div>
                    @empty
                        <p class="py-4 text-center text-sm text-ink-400">{{ __('dashboard.connections.empty') }}</p>
                    @endforelse
                </div>
            </x-card>
        </div>

        <x-card padding="p-6" class="h-fit">
            <h3 class="text-base font-semibold text-ink-900 dark:text-white">{{ __('dashboard.home.recent_payments') }}</h3>
            <div class="mt-4 space-y-3">
                @forelse ($subscription->payments as $payment)
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-ink-500 dark:text-ink-400">{{ $payment->created_at->isoFormat('D MMM YYYY') }}</span>
                        <span class="font-medium text-ink-800 dark:text-ink-100">{{ format_price($payment->total(), $payment->currency) }}</span>
                    </div>
                @empty
                    <p class="py-4 text-center text-sm text-ink-400">{{ __('dashboard.payments.empty') }}</p>
                @endforelse
            </div>
        </x-card>
    </div>
</x-layouts.dashboard>
