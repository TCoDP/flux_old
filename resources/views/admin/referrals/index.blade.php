<x-layouts.admin :title="__('admin.nav.referrals')">
    <div class="mb-6"><x-badge color="warning">{{ __('admin.referrals.pending_total') }}: {{ format_price($pendingTotal) }}</x-badge></div>

    <div class="grid gap-6 lg:grid-cols-2">
        <x-card padding="p-6">
            <h3 class="mb-4 text-base font-semibold text-ink-900 dark:text-white">{{ __('admin.referrals.title') }}</h3>
            <x-table :headers="[__('admin.referrals.referrer'), __('admin.referrals.referred'), __('common.status'), __('admin.referrals.reward')]">
                @forelse ($referrals as $referral)
                    <tr>
                        <td class="px-4 py-3">{{ $referral->referrer?->name ?? '—' }}</td>
                        <td class="px-4 py-3">{{ $referral->referred?->name ?? '—' }}</td>
                        <td class="px-4 py-3"><x-badge :color="$referral->status->color()" size="sm">{{ $referral->status->label() }}</x-badge></td>
                        <td class="px-4 py-3 font-medium">{{ format_price($referral->reward_amount) }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-4 py-10 text-center text-sm text-ink-400">{{ __('common.empty') }}</td></tr>
                @endforelse
            </x-table>
            <div class="mt-4">{{ $referrals->links() }}</div>
        </x-card>

        <x-card padding="p-6">
            <h3 class="mb-4 text-base font-semibold text-ink-900 dark:text-white">{{ __('admin.referrals.payouts') }}</h3>
            <div class="space-y-2">
                @forelse ($payouts as $payout)
                    <div class="flex items-center justify-between rounded-xl border border-ink-100 px-4 py-3 dark:border-white/5">
                        <div>
                            <p class="text-sm font-medium text-ink-900 dark:text-white">{{ $payout->user?->name }}</p>
                            <p class="text-xs text-ink-400">{{ format_price($payout->amount) }} · {{ $payout->method }} · {{ $payout->details }}</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <x-badge :color="$payout->status->color()" size="sm">{{ $payout->status->label() }}</x-badge>
                            @if ($payout->status->value === 'pending')
                                <form method="POST" action="{{ route('admin.referrals.approve', $payout) }}">
                                    @csrf @method('PATCH')
                                    <x-button type="submit" size="sm" variant="secondary">{{ __('common.confirm') }}</x-button>
                                </form>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="py-10 text-center text-sm text-ink-400">{{ __('common.empty') }}</p>
                @endforelse
            </div>
        </x-card>
    </div>
</x-layouts.admin>
