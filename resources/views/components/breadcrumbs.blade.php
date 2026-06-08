@props(['items' => []])

<nav aria-label="breadcrumb" {{ $attributes->merge(['class' => 'flex items-center gap-1.5 text-sm']) }}>
    <a href="{{ route('home') }}" class="text-ink-400 hover:text-brand-600 dark:hover:text-brand-300">{{ __('nav.home') }}</a>
    @foreach ($items as $item)
        <x-icon name="chevron-right" class="h-3.5 w-3.5 text-ink-300" />
        @if (! empty($item['href']) && ! $loop->last)
            <a href="{{ $item['href'] }}" class="text-ink-400 hover:text-brand-600 dark:hover:text-brand-300">{{ $item['label'] }}</a>
        @else
            <span class="font-medium text-ink-700 dark:text-ink-200">{{ $item['label'] }}</span>
        @endif
    @endforeach
</nav>
