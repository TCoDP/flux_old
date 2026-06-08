@php $subscription = $subscription ?? null; @endphp
<div class="mx-auto max-w-2xl">
    <x-card padding="p-7">
        <h2 class="mb-6 text-lg font-semibold text-ink-900 dark:text-white">{{ $subscription ? __('admin.edit') : __('admin.new') }}</h2>
        <form method="POST" action="{{ $subscription ? route('admin.subscriptions.update', $subscription) : route('admin.subscriptions.store') }}" class="space-y-5">
            @csrf
            @if ($subscription) @method('PUT') @endif
            <div class="grid gap-5 sm:grid-cols-2">
                <x-field :label="__('admin.subscriptions.user')" for="user_id" error="user_id">
                    <x-select name="user_id">
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" @selected(old('user_id', $subscription?->user_id) == $user->id)>{{ $user->name }}</option>
                        @endforeach
                    </x-select>
                </x-field>
                <x-field :label="__('admin.subscriptions.plan')" for="plan_id" error="plan_id">
                    <x-select name="plan_id">
                        @foreach ($plans as $plan)
                            <option value="{{ $plan->id }}" @selected(old('plan_id', $subscription?->plan_id) == $plan->id)>{{ $plan->name }}</option>
                        @endforeach
                    </x-select>
                </x-field>
                <x-field :label="__('common.status')" for="status" error="status">
                    <x-select name="status">
                        @foreach ($statuses as $status)
                            <option value="{{ $status->value }}" @selected(old('status', $subscription?->status?->value) === $status->value)>{{ $status->label() }}</option>
                        @endforeach
                    </x-select>
                </x-field>
                <x-field label="Auto-renew" for="auto_renew" error="auto_renew" class="flex items-center pt-7">
                    <x-toggle name="auto_renew" :checked="old('auto_renew', $subscription?->auto_renew ?? true)" />
                </x-field>
                <x-field label="Starts at" for="starts_at" error="starts_at"><x-input name="starts_at" type="date" :value="old('starts_at', $subscription?->starts_at?->format('Y-m-d'))" /></x-field>
                <x-field label="Ends at" for="ends_at" error="ends_at"><x-input name="ends_at" type="date" :value="old('ends_at', $subscription?->ends_at?->format('Y-m-d'))" /></x-field>
            </div>
            <div class="flex gap-2 pt-2">
                <x-button type="submit">{{ __('common.save') }}</x-button>
                <x-button :href="route('admin.subscriptions.index')" variant="ghost">{{ __('common.cancel') }}</x-button>
            </div>
        </form>
    </x-card>
</div>
