@php $user = auth()->user(); @endphp

@if ($user)
<x-dropdown align="right" width="w-60">
    <x-slot:trigger>
        <button type="button" class="flex items-center gap-2 rounded-xl p-1 pr-2 hover:bg-ink-100 dark:hover:bg-white/5 transition">
            <x-avatar :name="$user->name" :src="$user->avatar" size="h-8 w-8" />
            <x-icon name="chevron-down" class="h-4 w-4 text-ink-400" />
        </button>
    </x-slot:trigger>

    <div class="border-b border-ink-100 dark:border-white/5 px-3 py-2.5">
        <p class="truncate text-sm font-semibold text-ink-900 dark:text-white">{{ $user->name }}</p>
        <p class="truncate text-xs text-ink-400">{{ $user->email }}</p>
    </div>
    <div class="mt-1 space-y-0.5">
        <x-dropdown-link :href="route('dashboard.home')" icon="chart">{{ __('nav.dashboard') }}</x-dropdown-link>
        <x-dropdown-link :href="route('dashboard.profile.edit')" icon="user">{{ __('dashboard.nav.profile') }}</x-dropdown-link>
        <x-dropdown-link :href="route('dashboard.security.edit')" icon="shield">{{ __('dashboard.nav.security') }}</x-dropdown-link>
        @if ($user->isAdmin())
            <x-dropdown-link :href="route('admin.dashboard')" icon="cog">{{ __('nav.admin') }}</x-dropdown-link>
        @endif
    </div>
    <div class="mt-1 border-t border-ink-100 dark:border-white/5 pt-1">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex w-full items-center gap-2.5 rounded-lg px-3 py-2 text-sm text-red-500 hover:bg-red-500/10 transition">
                <x-icon name="logout" class="h-4.5 w-4.5" /> {{ __('nav.logout') }}
            </button>
        </form>
    </div>
</x-dropdown>
@endif
