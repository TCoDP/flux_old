@props(['seo' => []])

<x-layouts.base :seo="$seo">
    <div class="relative overflow-x-clip">
        <x-navbar />
        <main>
            {{ $slot }}
        </main>
        <x-footer />
    </div>
</x-layouts.base>
