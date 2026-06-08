@props(['edit' => null, 'destroy' => null, 'view' => null])

<div class="flex items-center justify-end gap-1">
    @if ($view)
        <a href="{{ $view }}" class="grid h-8 w-8 place-items-center rounded-lg text-ink-400 hover:bg-ink-100 hover:text-brand-600 dark:hover:bg-white/5 transition" title="{{ __('common.view_all') }}">
            <x-icon name="eye" class="h-4 w-4" />
        </a>
    @endif
    @if ($edit)
        <a href="{{ $edit }}" class="grid h-8 w-8 place-items-center rounded-lg text-ink-400 hover:bg-ink-100 hover:text-brand-600 dark:hover:bg-white/5 transition" title="{{ __('common.edit') }}">
            <x-icon name="cog" class="h-4 w-4" />
        </a>
    @endif
    @if ($destroy)
        <form method="POST" action="{{ $destroy }}" onsubmit="return confirm('{{ __('admin.confirm_delete') }}')">
            @csrf @method('DELETE')
            <button class="grid h-8 w-8 place-items-center rounded-lg text-ink-400 hover:bg-red-500/10 hover:text-red-500 transition" title="{{ __('common.delete') }}">
                <x-icon name="trash" class="h-4 w-4" />
            </button>
        </form>
    @endif
</div>
