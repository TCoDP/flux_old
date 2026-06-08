<x-layouts.dashboard :title="__('dashboard.devices.title')">
    <div class="mb-6 flex flex-wrap items-end justify-between gap-3">
        <p class="text-sm text-ink-500 dark:text-ink-400">{{ __('dashboard.devices.subtitle') }}</p>
        <x-badge color="neutral">{{ __('dashboard.devices.limit', ['used' => $devices->count(), 'limit' => $limit]) }}</x-badge>
    </div>

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="lg:col-span-2">
            @if ($devices->isNotEmpty())
                <div class="space-y-3">
                    @foreach ($devices as $device)
                        <x-card padding="p-4">
                            <div class="flex items-center justify-between gap-4">
                                <div class="flex items-center gap-3">
                                    <span class="grid h-11 w-11 place-items-center rounded-xl bg-brand-500/10 text-brand-600 dark:text-brand-300"><x-icon :name="$device->platform->icon()" class="h-5 w-5" /></span>
                                    <div>
                                        <p class="font-medium text-ink-900 dark:text-white">{{ $device->name }}</p>
                                        <p class="text-xs text-ink-400">{{ $device->platform->label() }} · {{ $device->last_seen_at?->diffForHumans() }}</p>
                                    </div>
                                </div>
                                <form method="POST" action="{{ route('dashboard.devices.destroy', $device) }}" onsubmit="return confirm('{{ __('admin.confirm_delete') }}')">
                                    @csrf @method('DELETE')
                                    <button class="grid h-9 w-9 place-items-center rounded-lg text-ink-400 hover:bg-red-500/10 hover:text-red-500 transition"><x-icon name="trash" class="h-4.5 w-4.5" /></button>
                                </form>
                            </div>
                        </x-card>
                    @endforeach
                </div>
            @else
                <x-empty-state icon="device-phone" :title="__('dashboard.devices.empty')" :message="__('dashboard.devices.empty_text')" />
            @endif
        </div>

        <x-card padding="p-6" class="h-fit">
            <h3 class="text-base font-semibold text-ink-900 dark:text-white">{{ __('dashboard.devices.add') }}</h3>
            <form method="POST" action="{{ route('dashboard.devices.store') }}" class="mt-4 space-y-4">
                @csrf
                <x-field :label="__('dashboard.devices.name')" for="name" error="name">
                    <x-input name="name" :value="old('name')" required />
                </x-field>
                <x-field :label="__('dashboard.devices.platform')" for="platform" error="platform">
                    <x-select name="platform">
                        @foreach ($platforms as $platform)
                            <option value="{{ $platform->value }}">{{ $platform->label() }}</option>
                        @endforeach
                    </x-select>
                </x-field>
                <x-button type="submit" icon="plus" block>{{ __('common.add') }}</x-button>
            </form>
        </x-card>
    </div>
</x-layouts.dashboard>
