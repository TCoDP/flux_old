@props(['icon' => 'sparkles', 'title' => '', 'message' => null])

<div {{ $attributes->merge(['class' => 'flex flex-col items-center justify-center rounded-2xl border border-dashed border-ink-200 dark:border-white/10 px-6 py-16 text-center']) }}>
    <span class="grid h-14 w-14 place-items-center rounded-2xl bg-brand-500/10 text-brand-500">
        <x-icon :name="$icon" class="h-7 w-7" />
    </span>
    <p class="mt-4 text-base font-semibold text-ink-900 dark:text-white">{{ $title }}</p>
    @if ($message)<p class="mt-1.5 max-w-sm text-sm text-ink-500 dark:text-ink-400">{{ $message }}</p>@endif
    @if (isset($action))<div class="mt-6">{{ $action }}</div>@endif
</div>
