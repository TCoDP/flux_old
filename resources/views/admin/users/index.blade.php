<x-layouts.admin :title="__('admin.nav.users')">
    <x-admin.toolbar :search="route('admin.users.index')" :create="route('admin.users.create')" />

    <x-card padding="p-2 sm:p-4">
        <x-table :headers="[__('admin.users.name'), __('admin.users.email'), __('admin.users.role'), __('admin.users.subscriptions'), __('admin.users.registered'), '']">
            @forelse ($users as $user)
                <tr>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-3">
                            <x-avatar :name="$user->name" :src="$user->avatar" size="h-9 w-9" />
                            <span class="font-medium text-ink-900 dark:text-white">{{ $user->name }}</span>
                            @if ($user->banned_at)<x-badge color="danger" size="sm">ban</x-badge>@endif
                        </div>
                    </td>
                    <td class="px-4 py-3 text-ink-500">{{ $user->email }}</td>
                    <td class="px-4 py-3"><x-badge :color="$user->role->color()">{{ $user->role->label() }}</x-badge></td>
                    <td class="px-4 py-3">{{ $user->subscriptions_count }}</td>
                    <td class="px-4 py-3 text-ink-400">{{ $user->created_at->isoFormat('D MMM YYYY') }}</td>
                    <td class="px-4 py-3"><x-admin.row-actions :edit="route('admin.users.edit', $user)" :destroy="route('admin.users.destroy', $user)" /></td>
                </tr>
            @empty
                <tr><td colspan="6" class="px-4 py-12 text-center text-sm text-ink-400">{{ __('common.empty') }}</td></tr>
            @endforelse
        </x-table>
    </x-card>

    <div class="mt-6">{{ $users->links() }}</div>
</x-layouts.admin>
