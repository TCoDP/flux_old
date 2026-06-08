<x-layouts.admin :title="__('admin.nav.reviews')">
    <x-card padding="p-2 sm:p-4">
        <x-table :headers="[__('admin.reviews.author'), __('admin.reviews.rating'), __('common.status'), __('admin.reviews.featured'), '']">
            @forelse ($reviews as $review)
                <tr>
                    <td class="px-4 py-3"><span class="font-medium text-ink-900 dark:text-white">{{ $review->author_name }}</span><br><span class="text-xs text-ink-400">{{ $review->author_role }}</span></td>
                    <td class="px-4 py-3"><x-stars :rating="$review->rating" /></td>
                    <td class="px-4 py-3"><x-badge :color="$review->status->color()" size="sm">{{ $review->status->label() }}</x-badge></td>
                    <td class="px-4 py-3">{{ $review->is_featured ? '★' : '—' }}</td>
                    <td class="px-4 py-3"><x-admin.row-actions :edit="route('admin.reviews.edit', $review)" :destroy="route('admin.reviews.destroy', $review)" /></td>
                </tr>
            @empty
                <tr><td colspan="5" class="px-4 py-12 text-center text-sm text-ink-400">{{ __('common.empty') }}</td></tr>
            @endforelse
        </x-table>
    </x-card>
    <div class="mt-6">{{ $reviews->links() }}</div>
</x-layouts.admin>
