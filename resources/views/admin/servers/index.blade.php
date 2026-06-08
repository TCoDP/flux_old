<x-layouts.admin :title="__('admin.nav.servers')">
    <x-admin.toolbar :create="route('admin.servers.create')" />
    <x-card padding="p-2 sm:p-4">
        <x-table :headers="[__('admin.servers.name'), __('admin.servers.region'), __('common.status'), __('admin.servers.load'), '']">
            @forelse ($servers as $server)
                <tr>
                    <td class="px-4 py-3"><span class="font-medium text-ink-900 dark:text-white">{{ $server->name }}</span><br><span class="text-xs text-ink-400">{{ $server->hostname }}</span></td>
                    <td class="px-4 py-3 text-ink-500">{{ $server->region?->name }}</td>
                    <td class="px-4 py-3"><x-badge :color="$server->status->color()" dot>{{ $server->status->label() }}</x-badge></td>
                    <td class="px-4 py-3"><div class="flex items-center gap-2"><x-progress :value="$server->loadPercent()" class="w-20" /><span class="text-xs text-ink-400">{{ $server->loadPercent() }}%</span></div></td>
                    <td class="px-4 py-3"><x-admin.row-actions :edit="route('admin.servers.edit', $server)" :destroy="route('admin.servers.destroy', $server)" /></td>
                </tr>
            @empty
                <tr><td colspan="5" class="px-4 py-12 text-center text-sm text-ink-400">{{ __('common.empty') }}</td></tr>
            @endforelse
        </x-table>
    </x-card>
</x-layouts.admin>
