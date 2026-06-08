<x-layouts.admin :title="__('admin.nav.subscriptions')">
    <x-admin.toolbar :create="route('admin.subscriptions.create')" />
    <x-card padding="p-2 sm:p-4">
        <x-table :headers="[__('admin.subscriptions.user'), __('admin.subscriptions.plan'), __('common.status'), __('admin.subscriptions.until'), '']">
            @forelse ($subscriptions as $subscription)
                <tr>
                    <td class="px-4 py-3 font-medium text-ink-900 dark:text-white">{{ $subscription->user?->name ?? '—' }}</td>
                    <td class="px-4 py-3 text-ink-500">{{ $subscription->plan?->name }}</td>
                    <td class="px-4 py-3"><x-badge :color="$subscription->status->color()" dot>{{ $subscription->status->label() }}</x-badge></td>
                    <td class="px-4 py-3 text-ink-400">{{ $subscription->ends_at?->isoFormat('D MMM YYYY') ?? '—' }}</td>
                    <td class="px-4 py-3"><x-admin.row-actions :view="route('admin.subscriptions.show', $subscription)" :edit="route('admin.subscriptions.edit', $subscription)" :destroy="route('admin.subscriptions.destroy', $subscription)" /></td>
                </tr>
            @empty
                <tr><td colspan="5" class="px-4 py-12 text-center text-sm text-ink-400">{{ __('common.empty') }}</td></tr>
            @endforelse
        </x-table>
    </x-card>
    <div class="mt-6">{{ $subscriptions->links() }}</div>
</x-layouts.admin>
