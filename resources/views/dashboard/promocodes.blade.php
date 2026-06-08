<x-layouts.dashboard :title="__('dashboard.promocodes.title')">
    <p class="-mt-2 mb-6 text-sm text-ink-500 dark:text-ink-400">{{ __('dashboard.promocodes.subtitle') }}</p>

    <div class="grid gap-6 lg:grid-cols-2">
        <x-card padding="p-6" class="h-fit">
            <span class="grid h-11 w-11 place-items-center rounded-xl bg-brand-gradient text-white shadow-glow"><x-icon name="ticket" class="h-6 w-6" /></span>
            <h3 class="mt-4 text-base font-semibold text-ink-900 dark:text-white">{{ __('dashboard.promocodes.apply') }}</h3>
            <form method="POST" action="{{ route('dashboard.promocodes.redeem') }}" class="mt-4 flex gap-2">
                @csrf
                <div class="flex-1">
                    <x-input name="code" :value="old('code')" :placeholder="__('dashboard.promocodes.code')" error="code" class="uppercase" />
                    @error('code')<p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>
                <x-button type="submit">{{ __('dashboard.promocodes.apply') }}</x-button>
            </form>
        </x-card>

        <x-card padding="p-6">
            <h3 class="text-base font-semibold text-ink-900 dark:text-white">{{ __('dashboard.promocodes.history') }}</h3>
            <div class="mt-4">
                @if ($redeemed->isNotEmpty())
                    <div class="space-y-2">
                        @foreach ($redeemed as $payment)
                            <div class="flex items-center justify-between rounded-lg border border-ink-100 px-4 py-2.5 text-sm dark:border-white/5">
                                <span class="font-mono font-medium text-ink-800 dark:text-ink-100">{{ $payment->promoCode?->code }}</span>
                                <span class="text-ink-400">{{ $payment->created_at->isoFormat('D MMM YYYY') }}</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="py-6 text-center text-sm text-ink-400">{{ __('dashboard.promocodes.empty') }}</p>
                @endif
            </div>
        </x-card>
    </div>
</x-layouts.dashboard>
