@props(['eyebrow' => null, 'title' => '', 'subtitle' => null])

<section class="relative overflow-hidden pb-4 pt-16 sm:pt-24">
    <x-gradient-blob class="left-1/2 -top-32 h-96 w-96 -translate-x-1/2" />
    <div class="absolute inset-0 -z-10 bg-grid [mask-image:radial-gradient(ellipse_at_top,black,transparent_70%)] opacity-50 dark:opacity-20"></div>

    <div class="mx-auto max-w-3xl px-5 text-center sm:px-8">
        @if ($eyebrow)
            <span class="inline-flex items-center gap-2 rounded-full bg-brand-500/10 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-brand-600 dark:text-brand-300">{{ $eyebrow }}</span>
        @endif
        <h1 class="mt-5 text-balance text-4xl font-semibold font-display tracking-tight text-ink-900 dark:text-white sm:text-5xl">{{ $title }}</h1>
        @if ($subtitle)
            <p class="mx-auto mt-5 max-w-2xl text-pretty text-lg leading-relaxed text-ink-500 dark:text-ink-300">{{ $subtitle }}</p>
        @endif
        @if (isset($actions))<div class="mt-8 flex flex-wrap items-center justify-center gap-3">{{ $actions }}</div>@endif
    </div>
</section>
