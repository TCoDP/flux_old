@props(['padding' => 'p-6', 'strong' => false])

<div {{ $attributes->merge(['class' => ($strong ? 'glass-strong' : 'glass').' rounded-2xl shadow-soft '.$padding]) }}>
    {{ $slot }}
</div>
