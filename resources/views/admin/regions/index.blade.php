<x-layouts.admin :title="__('admin.nav.regions')">
    <x-admin.toolbar :create="route('admin.regions.create')" />
    <x-card padding="p-2 sm:p-4">
        <x-table :headers="[__('admin.regions.name'), __('admin.regions.city'), __('admin.regions.load'), __('admin.regions.servers'), __('admin.plans.active'), '']">
            @forelse ($regions as $region)
                <tr>
                    <td class="px-4 py-3"><span class="mr-2">{{ $region->flag }}</span><span class="font-medium text-ink-900 dark:text-white">{{ $region->name }}</span></td>
                    <td class="px-4 py-3 text-ink-500">{{ $region->city }}</td>
                    <td class="px-4 py-3"><div class="flex items-center gap-2"><x-progress :value="$region->load_percent" class="w-20" /><span class="text-xs text-ink-400">{{ $region->load_percent }}%</span></div></td>
                    <td class="px-4 py-3">{{ $region->servers_count }}</td>
                    <td class="px-4 py-3"><x-badge :color="$region->is_active ? 'success' : 'neutral'" size="sm">{{ $region->is_active ? __('common.yes') : __('common.no') }}</x-badge></td>
                    <td class="px-4 py-3"><x-admin.row-actions :edit="route('admin.regions.edit', $region)" :destroy="route('admin.regions.destroy', $region)" /></td>
                </tr>
            @empty
                <tr><td colspan="6" class="px-4 py-12 text-center text-sm text-ink-400">{{ __('common.empty') }}</td></tr>
            @endforelse
        </x-table>
    </x-card>
</x-layouts.admin>
