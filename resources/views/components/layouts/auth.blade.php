@props(['seo' => []])

<x-layouts.base :seo="$seo">
    <div class="relative flex min-h-screen items-center justify-center overflow-hidden px-5 py-12">
        <x-gradient-blob class="-left-32 -top-32 h-96 w-96" />
        <x-gradient-blob class="-bottom-32 -right-32 h-96 w-96" from="from-accent-400/30" to="to-brand-500/30" />
        <div class="absolute inset-0 -z-10 bg-grid opacity-40 dark:opacity-20"></div>

        <div class="absolute right-5 top-5 flex items-center gap-1.5">
            <x-theme-toggle />
            <x-lang-switcher />
        </div>

        <div class="w-full max-w-md">
            <div class="mb-8 flex justify-center">
                <x-logo />
            </div>

            <x-glass-card strong padding="p-8" class="shadow-card">
                {{ $slot }}
            </x-glass-card>

            <p class="mt-8 text-center text-xs text-ink-400">
                © {{ date('Y') }} {{ settings('company_legal') }}
            </p>
        </div>
    </div>
</x-layouts.base>
