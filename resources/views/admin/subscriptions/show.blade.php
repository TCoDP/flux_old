<x-layouts.admin :title="$subscription->plan?->name ?? '—'">
    <div class="mx-auto max-w-3xl space-y-6">
        <x-card padding="p-7">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-ink-900 dark:text-white">{{ $subscription->user?->name }}</h2>
                <x-badge :color="$subscription->status->color()" dot>{{ $subscription->status->label() }}</x-badge>
            </div>
            <dl class="mt-5 grid gap-4 sm:grid-cols-2 text-sm">
                <div><dt class="text-ink-400">{{ __('admin.subscriptions.plan') }}</dt><dd class="mt-0.5 font-medium text-ink-800 dark:text-ink-100">{{ $subscription->plan?->name }}</dd></div>
                <div><dt class="text-ink-400">{{ __('admin.subscriptions.until') }}</dt><dd class="mt-0.5 font-medium text-ink-800 dark:text-ink-100">{{ $subscription->ends_at?->isoFormat('D MMMM YYYY') ?? '—' }}</dd></div>
                <div><dt class="text-ink-400">{{ __('admin.nav.connections') ?? 'Connections' }}</dt><dd class="mt-0.5 font-medium text-ink-800 dark:text-ink-100">{{ $subscription->connections->count() }}</dd></div>
                <div><dt class="text-ink-400">{{ __('admin.nav.payments') }}</dt><dd class="mt-0.5 font-medium text-ink-800 dark:text-ink-100">{{ $subscription->payments->count() }}</dd></div>
            </dl>
            <x-button :href="route('admin.subscriptions.edit', $subscription)" class="mt-6">{{ __('common.edit') }}</x-button>
        </x-card>
    </div>
</x-layouts.admin>
