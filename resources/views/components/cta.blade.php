@props(['title' => '', 'subtitle' => null])

<div {{ $attributes->merge(['class' => 'reveal relative overflow-hidden rounded-3xl bg-brand-gradient animate-gradient px-6 py-14 text-center shadow-glow sm:px-16 sm:py-20']) }}>
    <div class="absolute inset-0 -z-0 bg-grid opacity-20"></div>
    <div class="pointer-events-none absolute -left-10 -top-10 h-48 w-48 rounded-full bg-white/20 blur-3xl"></div>
    <div class="pointer-events-none absolute -bottom-16 -right-10 h-56 w-56 rounded-full bg-accent-400/30 blur-3xl"></div>

    <div class="relative mx-auto max-w-2xl">
        <h2 class="text-balance text-3xl font-semibold font-display tracking-tight text-white sm:text-4xl">{{ $title }}</h2>
        @if ($subtitle)
            <p class="mt-4 text-pretty text-base leading-relaxed text-white/85 sm:text-lg">{{ $subtitle }}</p>
        @endif
        <div class="mt-8 flex flex-wrap items-center justify-center gap-3">
            {{ $slot }}
        </div>
    </div>
</div>
