<x-layouts.admin :title="$user->name">
    <div class="mx-auto max-w-2xl">
        <x-card padding="p-7">
            <h2 class="mb-6 text-lg font-semibold text-ink-900 dark:text-white">{{ __('admin.edit') }}</h2>
            <form method="POST" action="{{ route('admin.users.update', $user) }}">
                @csrf @method('PUT')
                @include('admin.users._form', ['user' => $user])
            </form>
        </x-card>
    </div>
</x-layouts.admin>
