@props(['seo' => []])

<x-layouts.base :seo="$seo">
    <div class="relative overflow-x-clip">
        <x-navbar />
        <main>
            {{ $slot }}
        </main>
        <x-footer />
        <div class="h-20 lg:hidden" aria-hidden="true"></div>
    </div>

    <x-public-bottom-nav />
</x-layouts.base>
