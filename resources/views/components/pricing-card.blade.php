@props(['plan'])

@php
    $featured = $plan->is_popular;
    $cta = auth()->check()
        ? route('dashboard.checkout', $plan)
        : route('register', ['locale' => app()->getLocale()]);
@endphp

<div class="reveal relative flex flex-col rounded-3xl p-7 transition-all duration-300 hover:-translate-y-1
    {{ $featured
        ? 'bg-brand-gradient text-white shadow-glow ring-1 ring-white/20'
        : 'bg-white dark:bg-ink-900/40 ring-hair shadow-soft' }}">

    @if ($featured)
        <span class="absolute -top-3 right-6 rounded-full bg-white px-3 py-1 text-xs font-semibold text-brand-600 shadow">
            {{ __('pricing.popular') }}
        </span>
    @endif

    <div class="flex items-center justify-between">
        <h3 class="text-lg font-semibold {{ $featured ? 'text-white' : 'text-ink-900 dark:text-white' }}">{{ $plan->name }}</h3>
        @if ($plan->hasDiscount())
            <span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $featured ? 'bg-white/20 text-white' : 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-300' }}">
                −{{ $plan->discountPercent() }}%
            </span>
        @endif
    </div>

    @if ($plan->tagline)
        <p class="mt-1 text-sm {{ $featured ? 'text-white/80' : 'text-ink-500 dark:text-ink-400' }}">{{ $plan->tagline }}</p>
    @endif

    <div class="mt-6 flex items-end gap-1.5">
        <span class="text-4xl font-semibold font-display tracking-tight {{ $featured ? 'text-white' : 'text-ink-900 dark:text-white' }}">{{ format_price($plan->price, $plan->currency) }}</span>
        <span class="mb-1 text-sm {{ $featured ? 'text-white/70' : 'text-ink-400' }}">/ {{ $plan->billing_period->label() }}</span>
    </div>
    @if ($plan->hasDiscount())
        <p class="mt-1 text-sm line-through {{ $featured ? 'text-white/50' : 'text-ink-400' }}">{{ format_price($plan->old_price, $plan->currency) }}</p>
    @endif

    <x-button :href="$cta" :variant="$featured ? 'white' : 'primary'" class="mt-6" block>
        {{ __('pricing.choose') }}
    </x-button>

    <ul class="mt-7 space-y-3 text-sm">
        <li class="flex items-center gap-2.5 {{ $featured ? 'text-white/90' : 'text-ink-600 dark:text-ink-300' }}">
            <x-icon name="check" class="h-4.5 w-4.5 shrink-0 {{ $featured ? 'text-white' : 'text-brand-500' }}" />
            {{ trans_choice('pricing.devices', $plan->device_limit, ['count' => $plan->device_limit]) }}
        </li>
        @foreach (($plan->features ?? []) as $feature)
            <li class="flex items-center gap-2.5 {{ $featured ? 'text-white/90' : 'text-ink-600 dark:text-ink-300' }}">
                <x-icon name="check" class="h-4.5 w-4.5 shrink-0 {{ $featured ? 'text-white' : 'text-brand-500' }}" />
                {{ $feature }}
            </li>
        @endforeach
    </ul>
</div>
