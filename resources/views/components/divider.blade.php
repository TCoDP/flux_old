@props(['label' => null])

@if ($label)
    <div {{ $attributes->merge(['class' => 'flex items-center gap-4']) }}>
        <span class="h-px flex-1 bg-ink-200 dark:bg-white/10"></span>
        <span class="text-xs font-medium uppercase tracking-wider text-ink-400">{{ $label }}</span>
        <span class="h-px flex-1 bg-ink-200 dark:bg-white/10"></span>
    </div>
@else
    <hr {{ $attributes->merge(['class' => 'border-ink-200 dark:border-white/10']) }} />
@endif
