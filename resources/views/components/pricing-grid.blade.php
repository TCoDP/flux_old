@props(['plans' => collect()])

@php $count = is_countable($plans) ? count($plans) : 0; @endphp

@if ($count)
    <div class="mt-14 grid items-start gap-6 md:grid-cols-2 {{ $count >= 4 ? 'lg:grid-cols-4' : 'lg:grid-cols-3' }}">
        @foreach ($plans as $plan)
            <x-pricing-card :plan="$plan" />
        @endforeach
    </div>
@else
    <x-empty-state class="mt-14" icon="currency" :title="__('pricing.title')" :message="__('common.empty')" />
@endif
