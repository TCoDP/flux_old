<x-layouts.admin :title="__('admin.notifications.create')">
    <div class="mx-auto max-w-2xl">
        <x-card padding="p-7">
            <h2 class="mb-6 text-lg font-semibold text-ink-900 dark:text-white">{{ __('admin.notifications.create') }}</h2>
            <form method="POST" action="{{ route('admin.notifications.store') }}" class="space-y-5">
                @csrf
                <x-field :label="__('admin.notifications.subject')" for="title" error="title"><x-input name="title" :value="old('title')" required /></x-field>
                <x-field :label="__('admin.notifications.body')" for="body" error="body"><x-textarea name="body" rows="3">{{ old('body') }}</x-textarea></x-field>
                <div class="grid gap-5 sm:grid-cols-2">
                    <x-field :label="__('admin.notifications.type')" for="type" error="type">
                        <x-select name="type">
                            @foreach ($types as $type)
                                <option value="{{ $type->value }}">{{ $type->label() }}</option>
                            @endforeach
                        </x-select>
                    </x-field>
                    <x-field :label="__('admin.notifications.audience')" for="audience" error="audience">
                        <x-select name="audience">
                            <option value="all">{{ __('admin.notifications.audience_all') }}</option>
                            <option value="subscribers">{{ __('admin.notifications.audience_subscribers') }}</option>
                        </x-select>
                    </x-field>
                </div>
                <x-field :label="__('admin.notifications.action_url')" for="action_url" error="action_url"><x-input name="action_url" :value="old('action_url')" /></x-field>
                <div class="flex gap-2">
                    <x-button type="submit" icon="bell">{{ __('admin.notifications.send') }}</x-button>
                    <x-button :href="route('admin.notifications.index')" variant="ghost">{{ __('common.cancel') }}</x-button>
                </div>
            </form>
        </x-card>
    </div>
</x-layouts.admin>
