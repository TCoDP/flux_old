@php $article = $article ?? null; @endphp
<div class="mx-auto max-w-3xl">
    <x-card padding="p-7">
        <h2 class="mb-6 text-lg font-semibold text-ink-900 dark:text-white">{{ $article ? __('admin.edit') : __('admin.new') }}</h2>
        <form method="POST" action="{{ $article ? route('admin.articles.update', $article) : route('admin.articles.store') }}" class="space-y-5">
            @csrf
            @if ($article) @method('PUT') @endif
            <x-field :label="__('admin.articles.name')" for="title" error="title"><x-input name="title" :value="old('title', $article?->title)" required /></x-field>
            <div class="grid gap-5 sm:grid-cols-3">
                <x-field label="Slug" for="slug" error="slug"><x-input name="slug" :value="old('slug', $article?->slug)" /></x-field>
                <x-field :label="__('admin.articles.category')" for="category_id" error="category_id">
                    <x-select name="category_id">
                        <option value="">—</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id', $article?->category_id) == $category->id)>{{ $category->name }}</option>
                        @endforeach
                    </x-select>
                </x-field>
                <x-field label="Locale" for="locale" error="locale">
                    <x-select name="locale">
                        <option value="ru" @selected(old('locale', $article?->locale) === 'ru')>RU</option>
                        <option value="en" @selected(old('locale', $article?->locale) === 'en')>EN</option>
                    </x-select>
                </x-field>
            </div>
            <x-field :label="__('admin.articles.cover')" for="cover_image" error="cover_image"><x-input name="cover_image" :value="old('cover_image', $article?->cover_image)" /></x-field>
            <x-field :label="__('admin.articles.excerpt')" for="excerpt" error="excerpt"><x-textarea name="excerpt" rows="2">{{ old('excerpt', $article?->excerpt) }}</x-textarea></x-field>
            <x-field :label="__('admin.articles.body')" for="body" error="body"><x-textarea name="body" rows="10">{{ old('body', $article?->body) }}</x-textarea></x-field>
            <div class="grid gap-5 sm:grid-cols-3">
                <x-field :label="__('common.status')" for="status" error="status">
                    <x-select name="status">
                        @foreach ($statuses as $status)
                            <option value="{{ $status->value }}" @selected(old('status', $article?->status?->value) === $status->value)>{{ $status->label() }}</option>
                        @endforeach
                    </x-select>
                </x-field>
                <x-field label="Reading (мин)" for="reading_minutes" error="reading_minutes"><x-input name="reading_minutes" type="number" :value="old('reading_minutes', $article?->reading_minutes ?? 5)" /></x-field>
                <x-field :label="__('admin.articles.published_at')" for="published_at" error="published_at"><x-input name="published_at" type="date" :value="old('published_at', $article?->published_at?->format('Y-m-d'))" /></x-field>
            </div>
            <div class="grid gap-5 sm:grid-cols-2">
                <x-field label="Meta title" for="meta_title" error="meta_title"><x-input name="meta_title" :value="old('meta_title', $article?->meta_title)" /></x-field>
                <x-field label="Meta description" for="meta_description" error="meta_description"><x-input name="meta_description" :value="old('meta_description', $article?->meta_description)" /></x-field>
            </div>
            <div class="flex gap-2 pt-2">
                <x-button type="submit">{{ __('common.save') }}</x-button>
                <x-button :href="route('admin.articles.index')" variant="ghost">{{ __('common.cancel') }}</x-button>
            </div>
        </form>
    </x-card>
</div>
