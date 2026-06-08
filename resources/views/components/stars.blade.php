@props(['rating' => 5, 'size' => 'h-4 w-4'])

<div {{ $attributes->merge(['class' => 'inline-flex gap-0.5']) }} aria-label="{{ $rating }}/5">
    @for ($i = 1; $i <= 5; $i++)
        <svg class="{{ $size }} {{ $i <= $rating ? 'text-amber-400' : 'text-ink-300 dark:text-white/15' }}" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
            <path d="M11.48 3.5a.56.56 0 0 1 1.04 0l2.13 5.11c.08.2.27.33.47.35l5.52.44c.5.04.7.66.32.99l-4.2 3.6c-.16.13-.23.34-.18.56l1.28 5.38c.12.5-.42.9-.84.61l-4.72-2.88a.56.56 0 0 0-.59 0l-4.72 2.88c-.42.29-.96-.11-.84-.6l1.28-5.39a.56.56 0 0 0-.18-.56l-4.2-3.6c-.39-.33-.18-.95.32-.99l5.52-.44c.2-.02.39-.15.47-.35L11.48 3.5Z"/>
        </svg>
    @endfor
</div>
