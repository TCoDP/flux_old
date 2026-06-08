<x-layouts.admin :title="$server->name">
    @include('admin.servers._form', ['server' => $server])
</x-layouts.admin>
