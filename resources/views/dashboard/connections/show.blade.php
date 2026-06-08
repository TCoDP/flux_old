<x-layouts.dashboard :title="$connection->name">
    <a href="{{ route('dashboard.connections.index') }}" class="mb-6 inline-flex items-center gap-1.5 text-sm text-ink-500 hover:text-brand-600 dark:text-ink-400">
        <x-icon name="arrow-right" class="h-4 w-4 rotate-180" /> {{ __('common.back') }}
    </a>

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="lg:col-span-2">
            <x-card padding="p-6">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-ink-900 dark:text-white">{{ __('dashboard.connections.access_data') }}</h3>
                    <x-badge :color="$connection->status->color()" dot>{{ $connection->status->label() }}</x-badge>
                </div>
                <div class="mt-5 space-y-3">
                    <x-copy-field label="Server" :value="$connection->server?->hostname ?? 'flux.net'" />
                    <x-copy-field label="UUID" :value="$connection->uuid" />
                    <x-copy-field label="Key" :value="$connection->access_token" />
                </div>
                <form method="POST" action="{{ route('dashboard.connections.regenerate', $connection) }}" class="mt-6">
                    @csrf
                    <x-button type="submit" variant="secondary" icon="arrow-path">{{ __('dashboard.connections.regenerate') }}</x-button>
                </form>
            </x-card>
        </div>

        <div class="space-y-4">
            <x-stat icon="chart" :value="number_format($connection->totalTraffic() / 1048576, 0, '.', ' ').' MB'" :label="__('dashboard.connections.traffic')" />
            <x-card padding="p-5">
                <p class="text-xs text-ink-400">{{ __('dashboard.connections.region') }}</p>
                <p class="mt-1 font-medium text-ink-900 dark:text-white">{{ $connection->server?->region?->name ?? '—' }}</p>
                <p class="mt-3 text-xs text-ink-400">{{ __('dashboard.connections.last_handshake') }}</p>
                <p class="mt-1 font-medium text-ink-900 dark:text-white">{{ $connection->last_handshake_at?->diffForHumans() ?? '—' }}</p>
            </x-card>
        </div>
    </div>
</x-layouts.dashboard>
