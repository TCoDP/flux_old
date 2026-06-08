<x-layouts.dashboard :title="__('dashboard.security.title')">
    <div class="mx-auto max-w-2xl space-y-6">
        {{-- Password --}}
        <x-card padding="p-7">
            <h3 class="text-base font-semibold text-ink-900 dark:text-white">{{ __('dashboard.security.password') }}</h3>
            <form method="POST" action="{{ route('dashboard.security.password') }}" class="mt-5 space-y-5">
                @csrf @method('PUT')
                <x-field :label="__('dashboard.security.current_password')" for="current_password" error="current_password">
                    <x-input name="current_password" type="password" icon="lock" required />
                </x-field>
                <div class="grid gap-5 sm:grid-cols-2">
                    <x-field :label="__('dashboard.security.new_password')" for="password" error="password">
                        <x-input name="password" type="password" icon="lock" required />
                    </x-field>
                    <x-field :label="__('dashboard.security.confirm_password')" for="password_confirmation" error="password_confirmation">
                        <x-input name="password_confirmation" type="password" icon="lock" required />
                    </x-field>
                </div>
                <x-button type="submit">{{ __('dashboard.security.update_password') }}</x-button>
            </form>
        </x-card>

        {{-- Two-factor --}}
        <x-card padding="p-7">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-base font-semibold text-ink-900 dark:text-white">{{ __('dashboard.security.two_factor') }}</h3>
                    <p class="mt-1 text-sm text-ink-500 dark:text-ink-400">{{ __('dashboard.security.two_factor_text') }}</p>
                </div>
                @if ($user->twoFactorEnabled())
                    <x-badge color="success" dot>{{ __('dashboard.security.two_factor_on') }}</x-badge>
                @else
                    <x-badge color="neutral" dot>{{ __('dashboard.security.two_factor_off') }}</x-badge>
                @endif
            </div>

            @if ($user->twoFactorEnabled())
                <form method="POST" action="{{ route('dashboard.security.2fa.disable') }}" class="mt-5 flex items-end gap-3">
                    @csrf @method('DELETE')
                    <div class="flex-1">
                        <x-field :label="__('dashboard.profile.delete_confirm')" for="password" error="password">
                            <x-input name="password" type="password" required />
                        </x-field>
                    </div>
                    <x-button type="submit" variant="danger">{{ __('dashboard.security.disable') }}</x-button>
                </form>
            @elseif ($setup)
                <div class="mt-5 grid gap-6 sm:grid-cols-[auto_1fr]">
                    <div class="rounded-xl bg-white p-3 ring-hair">{!! $setup['qr'] !!}</div>
                    <div>
                        <p class="text-sm text-ink-500 dark:text-ink-400">{{ __('dashboard.security.scan') }}</p>
                        <div class="mt-3"><x-copy-field :label="__('dashboard.security.or_secret')" :value="$setup['secret']" /></div>
                        <details class="mt-3">
                            <summary class="cursor-pointer text-sm font-medium text-brand-600 dark:text-brand-300">{{ __('dashboard.security.recovery_codes') }}</summary>
                            <div class="mt-2 grid grid-cols-2 gap-1.5 rounded-xl bg-ink-50 p-3 font-mono text-xs text-ink-600 dark:bg-ink-950/60 dark:text-ink-300">
                                @foreach ($setup['recovery'] as $code)<span>{{ $code }}</span>@endforeach
                            </div>
                            <p class="mt-1.5 text-xs text-ink-400">{{ __('dashboard.security.recovery_text') }}</p>
                        </details>
                    </div>
                </div>
                <form method="POST" action="{{ route('dashboard.security.2fa.confirm') }}" class="mt-5 flex items-end gap-3">
                    @csrf
                    <div class="flex-1">
                        <x-field :label="__('dashboard.security.confirm_code')" for="code" error="code">
                            <x-input name="code" inputmode="numeric" placeholder="000000" />
                        </x-field>
                    </div>
                    <x-button type="submit">{{ __('dashboard.security.confirm') }}</x-button>
                </form>
            @else
                <form method="POST" action="{{ route('dashboard.security.2fa.enable') }}" class="mt-5">
                    @csrf
                    <x-button type="submit" icon="shield">{{ __('dashboard.security.enable') }}</x-button>
                </form>
            @endif
        </x-card>

        {{-- Sessions --}}
        @if ($sessions->isNotEmpty())
            <x-card padding="p-7">
                <h3 class="text-base font-semibold text-ink-900 dark:text-white">{{ __('dashboard.security.sessions') }}</h3>
                <div class="mt-4 space-y-2.5">
                    @foreach ($sessions as $session)
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-ink-600 dark:text-ink-300">{{ $session->ip_address ?? '—' }}</span>
                            <span class="text-ink-400">{{ $session->created_at->diffForHumans() }}</span>
                        </div>
                    @endforeach
                </div>
            </x-card>
        @endif
    </div>
</x-layouts.dashboard>
