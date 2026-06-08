<x-layouts.public :seo="$seo">
    <x-page-header :eyebrow="__('faq.eyebrow')" :title="__('faq.title')" :subtitle="__('faq.subtitle')" />

    <div class="mx-auto max-w-3xl px-5 pb-8 sm:px-8">
        <x-faq-list class="mt-6" />

        <div class="reveal mt-14">
            <x-cta :title="__('faq.still_questions')" :subtitle="settings('site_tagline')">
                <x-button :href="route('contact')" variant="white" size="lg">{{ __('faq.contact_us') }}</x-button>
            </x-cta>
        </div>
    </div>
</x-layouts.public>
