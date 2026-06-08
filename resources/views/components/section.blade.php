@props([
    'eyebrow' => null,
    'title' => null,
    'subtitle' => null,
    'center' => false,
    'container' => 'max-w-7xl',
])

<section {{ $attributes->merge(['class' => 'relative py-20 sm:py-28']) }}>
    <div class="mx-auto {{ $container }} px-5 sm:px-8">
        @if ($eyebrow || $title || $subtitle)
            <div class="reveal {{ $center ? 'mx-auto max-w-2xl text-center' : 'max-w-2xl' }}">
                @if ($eyebrow)
                    <span class="inline-flex items-center gap-2 rounded-full bg-brand-500/10 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-brand-600 dark:text-brand-300">
                        {{ $eyebrow }}
                    </span>
                @endif
                @if ($title)
                    <h2 class="mt-4 text-balance text-3xl font-semibold font-display tracking-tight text-ink-900 dark:text-white sm:text-4xl">
                        {{ $title }}
                    </h2>
                @endif
                @if ($subtitle)
                    <p class="mt-4 text-pretty text-base leading-relaxed text-ink-500 dark:text-ink-300 sm:text-lg">
                        {{ $subtitle }}
                    </p>
                @endif
            </div>
        @endif

        {{ $slot }}
    </div>
</section>
