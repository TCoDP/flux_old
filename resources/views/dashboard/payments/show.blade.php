<x-layouts.dashboard :title="$payment->number">
    <a href="{{ route('dashboard.payments.index') }}" class="mb-6 inline-flex items-center gap-1.5 text-sm text-ink-500 hover:text-brand-600 dark:text-ink-400">
        <x-icon name="arrow-right" class="h-4 w-4 rotate-180" /> {{ __('common.back') }}
    </a>

    <div class="mx-auto max-w-xl">
        <x-card padding="p-7">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-ink-400">{{ __('dashboard.payments.number') }}</p>
                    <p class="font-mono text-lg font-semibold text-ink-900 dark:text-white">{{ $payment->number }}</p>
                </div>
                <x-badge :color="$payment->status->color()" dot>{{ $payment->status->label() }}</x-badge>
            </div>

            <div class="my-6 border-t border-dashed border-ink-200 dark:border-white/10"></div>

            <dl class="space-y-3 text-sm">
                <div class="flex justify-between"><dt class="text-ink-400">{{ __('dashboard.subscriptions.plan') }}</dt><dd class="font-medium text-ink-800 dark:text-ink-100">{{ $payment->plan?->name ?? '—' }}</dd></div>
                <div class="flex justify-between"><dt class="text-ink-400">{{ __('dashboard.payments.method') }}</dt><dd class="font-medium text-ink-800 dark:text-ink-100">{{ $payment->method->label() }}</dd></div>
                <div class="flex justify-between"><dt class="text-ink-400">{{ __('common.date') }}</dt><dd class="font-medium text-ink-800 dark:text-ink-100">{{ $payment->created_at->isoFormat('D MMMM YYYY, HH:mm') }}</dd></div>
                @if ($payment->discount > 0)
                    <div class="flex justify-between"><dt class="text-ink-400">{{ __('dashboard.checkout.promo') }}</dt><dd class="font-medium text-emerald-500">−{{ format_price($payment->discount, $payment->currency) }}</dd></div>
                @endif
            </dl>

            <div class="my-6 border-t border-dashed border-ink-200 dark:border-white/10"></div>

            <div class="flex items-center justify-between">
                <p class="text-sm text-ink-400">{{ __('dashboard.checkout.total') }}</p>
                <p class="text-2xl font-semibold font-display text-ink-900 dark:text-white">{{ format_price($payment->total(), $payment->currency) }}</p>
            </div>

            <x-button :href="route('dashboard.payments.invoice', $payment)" variant="secondary" class="mt-6" block icon="document">{{ __('dashboard.payments.invoice') }}</x-button>
        </x-card>
    </div>
</x-layouts.dashboard>
