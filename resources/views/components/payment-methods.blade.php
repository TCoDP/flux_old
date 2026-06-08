@props(['methods' => []])

<div class="grid gap-3 sm:grid-cols-3" x-data="{ sel: @js($methods[0]->value ?? 'card') }">
    @foreach ($methods as $method)
        <label class="relative cursor-pointer rounded-xl border p-4 transition"
               :class="sel === @js($method->value) ? 'border-brand-400 ring-2 ring-brand-500/20 bg-brand-500/5' : 'border-ink-200 dark:border-white/10 hover:border-brand-300'">
            <input type="radio" name="method" value="{{ $method->value }}" x-model="sel" class="sr-only">
            <span class="grid h-10 w-10 place-items-center rounded-lg bg-brand-500/10 text-brand-600 dark:text-brand-300"><x-icon :name="$method->icon()" class="h-5 w-5" /></span>
            <p class="mt-3 text-sm font-medium text-ink-900 dark:text-white">{{ $method->label() }}</p>
        </label>
    @endforeach
</div>
