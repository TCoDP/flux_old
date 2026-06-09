@props(['items' => []])

{{-- Mobile bottom navigation bar (hidden from large screens) --}}
<nav class="fixed inset-x-0 bottom-0 z-40 lg:hidden" aria-label="mobile">
    <div class="glass-strong border-t border-ink-200/70 dark:border-white/10" style="padding-bottom: env(safe-area-inset-bottom);">
        <div class="mx-auto flex max-w-md items-stretch justify-around px-1">
            @foreach ($items as $item)
                @php $active = $item['active'] ?? false; @endphp
                @if (! empty($item['action']))
                    <button type="button" @click="{{ $item['action'] }}"
                            class="flex flex-1 flex-col items-center gap-1 py-2 text-ink-500 transition active:scale-95 dark:text-ink-400">
                        <x-icon :name="$item['icon']" class="h-6 w-6" />
                        <span class="text-[10px] font-medium leading-none">{{ $item['label'] }}</span>
                    </button>
                @else
                    <a href="{{ $item['href'] }}"
                       @class([
                           'relative flex flex-1 flex-col items-center gap-1 py-2 transition active:scale-95',
                           'text-brand-600 dark:text-brand-300' => $active,
                           'text-ink-500 dark:text-ink-400' => ! $active,
                       ])>
                        @if ($active)
                            <span class="absolute top-0 h-0.5 w-8 rounded-full bg-brand-gradient"></span>
                        @endif
                        <x-icon :name="$item['icon']" class="h-6 w-6" />
                        <span class="text-[10px] font-medium leading-none">{{ $item['label'] }}</span>
                    </a>
                @endif
            @endforeach
        </div>
    </div>
</nav>
