<x-layouts.auth :seo="$seo">
    <div class="text-center">
        <h1 class="text-2xl font-semibold font-display tracking-tight text-ink-900 dark:text-white">{{ __('auth.forgot.title') }}</h1>
        <p class="mt-2 text-sm text-ink-500 dark:text-ink-400">{{ __('auth.forgot.subtitle') }}</p>
    </div>

    @if (session('status'))
        <x-alert type="success" class="mt-6">{{ session('status') }}</x-alert>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="mt-8 space-y-5">
        @csrf
        <x-field :label="__('auth.forgot.email')" for="email" error="email">
            <x-input name="email" type="email" :value="old('email')" icon="envelope" required autofocus />
        </x-field>
        <x-button type="submit" size="lg" block>{{ __('auth.forgot.submit') }}</x-button>
    </form>

    <p class="mt-6 text-center text-sm">
        <a href="{{ route('login') }}" class="font-medium text-brand-600 hover:underline dark:text-brand-300">{{ __('auth.forgot.back') }}</a>
    </p>
</x-layouts.auth>
