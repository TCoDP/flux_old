<x-layouts.auth :seo="$seo">
    <div x-data="{ recovery: false }">
        <div class="text-center">
            <span class="mx-auto grid h-14 w-14 place-items-center rounded-2xl bg-brand-500/10 text-brand-500">
                <x-icon name="shield" class="h-7 w-7" />
            </span>
            <h1 class="mt-5 text-2xl font-semibold font-display tracking-tight text-ink-900 dark:text-white">{{ __('auth.two_factor.title') }}</h1>
            <p class="mt-2 text-sm text-ink-500 dark:text-ink-400">{{ __('auth.two_factor.subtitle') }}</p>
        </div>

        <form method="POST" action="{{ route('two-factor.login') }}" class="mt-8 space-y-5">
            @csrf
            <div x-show="!recovery">
                <x-field :label="__('auth.two_factor.code')" for="code" error="code">
                    <x-input name="code" inputmode="numeric" autocomplete="one-time-code" placeholder="000000" class="text-center tracking-[0.5em]" />
                </x-field>
            </div>
            <div x-show="recovery" x-cloak>
                <x-field :label="__('auth.two_factor.recovery_code')" for="recovery_code" error="recovery_code">
                    <x-input name="recovery_code" placeholder="xxxxx-xxxxx" />
                </x-field>
            </div>

            <x-button type="submit" size="lg" block>{{ __('auth.two_factor.submit') }}</x-button>
        </form>

        <button type="button" @click="recovery = !recovery" class="mt-5 block w-full text-center text-sm font-medium text-brand-600 hover:underline dark:text-brand-300">
            <span x-show="!recovery">{{ __('auth.two_factor.recovery') }}</span>
            <span x-show="recovery" x-cloak>{{ __('auth.two_factor.use_code') }}</span>
        </button>
    </div>
</x-layouts.auth>
