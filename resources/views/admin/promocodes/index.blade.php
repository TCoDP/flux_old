<x-layouts.admin :title="__('admin.nav.promocodes')">
    <x-admin.toolbar :create="route('admin.promocodes.create')" />
    <x-card padding="p-2 sm:p-4">
        <x-table :headers="[__('admin.promocodes.code'), __('admin.promocodes.type'), __('admin.promocodes.value'), __('admin.promocodes.uses'), __('admin.promocodes.expires'), '']">
            @forelse ($promocodes as $promo)
                <tr>
                    <td class="px-4 py-3 font-mono font-semibold text-ink-900 dark:text-white">{{ $promo->code }}</td>
                    <td class="px-4 py-3">{{ $promo->type->label() }}</td>
                    <td class="px-4 py-3">{{ $promo->type->value === 'percent' ? $promo->value.'%' : format_price($promo->value) }}</td>
                    <td class="px-4 py-3">{{ $promo->used_count }}{{ $promo->max_uses ? ' / '.$promo->max_uses : '' }}</td>
                    <td class="px-4 py-3 text-ink-400">{{ $promo->expires_at?->isoFormat('D MMM YYYY') ?? '∞' }}</td>
                    <td class="px-4 py-3"><x-admin.row-actions :edit="route('admin.promocodes.edit', $promo)" :destroy="route('admin.promocodes.destroy', $promo)" /></td>
                </tr>
            @empty
                <tr><td colspan="6" class="px-4 py-12 text-center text-sm text-ink-400">{{ __('common.empty') }}</td></tr>
            @endforelse
        </x-table>
    </x-card>
</x-layouts.admin>
