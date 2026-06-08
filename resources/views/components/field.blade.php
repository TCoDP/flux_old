@props(['label' => null, 'for' => null, 'error' => null, 'hint' => null, 'required' => false])

<div {{ $attributes->merge(['class' => 'space-y-1.5']) }}>
    @if ($label)
        <label @if ($for) for="{{ $for }}" @endif class="block text-sm font-medium text-ink-700 dark:text-ink-200">
            {{ $label }}
            @if ($required)<span class="text-brand-500">*</span>@endif
        </label>
    @endif

    {{ $slot }}

    @if ($hint && ! ($error && $errors->has($error)))
        <p class="text-xs text-ink-400">{{ $hint }}</p>
    @endif

    @if ($error)
        @error($error)
            <p class="text-xs text-red-500">{{ $message }}</p>
        @enderror
    @endif
</div>
