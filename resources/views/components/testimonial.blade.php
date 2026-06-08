@props(['review'])

<figure {{ $attributes->merge(['class' => 'reveal flex h-full flex-col rounded-2xl bg-white dark:bg-ink-900/40 ring-hair p-6 shadow-soft']) }}>
    <x-stars :rating="$review->rating" />
    <blockquote class="mt-4 flex-1 text-sm leading-relaxed text-ink-600 dark:text-ink-300">
        “{{ $review->body }}”
    </blockquote>
    <figcaption class="mt-5 flex items-center gap-3 border-t border-ink-100 dark:border-white/5 pt-5">
        <x-avatar :name="$review->author_name" :src="$review->avatar" />
        <div>
            <p class="text-sm font-semibold text-ink-900 dark:text-white">{{ $review->author_name }}</p>
            @if ($review->author_role)<p class="text-xs text-ink-400">{{ $review->author_role }}</p>@endif
        </div>
    </figcaption>
</figure>
