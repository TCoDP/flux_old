@props(['name' => null, 'value' => 1])

<label class="flex items-start gap-3 cursor-pointer group">
    <input type="checkbox" @if ($name) name="{{ $name }}" @endif value="{{ $value }}"
        {{ $attributes->merge(['class' => 'mt-0.5 h-5 w-5 shrink-0 rounded-md border-ink-300 dark:border-white/20 bg-white dark:bg-ink-900/50 text-brand-600 focus:ring-brand-500/30 focus:ring-2 transition']) }} />
    <span class="text-sm text-ink-600 dark:text-ink-300 leading-relaxed">{{ $slot }}</span>
</label>
