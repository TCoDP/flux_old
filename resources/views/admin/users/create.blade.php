<x-layouts.admin :title="__('admin.nav.users')">
    <div class="mx-auto max-w-2xl">
        <x-card padding="p-7">
            <h2 class="mb-6 text-lg font-semibold text-ink-900 dark:text-white">{{ __('admin.new') }}</h2>
            <form method="POST" action="{{ route('admin.users.store') }}">
                @csrf
                @include('admin.users._form')
            </form>
        </x-card>
    </div>
</x-layouts.admin>
