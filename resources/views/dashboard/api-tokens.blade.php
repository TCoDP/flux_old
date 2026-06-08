<x-layouts.dashboard :title="__('dashboard.api.title')">
    <div class="mx-auto max-w-2xl space-y-6">
        <p class="-mt-2 text-sm text-ink-500 dark:text-ink-400">{{ __('dashboard.api.subtitle') }}</p>

        @if ($createdToken)
            <x-alert type="success" :title="__('dashboard.api.new_token')">
                <p class="mb-2 text-xs">{{ __('dashboard.api.new_token_warn') }}</p>
                <x-copy-field :value="$createdToken" />
            </x-alert>
        @endif

        <x-card padding="p-7">
            <h3 class="text-base font-semibold text-ink-900 dark:text-white">{{ __('dashboard.api.create') }}</h3>
            <form method="POST" action="{{ route('dashboard.api-tokens.store') }}" class="mt-4 flex gap-2">
                @csrf
                <div class="flex-1">
                    <x-input name="name" :value="old('name')" :placeholder="__('dashboard.api.token_name')" error="name" />
                </div>
                <x-button type="submit" icon="plus">{{ __('common.create') }}</x-button>
            </form>
            <p class="mt-3 text-xs text-ink-400">{{ __('dashboard.api.docs_hint') }}</p>
        </x-card>

        <x-card padding="p-6">
            <h3 class="text-base font-semibold text-ink-900 dark:text-white">{{ __('dashboard.api.title') }}</h3>
            <div class="mt-4">
                @if ($tokens->isNotEmpty())
                    <div class="space-y-2">
                        @foreach ($tokens as $token)
                            <div class="flex items-center justify-between rounded-xl border border-ink-100 px-4 py-3 dark:border-white/5">
                                <div class="flex items-center gap-3">
                                    <span class="grid h-9 w-9 place-items-center rounded-lg bg-brand-500/10 text-brand-600 dark:text-brand-300"><x-icon name="key" class="h-4 w-4" /></span>
                                    <div>
                                        <p class="text-sm font-medium text-ink-900 dark:text-white">{{ $token->name }}</p>
                                        <p class="text-xs text-ink-400">{{ __('dashboard.api.last_used') }}: {{ $token->last_used_at?->diffForHumans() ?? '—' }}</p>
                                    </div>
                                </div>
                                <form method="POST" action="{{ route('dashboard.api-tokens.destroy', $token->id) }}">
                                    @csrf @method('DELETE')
                                    <button class="grid h-9 w-9 place-items-center rounded-lg text-ink-400 hover:bg-red-500/10 hover:text-red-500 transition"><x-icon name="trash" class="h-4.5 w-4.5" /></button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="py-6 text-center text-sm text-ink-400">{{ __('dashboard.api.empty') }}</p>
                @endif
            </div>
        </x-card>
    </div>
</x-layouts.dashboard>
