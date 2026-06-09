<x-layouts.dashboard :title="__('dashboard.connections.title')">
    <p class="-mt-2 mb-6 text-sm text-ink-500 dark:text-ink-400">{{ __('dashboard.connections.subtitle') }}</p>

    @if ($connections->isNotEmpty())
        <div class="grid gap-5 md:grid-cols-2">
            @foreach ($connections as $connection)
                <x-card padding="p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <span class="grid h-11 w-11 place-items-center rounded-xl bg-brand-500/10 text-brand-600 dark:text-brand-300"><x-icon name="wifi" class="h-5 w-5" /></span>
                            <div>
                                <p class="font-semibold text-ink-900 dark:text-white">{{ $connection->name }}</p>
                                <p class="text-xs text-ink-400"><x-icon name="map-pin" class="inline h-3.5 w-3.5" /> {{ $connection->server?->region?->name ?? '—' }}</p>
                            </div>
                        </div>
                        <x-badge :color="$connection->status->color()" dot>{{ $connection->status->label() }}</x-badge>
                    </div>

                    <div class="mt-5">
                        <x-copy-field :label="__('dashboard.connections.config_link')" :value="$connection->primaryLink()" />
                    </div>

                    <div class="mt-5 flex items-center justify-between">
                        <span class="text-xs text-ink-400">↑ {{ number_format($connection->bytes_up / 1048576, 0, '.', ' ') }} MB · ↓ {{ number_format($connection->bytes_down / 1048576, 0, '.', ' ') }} MB</span>
                        <x-button :href="route('dashboard.connections.show', $connection)" variant="ghost" size="sm" icon="search">{{ __('dashboard.connections.details') }}</x-button>
                    </div>
                </x-card>
            @endforeach
        </div>
    @else
        <x-empty-state icon="wifi" :title="__('dashboard.connections.empty')" :message="__('dashboard.connections.empty_text')" />
    @endif
</x-layouts.dashboard>
