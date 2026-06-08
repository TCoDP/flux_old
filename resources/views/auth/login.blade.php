<x-layouts.auth :seo="$seo">
    <div class="text-center">
        <h1 class="text-2xl font-semibold font-display tracking-tight text-ink-900 dark:text-white">{{ __('auth.login.title') }}</h1>
        <p class="mt-2 text-sm text-ink-500 dark:text-ink-400">{{ __('auth.login.subtitle') }}</p>
    </div>

    @if (session('status'))
        <x-alert type="success" class="mt-6">{{ session('status') }}</x-alert>
    @endif

    <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-5">
        @csrf
        <x-field :label="__('auth.login.email')" for="email" error="email">
            <x-input name="email" type="email" :value="old('email')" icon="envelope" required autofocus />
        </x-field>
        <x-field :label="__('auth.login.password')" for="password" error="password">
            <x-input name="password" type="password" icon="lock" required />
        </x-field>
        <div class="flex items-center justify-between">
            <x-checkbox name="remember">{{ __('auth.login.remember') }}</x-checkbox>
            <a href="{{ route('password.request') }}" class="text-sm font-medium text-brand-600 hover:underline dark:text-brand-300">{{ __('auth.login.forgot') }}</a>
        </div>
        <x-button type="submit" size="lg" block>{{ __('auth.login.submit') }}</x-button>
    </form>

    <p class="mt-6 text-center text-sm text-ink-500 dark:text-ink-400">
        {{ __('auth.login.no_account') }}
        <a href="{{ route('register') }}" class="font-medium text-brand-600 hover:underline dark:text-brand-300">{{ __('auth.login.register') }}</a>
    </p>
</x-layouts.auth>
