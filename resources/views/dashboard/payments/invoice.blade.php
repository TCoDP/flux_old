<x-layouts.base>
    <div class="mx-auto max-w-2xl px-5 py-12">
        <div class="mb-6 flex items-center justify-between print:hidden">
            <x-logo />
            <x-button onclick="window.print()" variant="secondary" size="sm" icon="document">{{ __('dashboard.payments.invoice') }}</x-button>
        </div>

        <div class="rounded-2xl bg-white p-8 ring-hair shadow-soft dark:bg-ink-900/40">
            <div class="flex items-start justify-between">
                <div>
                    <h1 class="text-2xl font-semibold font-display text-ink-900 dark:text-white">{{ __('dashboard.payments.invoice') }}</h1>
                    <p class="mt-1 font-mono text-sm text-ink-400">{{ $payment->number }}</p>
                </div>
                <x-badge :color="$payment->status->color()">{{ $payment->status->label() }}</x-badge>
            </div>

            <div class="mt-8 grid grid-cols-2 gap-6 text-sm">
                <div>
                    <p class="text-xs uppercase tracking-wide text-ink-400">{{ settings('company_legal') }}</p>
                    <p class="mt-1 text-ink-600 dark:text-ink-300">{{ settings('site_name') }}</p>
                    <p class="text-ink-600 dark:text-ink-300">{{ settings('support_email') }}</p>
                </div>
                <div class="text-right">
                    <p class="text-xs uppercase tracking-wide text-ink-400">{{ $payment->user->name }}</p>
                    <p class="mt-1 text-ink-600 dark:text-ink-300">{{ $payment->user->email }}</p>
                    <p class="text-ink-600 dark:text-ink-300">{{ $payment->created_at->isoFormat('D MMMM YYYY') }}</p>
                </div>
            </div>

            <table class="mt-8 w-full text-sm">
                <thead><tr class="border-b border-ink-200 text-left text-xs uppercase text-ink-400 dark:border-white/10"><th class="py-2">{{ __('dashboard.subscriptions.plan') }}</th><th class="py-2 text-right">{{ __('dashboard.payments.amount') }}</th></tr></thead>
                <tbody>
                    <tr class="border-b border-ink-100 dark:border-white/5"><td class="py-3 text-ink-700 dark:text-ink-200">{{ $payment->plan?->name ?? settings('site_name') }}</td><td class="py-3 text-right text-ink-700 dark:text-ink-200">{{ format_price($payment->amount, $payment->currency) }}</td></tr>
                    @if ($payment->discount > 0)
                        <tr class="border-b border-ink-100 dark:border-white/5"><td class="py-3 text-emerald-600">{{ __('dashboard.checkout.promo') }}</td><td class="py-3 text-right text-emerald-600">−{{ format_price($payment->discount, $payment->currency) }}</td></tr>
                    @endif
                </tbody>
            </table>

            <div class="mt-6 flex justify-end">
                <div class="w-56">
                    <div class="flex justify-between border-t-2 border-ink-900 pt-3 dark:border-white">
                        <span class="font-semibold text-ink-900 dark:text-white">{{ __('dashboard.checkout.total') }}</span>
                        <span class="font-semibold text-ink-900 dark:text-white">{{ format_price($payment->total(), $payment->currency) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.base>
