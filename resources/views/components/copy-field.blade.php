@props(['value' => '', 'label' => null, 'mono' => true])

<div class="space-y-1.5">
    @if ($label)<p class="text-xs font-medium text-ink-500 dark:text-ink-400">{{ $label }}</p>@endif
    <div x-data="copyField(@js($value))"
         class="flex items-center gap-2 rounded-xl border border-ink-200 dark:border-white/10 bg-ink-50 dark:bg-ink-950/60 px-3.5 py-2.5">
        <code class="flex-1 truncate text-sm {{ $mono ? 'font-mono' : '' }} text-ink-700 dark:text-ink-200" x-text="value"></code>
        <button type="button" @click="copy()"
                class="inline-flex items-center gap-1.5 rounded-lg px-2.5 py-1.5 text-xs font-medium text-ink-500 hover:text-brand-600 hover:bg-brand-500/10 transition dark:text-ink-300">
            <template x-if="!copied"><span class="inline-flex items-center gap-1.5"><x-icon name="copy" class="h-4 w-4" />{{ __('common.copy') }}</span></template>
            <template x-if="copied"><span class="inline-flex items-center gap-1.5 text-emerald-500"><x-icon name="check" class="h-4 w-4" />{{ __('common.copied') }}</span></template>
        </button>
    </div>
</div>
