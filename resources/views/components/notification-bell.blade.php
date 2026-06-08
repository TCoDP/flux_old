@php
    $user = auth()->user();
    $recent = $user ? $user->notifications()->take(6)->get() : collect();
    $unread = $user ? $user->unreadNotificationsCount() : 0;
@endphp

<x-dropdown align="right" width="w-80">
    <x-slot:trigger>
        <button type="button" class="relative grid h-9 w-9 place-items-center rounded-xl text-ink-500 hover:text-ink-900 hover:bg-ink-100 dark:text-ink-300 dark:hover:text-white dark:hover:bg-white/5 transition">
            <x-icon name="bell" class="h-5 w-5" />
            @if ($unread > 0)
                <span class="absolute -right-0.5 -top-0.5 grid h-4 min-w-4 place-items-center rounded-full bg-red-500 px-1 text-[10px] font-semibold text-white">{{ $unread > 9 ? '9+' : $unread }}</span>
            @endif
        </button>
    </x-slot:trigger>

    <div class="flex items-center justify-between px-3 py-2">
        <p class="text-sm font-semibold text-ink-900 dark:text-white">{{ __('dashboard.nav.notifications') }}</p>
        <a href="{{ route('dashboard.notifications.index') }}" class="text-xs text-brand-600 dark:text-brand-300 hover:underline">{{ __('common.view_all') }}</a>
    </div>
    <div class="max-h-80 overflow-y-auto">
        @forelse ($recent as $n)
            <a href="{{ $n->action_url ?: route('dashboard.notifications.index') }}"
               class="flex gap-3 rounded-lg px-3 py-2.5 hover:bg-ink-100 dark:hover:bg-white/5 transition {{ $n->isRead() ? '' : 'bg-brand-500/5' }}">
                <span class="mt-0.5 grid h-8 w-8 shrink-0 place-items-center rounded-lg bg-brand-500/10 text-brand-600 dark:text-brand-300">
                    <x-icon :name="$n->icon ?: 'bell'" class="h-4 w-4" />
                </span>
                <div class="min-w-0">
                    <p class="truncate text-sm font-medium text-ink-800 dark:text-ink-100">{{ $n->title }}</p>
                    <p class="line-clamp-1 text-xs text-ink-400">{{ $n->body }}</p>
                </div>
            </a>
        @empty
            <p class="px-3 py-8 text-center text-sm text-ink-400">{{ __('dashboard.notifications.empty') }}</p>
        @endforelse
    </div>
</x-dropdown>
