@props(['headers' => []])

<div class="overflow-x-auto">
    <table class="min-w-full text-sm">
        @if (count($headers))
            <thead>
                <tr class="border-b border-ink-200 dark:border-white/10 text-left text-xs font-medium uppercase tracking-wider text-ink-400">
                    @foreach ($headers as $header)
                        <th class="px-4 py-3 whitespace-nowrap font-medium">{{ $header }}</th>
                    @endforeach
                </tr>
            </thead>
        @endif
        <tbody class="divide-y divide-ink-100 dark:divide-white/5 text-ink-700 dark:text-ink-200">
            {{ $slot }}
        </tbody>
    </table>
</div>
