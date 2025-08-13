@php
    $dir = 'material/assets';
    $lang = app()->getLocale();
    $isRtl = in_array($lang, ['ar', 'he', 'fa']); // Add other RTL languages as needed
@endphp

    <!DOCTYPE html>
<html lang="{{ $lang }}" dir="{{ $isRtl ? 'rtl' : 'ltr' }}">
<head>
    @include('organization::dashboard.partials.header.header', ['dir' => $dir, 'isRtl' => $isRtl])
    @stack('styles') <!-- For page-specific CSS -->
</head>
<body class="{{ $bodyClass ?? '' }} {{ $isRtl ? 'rtl' : 'ltr' }}">

<!-- Skip to content for a11y -->
<a href="#main-content" class="sr-only sr-only-focusable">Skip to main content</a>

@include('organization::dashboard.partials.navbars.auth')
@include('organization::dashboard.partials.sidebar.sidebar')

<main id="main-content" class="main-content" tabindex="-1">
    @yield('content')
</main>

@include('organization::dashboard.partials.footers.auth')
@include('organization::dashboard.partials.Plugins.plugins')
@include('organization::dashboard.partials.Scripts.scripts')

@stack('scripts') <!-- For page-specific JS -->
</body>
</html>
