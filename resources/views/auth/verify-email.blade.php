<x-layouts.auth :seo="$seo">
    <div class="text-center">
        <span class="mx-auto grid h-14 w-14 place-items-center rounded-2xl bg-brand-500/10 text-brand-500">
            <x-icon name="envelope" class="h-7 w-7" />
        </span>
        <h1 class="mt-5 text-2xl font-semibold font-display tracking-tight text-ink-900 dark:text-white">{{ __('auth.verify.title') }}</h1>
        <p class="mt-2 text-sm text-ink-500 dark:text-ink-400">{{ __('auth.verify.text') }}</p>
    </div>

    @if (session('status') === 'verification-link-sent')
        <x-alert type="success" class="mt-6">{{ __('auth.verify.sent') }}</x-alert>
    @endif

    <form method="POST" action="{{ route('verification.send') }}" class="mt-8">
        @csrf
        <x-button type="submit" size="lg" block>{{ __('auth.verify.resend') }}</x-button>
    </form>

    <form method="POST" action="{{ route('logout') }}" class="mt-3">
        @csrf
        <x-button type="submit" variant="ghost" block>{{ __('auth.verify.logout') }}</x-button>
    </form>
</x-layouts.auth>
