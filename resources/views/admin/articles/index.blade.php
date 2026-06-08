<x-layouts.admin :title="__('admin.nav.articles')">
    <x-admin.toolbar :create="route('admin.articles.create')" />
    <x-card padding="p-2 sm:p-4">
        <x-table :headers="[__('admin.articles.name'), __('admin.articles.category'), __('common.status'), __('admin.articles.views'), __('admin.articles.published_at'), '']">
            @forelse ($articles as $article)
                <tr>
                    <td class="px-4 py-3 font-medium text-ink-900 dark:text-white">{{ $article->title }}</td>
                    <td class="px-4 py-3 text-ink-500">{{ $article->category?->name ?? '—' }}</td>
                    <td class="px-4 py-3"><x-badge :color="$article->status->color()" size="sm">{{ $article->status->label() }}</x-badge></td>
                    <td class="px-4 py-3">{{ $article->views }}</td>
                    <td class="px-4 py-3 text-ink-400">{{ $article->published_at?->isoFormat('D MMM YYYY') ?? '—' }}</td>
                    <td class="px-4 py-3"><x-admin.row-actions :edit="route('admin.articles.edit', $article)" :destroy="route('admin.articles.destroy', $article)" /></td>
                </tr>
            @empty
                <tr><td colspan="6" class="px-4 py-12 text-center text-sm text-ink-400">{{ __('common.empty') }}</td></tr>
            @endforelse
        </x-table>
    </x-card>
    <div class="mt-6">{{ $articles->links() }}</div>
</x-layouts.admin>
