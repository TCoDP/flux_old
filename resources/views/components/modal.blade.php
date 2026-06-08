@props(['name', 'title' => null, 'maxWidth' => 'max-w-lg'])

<div x-data="{ show: false }"
     x-on:open-modal.window="$event.detail === '{{ $name }}' && (show = true)"
     x-on:close-modal.window="$event.detail === '{{ $name }}' && (show = false)"
     x-on:keydown.escape.window="show = false"
     x-show="show" x-cloak
     class="fixed inset-0 z-[60] flex items-center justify-center p-4">
    <div x-show="show" x-transition.opacity @click="show = false"
         class="absolute inset-0 bg-ink-950/60 backdrop-blur-sm"></div>

    <div x-show="show" x-trap.inert.noscroll="show"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 translate-y-4 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         class="relative w-full {{ $maxWidth }} glass-strong rounded-2xl p-6 shadow-card">
        <div class="flex items-start justify-between gap-4">
            @if ($title)<h3 class="text-lg font-semibold text-ink-900 dark:text-white">{{ $title }}</h3>@endif
            <button type="button" @click="show = false" class="ml-auto text-ink-400 hover:text-ink-600 dark:hover:text-white transition">
                <x-icon name="x" class="h-5 w-5" />
            </button>
        </div>
        <div class="mt-4">{{ $slot }}</div>
    </div>
</div>
