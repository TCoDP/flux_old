<x-layouts.auth :seo="$seo">
    <div class="text-center">
        <h1 class="text-2xl font-semibold font-display tracking-tight text-ink-900 dark:text-white">{{ __('auth.reset.title') }}</h1>
        <p class="mt-2 text-sm text-ink-500 dark:text-ink-400">{{ __('auth.reset.subtitle') }}</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="mt-8 space-y-5">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <x-field :label="__('auth.login.email')" for="email" error="email">
            <x-input name="email" type="email" :value="old('email', $email)" icon="envelope" required />
        </x-field>
        <x-field :label="__('auth.reset.title')" for="password" error="password">
            <x-input name="password" type="password" icon="lock" required autofocus />
        </x-field>
        <x-field :label="__('auth.register.password_confirm')" for="password_confirmation" error="password_confirmation">
            <x-input name="password_confirmation" type="password" icon="lock" required />
        </x-field>
        <x-button type="submit" size="lg" block>{{ __('auth.reset.submit') }}</x-button>
    </form>
</x-layouts.auth>
