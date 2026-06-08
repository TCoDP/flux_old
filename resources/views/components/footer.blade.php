@php
    $product = [
        ['route' => 'pricing', 'label' => __('nav.pricing')],
        ['route' => 'docs.index', 'label' => __('nav.docs')],
        ['route' => 'faq', 'label' => __('nav.faq')],
    ];
    $company = [
        ['route' => 'about', 'label' => __('nav.about')],
        ['route' => 'blog.index', 'label' => __('nav.blog')],
        ['route' => 'contact', 'label' => __('nav.contacts')],
    ];
    $legal = [
        ['route' => 'legal.privacy', 'label' => __('nav.privacy')],
        ['route' => 'legal.terms', 'label' => __('nav.terms')],
    ];
@endphp

<footer class="relative mt-24 border-t border-ink-200/70 dark:border-white/10">
    <div class="mx-auto max-w-7xl px-5 py-16 sm:px-8">
        <div class="grid gap-12 lg:grid-cols-5">
            <div class="lg:col-span-2">
                <x-logo />
                <p class="mt-4 max-w-xs text-sm leading-relaxed text-ink-500 dark:text-ink-400">
                    {{ settings('site_tagline') }}
                </p>
                <div class="mt-6 flex flex-col gap-2 text-sm text-ink-500 dark:text-ink-400">
                    <a href="mailto:{{ settings('support_email') }}" class="inline-flex items-center gap-2 hover:text-brand-600 dark:hover:text-brand-300">
                        <x-icon name="envelope" class="h-4 w-4" /> {{ settings('support_email') }}
                    </a>
                    <a href="{{ settings('support_telegram') }}" class="inline-flex items-center gap-2 hover:text-brand-600 dark:hover:text-brand-300">
                        <x-icon name="chat" class="h-4 w-4" /> Telegram
                    </a>
                </div>
            </div>

            <div>
                <h4 class="text-sm font-semibold text-ink-900 dark:text-white">{{ __('footer.product') }}</h4>
                <ul class="mt-4 space-y-3">
                    @foreach ($product as $l)
                        <li><a href="{{ route($l['route']) }}" class="text-sm text-ink-500 hover:text-brand-600 dark:text-ink-400 dark:hover:text-brand-300">{{ $l['label'] }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div>
                <h4 class="text-sm font-semibold text-ink-900 dark:text-white">{{ __('footer.company') }}</h4>
                <ul class="mt-4 space-y-3">
                    @foreach ($company as $l)
                        <li><a href="{{ route($l['route']) }}" class="text-sm text-ink-500 hover:text-brand-600 dark:text-ink-400 dark:hover:text-brand-300">{{ $l['label'] }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div>
                <h4 class="text-sm font-semibold text-ink-900 dark:text-white">{{ __('footer.legal') }}</h4>
                <ul class="mt-4 space-y-3">
                    @foreach ($legal as $l)
                        <li><a href="{{ route($l['route']) }}" class="text-sm text-ink-500 hover:text-brand-600 dark:text-ink-400 dark:hover:text-brand-300">{{ $l['label'] }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="mt-14 flex flex-col items-center justify-between gap-4 border-t border-ink-200/70 dark:border-white/10 pt-8 sm:flex-row">
            <p class="text-xs text-ink-400">© {{ date('Y') }} {{ settings('company_legal') }}. {{ __('footer.rights') }}</p>
            <p class="text-xs text-ink-400">{{ __('footer.disclaimer') }}</p>
        </div>
    </div>
</footer>
