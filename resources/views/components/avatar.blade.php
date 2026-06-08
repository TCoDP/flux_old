@props(['name' => '', 'src' => null, 'size' => 'h-10 w-10'])

@php
    $initials = collect(explode(' ', trim($name)))->map(fn ($w) => mb_substr($w, 0, 1))->take(2)->implode('');
@endphp

@if ($src)
    <img src="{{ \Illuminate\Support\Str::startsWith($src, ['http', '/']) ? $src : \Illuminate\Support\Facades\Storage::url($src) }}"
         alt="{{ $name }}" {{ $attributes->merge(['class' => $size.' rounded-full object-cover ring-2 ring-white/50 dark:ring-white/10']) }} />
@else
    <span {{ $attributes->merge(['class' => $size.' grid place-items-center rounded-full bg-brand-gradient text-xs font-semibold text-white']) }}>
        {{ \Illuminate\Support\Str::upper($initials) ?: '·' }}
    </span>
@endif
