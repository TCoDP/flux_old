<x-layouts.admin :title="$review->author_name">
    <div class="mx-auto max-w-2xl">
        <x-card padding="p-7">
            <h2 class="mb-6 text-lg font-semibold text-ink-900 dark:text-white">{{ __('admin.edit') }}</h2>
            <form method="POST" action="{{ route('admin.reviews.update', $review) }}" class="space-y-5">
                @csrf @method('PUT')
                <div class="grid gap-5 sm:grid-cols-2">
                    <x-field :label="__('admin.reviews.author')" for="author_name" error="author_name"><x-input name="author_name" :value="old('author_name', $review->author_name)" required /></x-field>
                    <x-field label="Role" for="author_role" error="author_role"><x-input name="author_role" :value="old('author_role', $review->author_role)" /></x-field>
                    <x-field :label="__('admin.reviews.rating')" for="rating" error="rating"><x-input name="rating" type="number" min="1" max="5" :value="old('rating', $review->rating)" /></x-field>
                    <x-field label="Locale" for="locale" error="locale">
                        <x-select name="locale"><option value="ru" @selected($review->locale === 'ru')>RU</option><option value="en" @selected($review->locale === 'en')>EN</option></x-select>
                    </x-field>
                </div>
                <x-field :label="__('admin.reviews.text')" for="body" error="body"><x-textarea name="body" rows="4">{{ old('body', $review->body) }}</x-textarea></x-field>
                <div class="flex gap-8">
                    <x-field :label="__('common.status')" for="status" error="status">
                        <x-select name="status">
                            @foreach ($statuses as $status)
                                <option value="{{ $status->value }}" @selected(old('status', $review->status->value) === $status->value)>{{ $status->label() }}</option>
                            @endforeach
                        </x-select>
                    </x-field>
                    <div class="pt-7"><x-toggle name="is_featured" :checked="old('is_featured', $review->is_featured)" :label="__('admin.reviews.featured')" /></div>
                </div>
                <div class="flex gap-2 pt-2">
                    <x-button type="submit">{{ __('common.save') }}</x-button>
                    <x-button :href="route('admin.reviews.index')" variant="ghost">{{ __('common.cancel') }}</x-button>
                </div>
            </form>
        </x-card>
    </div>
</x-layouts.admin>
