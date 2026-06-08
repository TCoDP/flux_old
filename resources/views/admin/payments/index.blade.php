<x-layouts.admin :title="__('admin.nav.payments')">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <form method="GET" class="flex gap-2">
            <x-select name="status" onchange="this.form.submit()" class="w-44">
                <option value="">{{ __('common.all') }}</option>
                @foreach ($statuses as $status)
                    <option value="{{ $status->value }}" @selected(request('status') === $status->value)>{{ $status->label() }}</option>
                @endforeach
            </x-select>
        </form>
        <x-badge color="success">{{ __('admin.payments.total_paid') }}: {{ format_price($totalPaid) }}</x-badge>
    </div>

    <x-card padding="p-2 sm:p-4">
        <x-table :headers="[__('admin.payments.number'), __('admin.payments.user'), __('admin.payments.amount'), __('admin.payments.method'), __('common.status'), __('common.date'), '']">
            @forelse ($payments as $payment)
                <tr>
                    <td class="px-4 py-3 font-mono text-xs">{{ $payment->number }}</td>
                    <td class="px-4 py-3">{{ $payment->user?->name ?? '—' }}</td>
                    <td class="px-4 py-3 font-medium">{{ format_price($payment->total(), $payment->currency) }}</td>
                    <td class="px-4 py-3">{{ $payment->method->label() }}</td>
                    <td class="px-4 py-3"><x-badge :color="$payment->status->color()" size="sm">{{ $payment->status->label() }}</x-badge></td>
                    <td class="px-4 py-3 text-ink-400">{{ $payment->created_at->isoFormat('D MMM YYYY') }}</td>
                    <td class="px-4 py-3"><x-admin.row-actions :view="route('admin.payments.show', $payment)" /></td>
                </tr>
            @empty
                <tr><td colspan="7" class="px-4 py-12 text-center text-sm text-ink-400">{{ __('common.empty') }}</td></tr>
            @endforelse
        </x-table>
    </x-card>
    <div class="mt-6">{{ $payments->links() }}</div>
</x-layouts.admin>
