@props(['seo' => [], 'platforms' => []])

<x-layouts.base :seo="$seo">
    <div class="relative overflow-x-clip">
        <x-navbar />
        <div class="mx-auto max-w-7xl px-5 py-10 sm:px-8 lg:py-14">
            <div class="lg:grid lg:grid-cols-[260px_minmax(0,1fr)] lg:gap-12">
                <aside class="mb-8 lg:mb-0">
                    <div class="lg:sticky lg:top-24">
                        <x-docs-sidebar :platforms="$platforms" />
                    </div>
                </aside>
                <div class="min-w-0">
                    {{ $slot }}
                </div>
            </div>
        </div>
        <x-footer />
    </div>
</x-layouts.base>
