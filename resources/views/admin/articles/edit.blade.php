<x-layouts.admin :title="$article->title">
    @include('admin.articles._form', ['article' => $article])
</x-layouts.admin>
