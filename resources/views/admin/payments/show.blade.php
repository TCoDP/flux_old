<x-layouts.admin :title="$payment->number">
    <div class="mx-auto max-w-xl space-y-6">
        <x-card padding="p-7">
            <div class="flex items-center justify-between">
                <p class="font-mono text-lg font-semibold text-ink-900 dark:text-white">{{ $payment->number }}</p>
                <x-badge :color="$payment->status->color()" dot>{{ $payment->status->label() }}</x-badge>
            </div>
            <dl class="mt-5 space-y-3 text-sm">
                <div class="flex justify-between"><dt class="text-ink-400">{{ __('admin.payments.user') }}</dt><dd class="font-medium text-ink-800 dark:text-ink-100">{{ $payment->user?->name }}</dd></div>
                <div class="flex justify-between"><dt class="text-ink-400">{{ __('dashboard.subscriptions.plan') }}</dt><dd class="font-medium text-ink-800 dark:text-ink-100">{{ $payment->plan?->name ?? '—' }}</dd></div>
                <div class="flex justify-between"><dt class="text-ink-400">{{ __('admin.payments.method') }}</dt><dd class="font-medium text-ink-800 dark:text-ink-100">{{ $payment->method->label() }}</dd></div>
                <div class="flex justify-between"><dt class="text-ink-400">{{ __('admin.payments.amount') }}</dt><dd class="font-medium text-ink-800 dark:text-ink-100">{{ format_price($payment->total(), $payment->currency) }}</dd></div>
            </dl>
        </x-card>

        <x-card padding="p-7">
            <h3 class="text-base font-semibold text-ink-900 dark:text-white">{{ __('admin.payments.change_status') }}</h3>
            <form method="POST" action="{{ route('admin.payments.update', $payment) }}" class="mt-4 flex gap-2">
                @csrf @method('PATCH')
                <x-select name="status" class="flex-1">
                    @foreach (\App\Enums\PaymentStatus::cases() as $status)
                        <option value="{{ $status->value }}" @selected($payment->status === $status)>{{ $status->label() }}</option>
                    @endforeach
                </x-select>
                <x-button type="submit">{{ __('common.save') }}</x-button>
            </form>
        </x-card>
    </div>
</x-layouts.admin>
