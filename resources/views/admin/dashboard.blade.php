<x-layouts.admin :title="__('admin.dashboard.title')">
    <p class="-mt-2 mb-6 text-sm text-ink-500 dark:text-ink-400">{{ __('admin.dashboard.subtitle') }}</p>

    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <x-stat icon="users" :value="number_format($usersCount, 0, '.', ' ')" :label="__('admin.dashboard.users')" />
        <x-stat icon="sparkles" :value="$activeSubscriptions" :label="__('admin.dashboard.active_subs')" />
        <x-stat icon="currency" :value="format_price($revenue)" :label="__('admin.dashboard.revenue')" />
        <x-stat icon="clock" :value="$pendingPayments" :label="__('admin.dashboard.pending')" />
    </div>

    <div class="mt-6 grid gap-6 lg:grid-cols-3">
        {{-- Revenue chart --}}
        <x-card padding="p-6" class="lg:col-span-2">
            <div class="flex items-center justify-between">
                <h3 class="text-base font-semibold text-ink-900 dark:text-white">{{ __('admin.dashboard.revenue_14d') }}</h3>
                <x-badge color="success">{{ format_price($revenue) }}</x-badge>
            </div>
            @php $max = collect($revenueSeries)->max() ?: 1; @endphp
            <div class="mt-6 flex h-44 items-end gap-1.5">
                @forelse ($revenueSeries as $day => $total)
                    <div class="group flex flex-1 flex-col items-center justify-end gap-2">
                        <div class="w-full rounded-t-md bg-brand-gradient transition-all hover:opacity-80" style="height: {{ max(4, $total / $max * 100) }}%" title="{{ format_price($total) }}"></div>
                    </div>
                @empty
                    <p class="w-full py-12 text-center text-sm text-ink-400">{{ __('common.empty') }}</p>
                @endforelse
            </div>
        </x-card>

        {{-- Servers --}}
        <x-card padding="p-6">
            <h3 class="text-base font-semibold text-ink-900 dark:text-white">{{ __('admin.nav.servers') }}</h3>
            <div class="mt-6 flex flex-col items-center">
                <div class="relative grid h-32 w-32 place-items-center">
                    <svg class="h-32 w-32 -rotate-90" viewBox="0 0 36 36">
                        <circle cx="18" cy="18" r="15.9" fill="none" class="stroke-ink-100 dark:stroke-white/10" stroke-width="3" />
                        <circle cx="18" cy="18" r="15.9" fill="none" stroke="url(#g)" stroke-width="3" stroke-linecap="round"
                                stroke-dasharray="{{ $serversTotal ? round($serversOnline / $serversTotal * 100) : 0 }}, 100" />
                        <defs><linearGradient id="g"><stop offset="0%" stop-color="#5b50e8" /><stop offset="100%" stop-color="#22d3ee" /></linearGradient></defs>
                    </svg>
                    <div class="absolute text-center">
                        <p class="text-2xl font-semibold text-ink-900 dark:text-white">{{ $serversOnline }}</p>
                        <p class="text-xs text-ink-400">/ {{ $serversTotal }}</p>
                    </div>
                </div>
                <p class="mt-3 text-sm text-ink-500 dark:text-ink-400">{{ __('admin.dashboard.servers') }}</p>
            </div>
        </x-card>
    </div>

    <div class="mt-6 grid gap-6 lg:grid-cols-2">
        <x-card padding="p-6">
            <h3 class="text-base font-semibold text-ink-900 dark:text-white">{{ __('admin.dashboard.recent_users') }}</h3>
            <div class="mt-4 space-y-2.5">
                @foreach ($recentUsers as $user)
                    <div class="flex items-center gap-3">
                        <x-avatar :name="$user->name" :src="$user->avatar" size="h-9 w-9" />
                        <div class="min-w-0 flex-1"><p class="truncate text-sm font-medium text-ink-800 dark:text-ink-100">{{ $user->name }}</p><p class="truncate text-xs text-ink-400">{{ $user->email }}</p></div>
                        <span class="text-xs text-ink-400">{{ $user->created_at->isoFormat('D MMM') }}</span>
                    </div>
                @endforeach
            </div>
        </x-card>

        <x-card padding="p-6">
            <h3 class="text-base font-semibold text-ink-900 dark:text-white">{{ __('admin.dashboard.recent_payments') }}</h3>
            <div class="mt-4 space-y-2.5">
                @foreach ($recentPayments as $payment)
                    <div class="flex items-center justify-between text-sm">
                        <div class="min-w-0"><p class="truncate text-ink-700 dark:text-ink-200">{{ $payment->user?->name ?? '—' }}</p><p class="text-xs text-ink-400">{{ $payment->plan?->name }}</p></div>
                        <div class="text-right"><p class="font-medium text-ink-800 dark:text-ink-100">{{ format_price($payment->total(), $payment->currency) }}</p><x-badge :color="$payment->status->color()" size="sm">{{ $payment->status->label() }}</x-badge></div>
                    </div>
                @endforeach
            </div>
        </x-card>
    </div>
</x-layouts.admin>
