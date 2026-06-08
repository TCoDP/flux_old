@php $server = $server ?? null; @endphp
<div class="mx-auto max-w-2xl">
    <x-card padding="p-7">
        <h2 class="mb-6 text-lg font-semibold text-ink-900 dark:text-white">{{ $server ? __('admin.edit') : __('admin.new') }}</h2>
        <form method="POST" action="{{ $server ? route('admin.servers.update', $server) : route('admin.servers.store') }}" class="space-y-5">
            @csrf
            @if ($server) @method('PUT') @endif
            <div class="grid gap-5 sm:grid-cols-2">
                <x-field :label="__('admin.servers.region')" for="region_id" error="region_id">
                    <x-select name="region_id">
                        @foreach ($regions as $region)
                            <option value="{{ $region->id }}" @selected(old('region_id', $server?->region_id) == $region->id)>{{ $region->name }}</option>
                        @endforeach
                    </x-select>
                </x-field>
                <x-field :label="__('admin.servers.name')" for="name" error="name"><x-input name="name" :value="old('name', $server?->name)" required /></x-field>
                <x-field :label="__('admin.servers.hostname')" for="hostname" error="hostname"><x-input name="hostname" :value="old('hostname', $server?->hostname)" /></x-field>
                <x-field :label="__('common.status')" for="status" error="status">
                    <x-select name="status">
                        @foreach ($statuses as $status)
                            <option value="{{ $status->value }}" @selected(old('status', $server?->status?->value) === $status->value)>{{ $status->label() }}</option>
                        @endforeach
                    </x-select>
                </x-field>
                <x-field :label="__('admin.servers.capacity')" for="capacity" error="capacity"><x-input name="capacity" type="number" :value="old('capacity', $server?->capacity ?? 1000)" required /></x-field>
                <x-field label="Current load" for="current_load" error="current_load"><x-input name="current_load" type="number" :value="old('current_load', $server?->current_load ?? 0)" /></x-field>
            </div>
            <x-toggle name="is_active" :checked="old('is_active', $server?->is_active ?? true)" :label="__('admin.plans.active')" />
            <div class="flex gap-2 pt-2">
                <x-button type="submit">{{ __('common.save') }}</x-button>
                <x-button :href="route('admin.servers.index')" variant="ghost">{{ __('common.cancel') }}</x-button>
            </div>
        </form>
    </x-card>
</div>
