@props(['name' => null, 'checked' => false, 'label' => null])

<label class="flex items-center gap-3 cursor-pointer"
       x-data="{ on: @js((bool) $checked) }">
    @if ($name)<input type="hidden" name="{{ $name }}" :value="on ? 1 : 0">@endif
    <button type="button" role="switch" @click="on = !on" :aria-checked="on"
            class="relative inline-flex h-6 w-11 shrink-0 items-center rounded-full transition-colors duration-200"
            :class="on ? 'bg-brand-gradient' : 'bg-ink-300 dark:bg-white/15'">
        <span class="inline-block h-5 w-5 transform rounded-full bg-white shadow transition-transform duration-200"
              :class="on ? 'translate-x-5' : 'translate-x-0.5'"></span>
    </button>
    @if ($label)<span class="text-sm text-ink-700 dark:text-ink-200">{{ $label }}</span>@endif
</label>
