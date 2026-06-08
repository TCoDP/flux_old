<x-layouts.dashboard :title="__('dashboard.profile.title')">
    <div class="mx-auto max-w-2xl space-y-6">
        <x-card padding="p-7">
            <h3 class="text-base font-semibold text-ink-900 dark:text-white">{{ __('dashboard.profile.title') }}</h3>
            <p class="mt-1 text-sm text-ink-500 dark:text-ink-400">{{ __('dashboard.profile.subtitle') }}</p>

            <form method="POST" action="{{ route('dashboard.profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-5">
                @csrf @method('PUT')
                <div class="flex items-center gap-4">
                    <x-avatar :name="$user->name" :src="$user->avatar" size="h-16 w-16" />
                    <div class="flex-1">
                        <x-field :label="__('dashboard.profile.avatar')" for="avatar" error="avatar">
                            <input type="file" name="avatar" accept="image/*" class="block w-full text-sm text-ink-500 file:mr-4 file:rounded-lg file:border-0 file:bg-brand-500/10 file:px-4 file:py-2 file:text-sm file:font-medium file:text-brand-600 hover:file:bg-brand-500/20 dark:file:text-brand-300">
                        </x-field>
                    </div>
                </div>
                <div class="grid gap-5 sm:grid-cols-2">
                    <x-field :label="__('dashboard.profile.name')" for="name" error="name">
                        <x-input name="name" :value="old('name', $user->name)" required />
                    </x-field>
                    <x-field :label="__('dashboard.profile.email')" for="email" error="email">
                        <x-input name="email" type="email" :value="old('email', $user->email)" required />
                    </x-field>
                    <x-field :label="__('dashboard.profile.phone')" for="phone" error="phone">
                        <x-input name="phone" :value="old('phone', $user->phone)" />
                    </x-field>
                    <x-field :label="__('dashboard.profile.language')" for="locale" error="locale">
                        <x-select name="locale">
                            <option value="ru" @selected($user->locale === 'ru')>Русский</option>
                            <option value="en" @selected($user->locale === 'en')>English</option>
                        </x-select>
                    </x-field>
                </div>
                <x-button type="submit">{{ __('common.save_changes') }}</x-button>
            </form>
        </x-card>

        <x-card padding="p-7" class="border border-red-500/20">
            <h3 class="text-base font-semibold text-red-600 dark:text-red-400">{{ __('dashboard.profile.danger') }}</h3>
            <p class="mt-1 text-sm text-ink-500 dark:text-ink-400">{{ __('dashboard.profile.danger_text') }}</p>
            <x-button variant="danger" class="mt-4" x-data @click="$dispatch('open-modal', 'delete-account')">{{ __('dashboard.profile.delete') }}</x-button>
        </x-card>
    </div>

    <x-modal name="delete-account" :title="__('dashboard.profile.delete')">
        <form method="POST" action="{{ route('dashboard.profile.destroy') }}" class="space-y-4">
            @csrf @method('DELETE')
            <p class="text-sm text-ink-500 dark:text-ink-400">{{ __('dashboard.profile.danger_text') }}</p>
            <x-field :label="__('dashboard.profile.delete_confirm')" for="password" error="password">
                <x-input name="password" type="password" required />
            </x-field>
            <div class="flex justify-end gap-2">
                <x-button type="button" variant="ghost" x-on:click="$dispatch('close-modal', 'delete-account')">{{ __('common.cancel') }}</x-button>
                <x-button type="submit" variant="danger">{{ __('dashboard.profile.delete') }}</x-button>
            </div>
        </form>
    </x-modal>
</x-layouts.dashboard>
