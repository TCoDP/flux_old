<x-layouts.admin :title="__('admin.edit')">
    @include('admin.subscriptions._form', ['subscription' => $subscription])
</x-layouts.admin>
