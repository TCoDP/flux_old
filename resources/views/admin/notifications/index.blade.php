<x-layouts.admin :title="__('admin.nav.notifications')">
    <x-admin.toolbar :create="route('admin.notifications.create')" :createLabel="__('admin.notifications.create')" />

    <x-card padding="p-6">
        <div class="mb-4 flex items-center justify-between">
            <h3 class="text-base font-semibold text-ink-900 dark:text-white">{{ __('admin.notifications.recent') }}</h3>
            <x-badge color="neutral">{{ __('admin.notifications.total') }}: {{ $sentCount }}</x-badge>
        </div>
        <div class="space-y-2">
            @forelse ($recent as $n)
                <div class="flex items-start gap-3 rounded-xl border border-ink-100 px-4 py-3 dark:border-white/5">
                    <span class="mt-0.5 grid h-8 w-8 place-items-center rounded-lg bg-brand-500/10 text-brand-600 dark:text-brand-300"><x-icon :name="$n->icon ?: 'bell'" class="h-4 w-4" /></span>
                    <div class="min-w-0 flex-1"><p class="text-sm font-medium text-ink-900 dark:text-white">{{ $n->title }}</p><p class="truncate text-xs text-ink-400">{{ $n->user?->name }} · {{ $n->created_at->diffForHumans() }}</p></div>
                </div>
            @empty
                <p class="py-10 text-center text-sm text-ink-400">{{ __('common.empty') }}</p>
            @endforelse
        </div>
    </x-card>
</x-layouts.admin>
