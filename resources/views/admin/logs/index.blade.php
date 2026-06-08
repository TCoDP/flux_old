<x-layouts.admin :title="__('admin.nav.logs')">
    <x-admin.toolbar :search="route('admin.logs.index')" />
    <x-card padding="p-2 sm:p-4">
        <x-table :headers="[__('admin.logs.action'), __('admin.logs.user'), '', __('admin.logs.ip'), __('admin.logs.when')]">
            @forelse ($logs as $log)
                <tr>
                    <td class="px-4 py-3"><span class="rounded-md bg-ink-100 px-2 py-0.5 font-mono text-xs text-ink-600 dark:bg-white/5 dark:text-ink-300">{{ $log->action }}</span></td>
                    <td class="px-4 py-3">{{ $log->user?->name ?? '—' }}</td>
                    <td class="px-4 py-3 text-ink-500">{{ $log->description }}</td>
                    <td class="px-4 py-3 font-mono text-xs text-ink-400">{{ $log->ip_address }}</td>
                    <td class="px-4 py-3 text-ink-400">{{ $log->created_at->isoFormat('D MMM YYYY, HH:mm') }}</td>
                </tr>
            @empty
                <tr><td colspan="5" class="px-4 py-12 text-center text-sm text-ink-400">{{ __('common.empty') }}</td></tr>
            @endforelse
        </x-table>
    </x-card>
    <div class="mt-6">{{ $logs->links() }}</div>
</x-layouts.admin>
