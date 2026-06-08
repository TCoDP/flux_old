@props(['seo' => []])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Anti-FOUC theme bootstrap --}}
    <script>
        (function () {
            try {
                var t = localStorage.getItem('flux-theme') || 'system';
                var dark = t === 'dark' || (t === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches);
                document.documentElement.classList.toggle('dark', dark);
            } catch (e) {}
        })();
    </script>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700|sora:500,600,700" rel="stylesheet">

    <x-seo.meta :seo="$seo" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{ $head ?? '' }}
</head>
<body class="min-h-screen antialiased selection:bg-brand-500/20">
    {{ $slot }}

    <x-toasts />

    @if (session('status'))
        <div x-data x-init="$nextTick(() => $store.toasts.push(@js(session('status')), 'success'))"></div>
    @endif

    {{ $scripts ?? '' }}
</body>
</html>
