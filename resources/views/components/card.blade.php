@props(['padding' => 'p-6', 'hover' => false])

<div {{ $attributes->merge(['class' => 'rounded-2xl bg-white dark:bg-ink-900/40 ring-hair shadow-soft '.$padding.' '.($hover ? 'transition-all duration-300 hover:-translate-y-1 hover:shadow-card' : '')]) }}>
    {{ $slot }}
</div>
