<x-layouts.dashboard :title="__('dashboard.payments.title')">
    <p class="-mt-2 mb-6 text-sm text-ink-500 dark:text-ink-400">{{ __('dashboard.payments.subtitle') }}</p>

    @if ($payments->isNotEmpty())
        <x-card padding="p-2 sm:p-4">
            <x-table :headers="[__('dashboard.payments.number'), __('dashboard.subscriptions.plan'), __('dashboard.payments.amount'), __('dashboard.payments.method'), __('common.status'), __('common.date'), '']">
                @foreach ($payments as $payment)
                    <tr>
                        <td class="px-4 py-3 font-mono text-xs">{{ $payment->number }}</td>
                        <td class="px-4 py-3">{{ $payment->plan?->name ?? '—' }}</td>
                        <td class="px-4 py-3 font-medium">{{ format_price($payment->total(), $payment->currency) }}</td>
                        <td class="px-4 py-3">{{ $payment->method->label() }}</td>
                        <td class="px-4 py-3"><x-badge :color="$payment->status->color()">{{ $payment->status->label() }}</x-badge></td>
                        <td class="px-4 py-3 text-ink-400">{{ $payment->created_at->isoFormat('D MMM YYYY') }}</td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('dashboard.payments.show', $payment) }}" class="text-sm text-brand-600 hover:underline dark:text-brand-300">{{ __('common.view_all') }}</a>
                        </td>
                    </tr>
                @endforeach
            </x-table>
        </x-card>
        <div class="mt-6">{{ $payments->links() }}</div>
    @else
        <x-empty-state icon="credit-card" :title="__('dashboard.payments.empty')" />
    @endif
</x-layouts.dashboard>
