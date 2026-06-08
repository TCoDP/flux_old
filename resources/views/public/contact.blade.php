<x-layouts.public :seo="$seo">
    <x-page-header :eyebrow="__('contact.eyebrow')" :title="__('contact.title')" :subtitle="__('contact.subtitle')" />

    <div class="mx-auto max-w-6xl px-5 py-12 sm:px-8">
        <div class="grid gap-8 lg:grid-cols-5">
            {{-- Form --}}
            <div class="lg:col-span-3">
                <x-card padding="p-7 sm:p-8">
                    @if (session('status'))
                        <x-alert type="success" class="mb-6">{{ session('status') }}</x-alert>
                    @endif
                    <form method="POST" action="{{ route('contact.send') }}" class="space-y-5">
                        @csrf
                        <div class="grid gap-5 sm:grid-cols-2">
                            <x-field :label="__('contact.form.name')" for="name" error="name" required>
                                <x-input name="name" :value="old('name')" required />
                            </x-field>
                            <x-field :label="__('contact.form.email')" for="email" error="email" required>
                                <x-input name="email" type="email" :value="old('email')" required />
                            </x-field>
                        </div>
                        <x-field :label="__('contact.form.subject')" for="subject" error="subject">
                            <x-input name="subject" :value="old('subject')" />
                        </x-field>
                        <x-field :label="__('contact.form.message')" for="message" error="message" required>
                            <x-textarea name="message" rows="5" required>{{ old('message') }}</x-textarea>
                        </x-field>
                        <x-button type="submit" size="lg" icon="envelope">{{ __('contact.form.submit') }}</x-button>
                    </form>
                </x-card>
            </div>

            {{-- Channels --}}
            <div class="space-y-4 lg:col-span-2">
                <x-card hover>
                    <div class="flex items-center gap-4">
                        <span class="grid h-12 w-12 place-items-center rounded-xl bg-brand-500/10 text-brand-600 dark:text-brand-300"><x-icon name="envelope" class="h-6 w-6" /></span>
                        <div>
                            <p class="text-sm text-ink-400">{{ __('contact.channels.email') }}</p>
                            <a href="mailto:{{ settings('support_email') }}" class="font-medium text-ink-900 hover:text-brand-600 dark:text-white">{{ settings('support_email') }}</a>
                        </div>
                    </div>
                </x-card>
                <x-card hover>
                    <div class="flex items-center gap-4">
                        <span class="grid h-12 w-12 place-items-center rounded-xl bg-brand-500/10 text-brand-600 dark:text-brand-300"><x-icon name="chat" class="h-6 w-6" /></span>
                        <div>
                            <p class="text-sm text-ink-400">{{ __('contact.channels.telegram') }}</p>
                            <a href="{{ settings('support_telegram') }}" class="font-medium text-ink-900 hover:text-brand-600 dark:text-white">@flux_support</a>
                        </div>
                    </div>
                </x-card>
                <x-glass-card padding="p-6">
                    <div class="flex items-center gap-2 text-emerald-500">
                        <span class="relative flex h-2.5 w-2.5"><span class="absolute h-2.5 w-2.5 animate-ping rounded-full bg-emerald-400 opacity-75"></span><span class="h-2.5 w-2.5 rounded-full bg-emerald-500"></span></span>
                        <span class="text-sm font-semibold">{{ __('contact.channels.support') }}</span>
                    </div>
                    <p class="mt-2 text-sm text-ink-500 dark:text-ink-400">{{ __('contact.channels.support_text') }}</p>
                </x-glass-card>
            </div>
        </div>
    </div>
</x-layouts.public>
