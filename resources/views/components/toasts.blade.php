<div class="fixed bottom-5 right-5 z-[100] flex w-full max-w-sm flex-col gap-2.5" x-data>
    <template x-for="toast in $store.toasts.items" :key="toast.id">
        <div x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-3"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="glass-strong flex items-start gap-3 rounded-xl p-4 shadow-card">
            <span class="mt-0.5 grid h-6 w-6 shrink-0 place-items-center rounded-full"
                  :class="{ 'bg-emerald-500/15 text-emerald-500': toast.type === 'success', 'bg-red-500/15 text-red-500': toast.type === 'error', 'bg-sky-500/15 text-sky-500': toast.type === 'info' }">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m4.5 12.75 6 6 9-13.5"/></svg>
            </span>
            <p class="flex-1 text-sm text-ink-700 dark:text-ink-100" x-text="toast.message"></p>
            <button @click="$store.toasts.dismiss(toast.id)" class="text-ink-400 hover:text-ink-600 dark:hover:text-white">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M6 18 18 6M6 6l12 12"/></svg>
            </button>
        </div>
    </template>
</div>
