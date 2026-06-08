<x-layouts.admin :title="__('admin.nav.plans')">
    <x-admin.toolbar :create="route('admin.plans.create')" />

    <x-card padding="p-2 sm:p-4">
        <x-table :headers="[__('admin.plans.name'), __('admin.plans.price'), __('admin.plans.period'), __('admin.plans.devices'), __('admin.plans.active'), '']">
            @forelse ($plans as $plan)
                <tr>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-2">
                            <span class="font-medium text-ink-900 dark:text-white">{{ $plan->name }}</span>
                            @if ($plan->is_popular)<x-badge color="brand" size="sm">{{ __('admin.plans.popular') }}</x-badge>@endif
                        </div>
                    </td>
                    <td class="px-4 py-3 font-medium">{{ format_price($plan->price, $plan->currency) }}</td>
                    <td class="px-4 py-3">{{ $plan->billing_period->label() }}</td>
                    <td class="px-4 py-3">{{ $plan->device_limit }}</td>
                    <td class="px-4 py-3"><x-badge :color="$plan->is_active ? 'success' : 'neutral'" size="sm">{{ $plan->is_active ? __('common.yes') : __('common.no') }}</x-badge></td>
                    <td class="px-4 py-3"><x-admin.row-actions :edit="route('admin.plans.edit', $plan)" :destroy="route('admin.plans.destroy', $plan)" /></td>
                </tr>
            @empty
                <tr><td colspan="6" class="px-4 py-12 text-center text-sm text-ink-400">{{ __('common.empty') }}</td></tr>
            @endforelse
        </x-table>
    </x-card>
</x-layouts.admin>
