@php $promocode = $promocode ?? null; @endphp
<div class="mx-auto max-w-2xl">
    <x-card padding="p-7">
        <h2 class="mb-6 text-lg font-semibold text-ink-900 dark:text-white">{{ $promocode ? __('admin.edit') : __('admin.new') }}</h2>
        <form method="POST" action="{{ $promocode ? route('admin.promocodes.update', $promocode) : route('admin.promocodes.store') }}" class="space-y-5">
            @csrf
            @if ($promocode) @method('PUT') @endif
            <div class="grid gap-5 sm:grid-cols-2">
                <x-field :label="__('admin.promocodes.code')" for="code" error="code"><x-input name="code" class="uppercase" :value="old('code', $promocode?->code)" required /></x-field>
                <x-field :label="__('admin.promocodes.type')" for="type" error="type">
                    <x-select name="type">
                        @foreach ($types as $type)
                            <option value="{{ $type->value }}" @selected(old('type', $promocode?->type?->value) === $type->value)>{{ $type->label() }}</option>
                        @endforeach
                    </x-select>
                </x-field>
                <x-field :label="__('admin.promocodes.value')" for="value" error="value"><x-input name="value" type="number" step="0.01" :value="old('value', $promocode?->value)" required /></x-field>
                <x-field label="Min amount" for="min_amount" error="min_amount"><x-input name="min_amount" type="number" step="0.01" :value="old('min_amount', $promocode?->min_amount)" /></x-field>
                <x-field label="Max uses" for="max_uses" error="max_uses"><x-input name="max_uses" type="number" :value="old('max_uses', $promocode?->max_uses)" /></x-field>
                <x-field label="Per user" for="per_user_limit" error="per_user_limit"><x-input name="per_user_limit" type="number" :value="old('per_user_limit', $promocode?->per_user_limit ?? 1)" /></x-field>
                <x-field label="Starts at" for="starts_at" error="starts_at"><x-input name="starts_at" type="date" :value="old('starts_at', $promocode?->starts_at?->format('Y-m-d'))" /></x-field>
                <x-field label="Expires at" for="expires_at" error="expires_at"><x-input name="expires_at" type="date" :value="old('expires_at', $promocode?->expires_at?->format('Y-m-d'))" /></x-field>
            </div>
            <x-field label="Plan" for="plan_id" error="plan_id">
                <x-select name="plan_id">
                    <option value="">—</option>
                    @foreach ($plans as $plan)
                        <option value="{{ $plan->id }}" @selected(old('plan_id', $promocode?->plan_id) == $plan->id)>{{ $plan->name }}</option>
                    @endforeach
                </x-select>
            </x-field>
            <x-toggle name="is_active" :checked="old('is_active', $promocode?->is_active ?? true)" :label="__('admin.plans.active')" />
            <div class="flex gap-2 pt-2">
                <x-button type="submit">{{ __('common.save') }}</x-button>
                <x-button :href="route('admin.promocodes.index')" variant="ghost">{{ __('common.cancel') }}</x-button>
            </div>
        </form>
    </x-card>
</div>
