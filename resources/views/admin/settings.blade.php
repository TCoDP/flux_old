<x-layouts.admin :title="__('admin.settings.title')">
    <div class="mx-auto max-w-2xl">
        <x-card padding="p-7">
            <h2 class="text-lg font-semibold text-ink-900 dark:text-white">{{ __('admin.settings.title') }}</h2>
            <p class="mt-1 text-sm text-ink-500 dark:text-ink-400">{{ __('admin.settings.subtitle') }}</p>
            <form method="POST" action="{{ route('admin.settings.update') }}" class="mt-6 space-y-5">
                @csrf @method('PUT')
                <div class="grid gap-5 sm:grid-cols-2">
                    @foreach ($keys as $key)
                        <x-field :label="__('admin.settings.labels.'.$key)" for="{{ $key }}" error="{{ $key }}">
                            <x-input name="{{ $key }}" :value="old($key, $settings[$key] ?? '')" />
                        </x-field>
                    @endforeach
                </div>
                <x-button type="submit">{{ __('common.save_changes') }}</x-button>
            </form>
        </x-card>
    </div>
</x-layouts.admin>
