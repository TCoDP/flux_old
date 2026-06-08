<x-layouts.admin :title="$plan->name">
    @include('admin.plans._form', ['plan' => $plan])
</x-layouts.admin>
