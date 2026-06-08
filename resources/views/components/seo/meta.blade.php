@props(['seo' => []])

@php
    $seo = is_array($seo) ? $seo : [];
    $title = $seo['full_title'] ?? ($seo['title'] ?? settings('site_name', 'Flux'));
    $description = $seo['description'] ?? settings('site_tagline');
    $canonical = $seo['canonical'] ?? url()->current();
    $ogImage = $seo['og_image'] ?? asset('images/og-default.svg');
    $siteName = $seo['site_name'] ?? settings('site_name', 'Flux');
    $route = request()->route();
    $hasLocaleParam = $route && array_key_exists('locale', $route->parameters() ?? []);
@endphp

<title>{{ $title }}</title>
<meta name="description" content="{{ $description }}">
@if (! empty($seo['keywords']))<meta name="keywords" content="{{ $seo['keywords'] }}">@endif
<link rel="canonical" href="{{ $canonical }}">
<meta name="robots" content="index, follow">

{{-- hreflang alternates --}}
@if ($hasLocaleParam)
    @foreach (['ru', 'en'] as $alt)
        <link rel="alternate" hreflang="{{ $alt }}" href="{{ route($route->getName(), array_merge($route->parameters(), ['locale' => $alt])) }}">
    @endforeach
    <link rel="alternate" hreflang="x-default" href="{{ route($route->getName(), array_merge($route->parameters(), ['locale' => 'ru'])) }}">
@endif

{{-- Open Graph --}}
<meta property="og:type" content="website">
<meta property="og:site_name" content="{{ $siteName }}">
<meta property="og:title" content="{{ $title }}">
<meta property="og:description" content="{{ $description }}">
<meta property="og:url" content="{{ $canonical }}">
<meta property="og:image" content="{{ $ogImage }}">
<meta property="og:locale" content="{{ app()->getLocale() === 'ru' ? 'ru_RU' : 'en_US' }}">

{{-- Twitter --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $title }}">
<meta name="twitter:description" content="{{ $description }}">
<meta name="twitter:image" content="{{ $ogImage }}">

{{-- Schema.org JSON-LD --}}
<script type="application/ld+json">
{!! json_encode($seo['schema'] ?? [
    '@context' => 'https://schema.org',
    '@type' => 'Organization',
    'name' => $siteName,
    'url' => url('/'),
    'description' => $description,
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
</script>
