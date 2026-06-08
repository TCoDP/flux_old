<x-layouts.dashboard :title="__('dashboard.notifications.title')">
    <div class="mb-6 flex items-center justify-between">
        <p class="text-sm text-ink-500 dark:text-ink-400">{{ __('dashboard.notifications.subtitle') }}</p>
        <form method="POST" action="{{ route('dashboard.notifications.read-all') }}">
            @csrf @method('PATCH')
            <x-button type="submit" variant="ghost" size="sm" icon="check">{{ __('dashboard.notifications.mark_all') }}</x-button>
        </form>
    </div>

    @if ($notifications->isNotEmpty())
        <div class="space-y-2.5">
            @foreach ($notifications as $n)
                <x-card padding="p-4" class="{{ $n->isRead() ? '' : 'ring-1 ring-brand-500/20' }}">
                    <div class="flex items-start gap-4">
                        <span class="grid h-10 w-10 shrink-0 place-items-center rounded-xl bg-brand-500/10 text-brand-600 dark:text-brand-300"><x-icon :name="$n->icon ?: 'bell'" class="h-5 w-5" /></span>
                        <div class="min-w-0 flex-1">
                            <div class="flex items-center gap-2">
                                <p class="font-medium text-ink-900 dark:text-white">{{ $n->title }}</p>
                                @unless ($n->isRead())<span class="h-2 w-2 rounded-full bg-brand-500"></span>@endunless
                            </div>
                            <p class="mt-0.5 text-sm text-ink-500 dark:text-ink-400">{{ $n->body }}</p>
                            <p class="mt-1.5 text-xs text-ink-400">{{ $n->created_at->diffForHumans() }}</p>
                        </div>
                        @unless ($n->isRead())
                            <form method="POST" action="{{ route('dashboard.notifications.read', $n) }}">
                                @csrf @method('PATCH')
                                <button class="text-xs text-brand-600 hover:underline dark:text-brand-300">{{ __('common.confirm') }}</button>
                            </form>
                        @endunless
                    </div>
                </x-card>
            @endforeach
        </div>
        <div class="mt-6">{{ $notifications->links() }}</div>
    @else
        <x-empty-state icon="bell" :title="__('dashboard.notifications.empty')" />
    @endif
</x-layouts.dashboard>
