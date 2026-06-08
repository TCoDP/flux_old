<x-layouts.dashboard :title="__('dashboard.referrals.title')">
    <p class="-mt-2 mb-6 text-sm text-ink-500 dark:text-ink-400">{{ __('dashboard.referrals.subtitle') }}</p>

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="space-y-6 lg:col-span-2">
            <div class="grid gap-4 sm:grid-cols-3">
                <x-stat icon="currency" :value="format_price($balance)" :label="__('dashboard.referrals.balance')" />
                <x-stat icon="users" :value="$invitedCount" :label="__('dashboard.referrals.invited')" />
                <x-stat icon="gift" :value="$rewardPercent.'%'" :label="__('dashboard.nav.referrals')" />
            </div>

            <x-glass-card padding="p-6">
                <p class="text-sm font-medium text-ink-700 dark:text-ink-200">{{ __('dashboard.referrals.reward', ['percent' => $rewardPercent]) }}</p>
                <div class="mt-4 space-y-3">
                    <x-copy-field :label="__('dashboard.referrals.your_link')" :value="$referralLink" :mono="false" />
                    <x-copy-field :label="__('dashboard.referrals.your_code')" :value="$referralCode" />
                </div>
            </x-glass-card>

            <x-card padding="p-6">
                <h3 class="text-base font-semibold text-ink-900 dark:text-white">{{ __('dashboard.referrals.invited_users') }}</h3>
                <div class="mt-4">
                    @if ($referrals->isNotEmpty())
                        <x-table :headers="['', __('common.status'), __('dashboard.referrals.reward')]">
                            @foreach ($referrals as $referral)
                                <tr>
                                    <td class="px-4 py-3">{{ $referral->referred?->name ?? '—' }}</td>
                                    <td class="px-4 py-3"><x-badge :color="$referral->status->color()">{{ $referral->status->label() }}</x-badge></td>
                                    <td class="px-4 py-3 font-medium">{{ format_price($referral->reward_amount) }}</td>
                                </tr>
                            @endforeach
                        </x-table>
                    @else
                        <p class="py-6 text-center text-sm text-ink-400">{{ __('dashboard.referrals.empty') }}</p>
                    @endif
                </div>
            </x-card>
        </div>

        <x-card padding="p-6" class="h-fit">
            <h3 class="text-base font-semibold text-ink-900 dark:text-white">{{ __('dashboard.referrals.request_payout') }}</h3>
            <p class="mt-1 text-xs text-ink-400">{{ __('dashboard.referrals.min_payout', ['amount' => format_price($minPayout)]) }}</p>
            <form method="POST" action="{{ route('dashboard.referrals.payout') }}" class="mt-4 space-y-4">
                @csrf
                <x-field :label="__('dashboard.referrals.payout_amount')" for="amount" error="amount">
                    <x-input name="amount" type="number" min="{{ $minPayout }}" :value="old('amount')" />
                </x-field>
                <x-field :label="__('dashboard.referrals.payout_method')" for="method" error="method">
                    <x-select name="method">
                        <option value="card">{{ __('enums.payment_method.card') }}</option>
                        <option value="sbp">{{ __('enums.payment_method.sbp') }}</option>
                    </x-select>
                </x-field>
                <x-field :label="__('dashboard.referrals.payout_details')" for="details" error="details">
                    <x-input name="details" :value="old('details')" />
                </x-field>
                <x-button type="submit" block>{{ __('dashboard.referrals.request_payout') }}</x-button>
            </form>

            @if ($payouts->isNotEmpty())
                <div class="mt-6 border-t border-ink-100 pt-4 dark:border-white/5">
                    <p class="text-xs font-semibold uppercase tracking-wide text-ink-400">{{ __('dashboard.referrals.payouts') }}</p>
                    <div class="mt-3 space-y-2">
                        @foreach ($payouts as $payout)
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-ink-600 dark:text-ink-300">{{ format_price($payout->amount) }}</span>
                                <x-badge :color="$payout->status->color()" size="sm">{{ $payout->status->label() }}</x-badge>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </x-card>
    </div>
</x-layouts.dashboard>
