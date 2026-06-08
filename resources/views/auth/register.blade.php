<x-layouts.auth :seo="$seo">
    <div class="text-center">
        <h1 class="text-2xl font-semibold font-display tracking-tight text-ink-900 dark:text-white">{{ __('auth.register.title') }}</h1>
        <p class="mt-2 text-sm text-ink-500 dark:text-ink-400">{{ __('auth.register.subtitle') }}</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="mt-8 space-y-5">
        @csrf
        <x-field :label="__('auth.register.name')" for="name" error="name">
            <x-input name="name" :value="old('name')" icon="user" required autofocus />
        </x-field>
        <x-field :label="__('auth.register.email')" for="email" error="email">
            <x-input name="email" type="email" :value="old('email')" icon="envelope" required />
        </x-field>
        <x-field :label="__('auth.register.password')" for="password" error="password">
            <x-input name="password" type="password" icon="lock" required />
        </x-field>
        <x-field :label="__('auth.register.password_confirm')" for="password_confirmation" error="password_confirmation">
            <x-input name="password_confirmation" type="password" icon="lock" required />
        </x-field>
        <x-field :label="__('auth.register.referral')" for="referral_code" error="referral_code">
            <x-input name="referral_code" :value="old('referral_code', $referral ?? '')" icon="gift" />
        </x-field>

        <div>
            <x-checkbox name="terms">
                {!! __('auth.register.terms', [
                    'terms' => '<a href="'.route('legal.terms').'" class="text-brand-600 hover:underline dark:text-brand-300">'.__('auth.register.terms_link').'</a>',
                    'privacy' => '<a href="'.route('legal.privacy').'" class="text-brand-600 hover:underline dark:text-brand-300">'.__('auth.register.privacy_link').'</a>',
                ]) !!}
            </x-checkbox>
            @error('terms')<p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>@enderror
        </div>

        <x-button type="submit" size="lg" block>{{ __('auth.register.submit') }}</x-button>
    </form>

    <p class="mt-6 text-center text-sm text-ink-500 dark:text-ink-400">
        {{ __('auth.register.has_account') }}
        <a href="{{ route('login') }}" class="font-medium text-brand-600 hover:underline dark:text-brand-300">{{ __('auth.register.login') }}</a>
    </p>
</x-layouts.auth>
