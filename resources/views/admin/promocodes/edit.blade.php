<x-layouts.admin :title="$promocode->code">
    @include('admin.promocodes._form', ['promocode' => $promocode])
</x-layouts.admin>
