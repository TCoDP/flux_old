@php $region = $region ?? null; @endphp
<div class="mx-auto max-w-2xl">
    <x-card padding="p-7">
        <h2 class="mb-6 text-lg font-semibold text-ink-900 dark:text-white">{{ $region ? __('admin.edit') : __('admin.new') }}</h2>
        <form method="POST" action="{{ $region ? route('admin.regions.update', $region) : route('admin.regions.store') }}" class="space-y-5">
            @csrf
            @if ($region) @method('PUT') @endif
            <div class="grid gap-5 sm:grid-cols-2">
                <x-field :label="__('admin.regions.name')" for="name" error="name"><x-input name="name" :value="old('name', $region?->name)" required /></x-field>
                <x-field :label="__('admin.regions.city')" for="city" error="city"><x-input name="city" :value="old('city', $region?->city)" /></x-field>
                <x-field label="Country code" for="country_code" error="country_code"><x-input name="country_code" maxlength="2" :value="old('country_code', $region?->country_code)" /></x-field>
                <x-field :label="__('admin.regions.flag')" for="flag" error="flag"><x-input name="flag" :value="old('flag', $region?->flag)" /></x-field>
                <x-field label="Latitude" for="latitude" error="latitude"><x-input name="latitude" type="number" step="0.0000001" :value="old('latitude', $region?->latitude)" /></x-field>
                <x-field label="Longitude" for="longitude" error="longitude"><x-input name="longitude" type="number" step="0.0000001" :value="old('longitude', $region?->longitude)" /></x-field>
                <x-field :label="__('admin.regions.load')" for="load_percent" error="load_percent"><x-input name="load_percent" type="number" min="0" max="100" :value="old('load_percent', $region?->load_percent ?? 0)" /></x-field>
                <x-field label="Sort" for="sort_order" error="sort_order"><x-input name="sort_order" type="number" :value="old('sort_order', $region?->sort_order ?? 0)" /></x-field>
            </div>
            <x-toggle name="is_active" :checked="old('is_active', $region?->is_active ?? true)" :label="__('admin.plans.active')" />
            <div class="flex gap-2 pt-2">
                <x-button type="submit">{{ __('common.save') }}</x-button>
                <x-button :href="route('admin.regions.index')" variant="ghost">{{ __('common.cancel') }}</x-button>
            </div>
        </form>
    </x-card>
</div>
