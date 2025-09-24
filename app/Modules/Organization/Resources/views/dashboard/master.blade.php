<!doctype html>
<html lang="{{ LaravelLocalization::getCurrentLocale() }}">
@include('organization::dashboard.partials.head')
<body class="vertical {{ session('theme', 'light') }} @if (LaravelLocalization::getCurrentLocale() == 'ar') rtl @endif">
<div class="wrapper">
    @include('organization::dashboard.partials.navbar')
    @include('organization::dashboard.partials.sidebar')
    <main role="main" class="main-content" aria-label="Main content">
        @include('organization::dashboard.partials.messages')
        @yield('content')
    </main>
</div>
@include('organization::dashboard.partials.scripts')
@yield('after_script')
</body>
</html>
