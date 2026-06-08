@props(['create' => null, 'createLabel' => null, 'search' => null])

<div class="mb-6 flex flex-wrap items-center justify-between gap-3">
    @if ($search)
        <form method="GET" action="{{ $search }}" class="w-full sm:w-72">
            <x-input name="q" :value="request('q')" :placeholder="__('admin.search_placeholder')" icon="search" />
        </form>
    @else
        <div>{{ $slot }}</div>
    @endif

    @if ($create)
        <x-button :href="$create" icon="plus">{{ $createLabel ?? __('admin.new') }}</x-button>
    @endif
</div>
