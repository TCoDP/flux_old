<x-layouts.dashboard :title="__('dashboard.nav.overview')">
    <div class="space-y-8">
        {{-- Greeting --}}
        <div>
            <h2 class="text-2xl font-semibold font-display tracking-tight text-ink-900 dark:text-white">
                {{ __('dashboard.home.greeting', ['name' => auth()->user()->name]) }}
            </h2>
            <p class="mt-1 text-sm text-ink-500 dark:text-ink-400">{{ __('dashboard.home.subtitle') }}</p>
        </div>

        {{-- Metrics --}}
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <x-card>
                <div class="flex items-center justify-between">
                    <span class="grid h-10 w-10 place-items-center rounded-xl bg-brand-500/10 text-brand-600 dark:text-brand-300"><x-icon name="sparkles" class="h-5 w-5" /></span>
                    @if ($subscription)<x-badge :color="$subscription->status->color()" dot>{{ $subscription->status->label() }}</x-badge>@endif
                </div>
                <p class="mt-3 text-lg font-semibold text-ink-900 dark:text-white">{{ $subscription?->plan->name ?? __('dashboard.home.no_plan') }}</p>
                <p class="text-sm text-ink-400">{{ __('dashboard.nav.subscriptions') }}</p>
            </x-card>

            <x-stat icon="clock" :value="$subscription ? $subscription->daysLeft() : '—'" :label="__('dashboard.home.days_left')" />
            <x-stat icon="device-phone" :value="$devicesCount" :label="__('dashboard.home.devices')" />
            <x-stat icon="wifi" :value="$connectionsCount" :label="__('dashboard.home.connections')" />
        </div>

        <div class="grid gap-6 lg:grid-cols-3">
            {{-- Subscription / payments --}}
            <div class="space-y-6 lg:col-span-2">
                @if ($subscription)
                    <x-card padding="p-6">
                        <div class="flex flex-wrap items-center justify-between gap-3">
                            <div>
                                <p class="text-sm text-ink-400">{{ __('dashboard.home.active_plan') }}</p>
                                <p class="text-xl font-semibold text-ink-900 dark:text-white">{{ $subscription->plan->name }}</p>
                            </div>
                            <x-button :href="route('dashboard.subscriptions.renew', $subscription)" icon="arrow-path">{{ __('dashboard.home.renew') }}</x-button>
                        </div>
                        <div class="mt-5">
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-ink-500 dark:text-ink-400">{{ __('dashboard.subscriptions.until') }} {{ $subscription->ends_at?->isoFormat('D MMMM YYYY') }}</span>
                                <span class="font-medium text-ink-700 dark:text-ink-200">{{ $subscription->daysLeft() }} {{ __('common.days_left', ['count' => '']) }}</span>
                            </div>
                            <x-progress :value="min(100, $subscription->daysLeft() / max(1, $subscription->plan->billing_months * 30) * 100)" class="mt-2" />
                        </div>
                    </x-card>
                @else
                    <x-card padding="p-8" class="text-center">
                        <p class="text-lg font-semibold text-ink-900 dark:text-white">{{ __('dashboard.home.no_plan') }}</p>
                        <p class="mt-1 text-sm text-ink-500 dark:text-ink-400">{{ __('dashboard.subscriptions.empty_text') }}</p>
                        <x-button :href="route('pricing')" class="mt-4">{{ __('dashboard.home.choose_plan') }}</x-button>
                    </x-card>
                @endif

                <x-card padding="p-6">
                    <h3 class="text-base font-semibold text-ink-900 dark:text-white">{{ __('dashboard.home.recent_payments') }}</h3>
                    <div class="mt-4">
                        @if ($payments->isNotEmpty())
                            <x-table :headers="[__('dashboard.payments.number'), __('dashboard.payments.amount'), __('common.status'), __('common.date')]">
                                @foreach ($payments as $payment)
                                    <tr>
                                        <td class="px-4 py-3 font-mono text-xs">{{ $payment->number }}</td>
                                        <td class="px-4 py-3 font-medium">{{ format_price($payment->total(), $payment->currency) }}</td>
                                        <td class="px-4 py-3"><x-badge :color="$payment->status->color()">{{ $payment->status->label() }}</x-badge></td>
                                        <td class="px-4 py-3 text-ink-400">{{ $payment->created_at->isoFormat('D MMM YYYY') }}</td>
                                    </tr>
                                @endforeach
                            </x-table>
                        @else
                            <x-empty-state icon="credit-card" :title="__('dashboard.payments.empty')" />
                        @endif
                    </div>
                </x-card>
            </div>

            {{-- Right column --}}
            <div class="space-y-6">
                <x-glass-card padding="p-6">
                    <span class="grid h-11 w-11 place-items-center rounded-xl bg-brand-gradient text-white shadow-glow"><x-icon name="rocket" class="h-6 w-6" /></span>
                    <h3 class="mt-4 text-base font-semibold text-ink-900 dark:text-white">{{ __('dashboard.home.quick_docs') }}</h3>
                    <p class="mt-1.5 text-sm text-ink-500 dark:text-ink-400">{{ __('dashboard.home.quick_docs_text') }}</p>
                    <x-button :href="route('dashboard.connections.index')" variant="secondary" size="sm" class="mt-4" block>{{ __('dashboard.nav.connections') }}</x-button>
                </x-glass-card>

                <x-card padding="p-6">
                    <h3 class="text-base font-semibold text-ink-900 dark:text-white">{{ __('dashboard.nav.notifications') }}</h3>
                    <div class="mt-4 space-y-3">
                        @forelse ($notifications as $n)
                            <div class="flex gap-3">
                                <span class="mt-0.5 grid h-8 w-8 shrink-0 place-items-center rounded-lg bg-brand-500/10 text-brand-600 dark:text-brand-300"><x-icon :name="$n->icon ?: 'bell'" class="h-4 w-4" /></span>
                                <div class="min-w-0">
                                    <p class="truncate text-sm font-medium text-ink-800 dark:text-ink-100">{{ $n->title }}</p>
                                    <p class="line-clamp-1 text-xs text-ink-400">{{ $n->body }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="py-4 text-center text-sm text-ink-400">{{ __('dashboard.notifications.empty') }}</p>
                        @endforelse
                    </div>
                </x-card>
            </div>
        </div>
    </div>
</x-layouts.dashboard>
