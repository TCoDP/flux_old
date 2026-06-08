@props(['class' => '', 'from' => 'from-brand-500/40', 'to' => 'to-accent-400/30'])

<div aria-hidden="true"
     {{ $attributes->merge(['class' => 'pointer-events-none absolute -z-10 rounded-full bg-gradient-to-br '.$from.' '.$to.' blur-3xl '.$class]) }}>
</div>
