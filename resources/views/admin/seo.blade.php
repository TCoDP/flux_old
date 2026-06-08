<x-layouts.admin :title="__('admin.seo.title')">
    <p class="-mt-2 mb-6 text-sm text-ink-500 dark:text-ink-400">{{ __('admin.seo.subtitle') }}</p>

    <form method="POST" action="{{ route('admin.seo.update') }}" class="space-y-5">
        @csrf @method('PUT')
        <div class="grid gap-5 lg:grid-cols-2">
            @foreach ($pages as $page)
                <x-card padding="p-6">
                    <h3 class="text-base font-semibold capitalize text-ink-900 dark:text-white">{{ $page }}</h3>
                    <div class="mt-4 space-y-5">
                        @foreach ($locales as $locale)
                            @php $row = $existing[$page.'.'.$locale] ?? null; @endphp
                            <div class="rounded-xl border border-ink-100 p-4 dark:border-white/5">
                                <p class="mb-3 text-xs font-semibold uppercase tracking-wide text-brand-500">{{ $locale }}</p>
                                <div class="space-y-3">
                                    <x-input name="seo[{{ $page }}][{{ $locale }}][title]" :value="$row?->title" :placeholder="__('admin.seo.meta_title')" />
                                    <x-textarea name="seo[{{ $page }}][{{ $locale }}][description]" rows="2" :placeholder="__('admin.seo.meta_description')">{{ $row?->description }}</x-textarea>
                                    <x-input name="seo[{{ $page }}][{{ $locale }}][keywords]" :value="$row?->keywords" :placeholder="__('admin.seo.keywords')" />
                                </div>
                            </div>
                        @endforeach
                    </div>
                </x-card>
            @endforeach
        </div>
        <div class="sticky bottom-4"><x-button type="submit" size="lg" class="shadow-card">{{ __('common.save_changes') }}</x-button></div>
    </form>
</x-layouts.admin>
