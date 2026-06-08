@props(['limit' => null])

@php
    $items = __('faq.items');
    $items = is_array($items) ? $items : [];
    if ($limit) {
        $items = array_slice($items, 0, $limit);
    }
@endphp

<div {{ $attributes->merge(['class' => 'mx-auto mt-12 max-w-3xl']) }}>
    @foreach ($items as $item)
        <x-faq-item :question="$item['q']">{{ $item['a'] }}</x-faq-item>
    @endforeach
</div>
