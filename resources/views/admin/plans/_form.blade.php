@php $plan = $plan ?? null; @endphp
<div class="mx-auto max-w-2xl">
    <x-card padding="p-7">
        <h2 class="mb-6 text-lg font-semibold text-ink-900 dark:text-white">{{ $plan ? __('admin.edit') : __('admin.new') }}</h2>
        <form method="POST" action="{{ $plan ? route('admin.plans.update', $plan) : route('admin.plans.store') }}" class="space-y-5">
            @csrf
            @if ($plan) @method('PUT') @endif

            <div class="grid gap-5 sm:grid-cols-2">
                <x-field :label="__('admin.plans.name')" for="name" error="name">
                    <x-input name="name" :value="old('name', $plan?->name)" required />
                </x-field>
                <x-field label="Slug" for="slug" error="slug">
                    <x-input name="slug" :value="old('slug', $plan?->slug)" />
                </x-field>
            </div>
            <x-field label="Tagline" for="tagline" error="tagline">
                <x-input name="tagline" :value="old('tagline', $plan?->tagline)" />
            </x-field>
            <div class="grid gap-5 sm:grid-cols-3">
                <x-field :label="__('admin.plans.price')" for="price" error="price">
                    <x-input name="price" type="number" step="0.01" :value="old('price', $plan?->price)" required />
                </x-field>
                <x-field label="Old price" for="old_price" error="old_price">
                    <x-input name="old_price" type="number" step="0.01" :value="old('old_price', $plan?->old_price)" />
                </x-field>
                <x-field :label="__('admin.plans.period')" for="billing_period" error="billing_period">
                    <x-select name="billing_period">
                        @foreach ($periods as $period)
                            <option value="{{ $period->value }}" @selected(old('billing_period', $plan?->billing_period?->value) === $period->value)>{{ $period->label() }}</option>
                        @endforeach
                    </x-select>
                </x-field>
            </div>
            <div class="grid gap-5 sm:grid-cols-3">
                <x-field :label="__('admin.plans.devices')" for="device_limit" error="device_limit">
                    <x-input name="device_limit" type="number" :value="old('device_limit', $plan?->device_limit ?? 5)" required />
                </x-field>
                <x-field label="Trial (дней)" for="trial_days" error="trial_days">
                    <x-input name="trial_days" type="number" :value="old('trial_days', $plan?->trial_days ?? 0)" />
                </x-field>
                <x-field label="Sort" for="sort_order" error="sort_order">
                    <x-input name="sort_order" type="number" :value="old('sort_order', $plan?->sort_order ?? 0)" />
                </x-field>
            </div>
            <x-field :label="__('admin.plans.features_hint')" for="features" error="features">
                <x-textarea name="features" rows="5">{{ old('features', implode("\n", $plan?->features ?? [])) }}</x-textarea>
            </x-field>
            <div class="flex gap-8">
                <x-toggle name="is_popular" :checked="old('is_popular', $plan?->is_popular ?? false)" :label="__('admin.plans.popular')" />
                <x-toggle name="is_active" :checked="old('is_active', $plan?->is_active ?? true)" :label="__('admin.plans.active')" />
            </div>

            <div class="flex gap-2 pt-2">
                <x-button type="submit">{{ __('common.save') }}</x-button>
                <x-button :href="route('admin.plans.index')" variant="ghost">{{ __('common.cancel') }}</x-button>
            </div>
        </form>
    </x-card>
</div>
