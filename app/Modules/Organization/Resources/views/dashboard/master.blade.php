<!doctype html>
<html lang="en">

@include('organization::dashboard.partials.head')

<body class="vertical  light  @if (LaravelLocalization::getCurrentLocale() == 'ar') rtl @endif">
    <div class="wrapper">

        @include('organization::dashboard.partials.navbar')

        @include('organization::dashboard.partials.sidebar')

        <main role="main" class="main-content">
            @include('organization::dashboard.partials.messages')
            @yield('content')
        </main>
    </div>

    @include('organization::dashboard.partials.scripts')

    @yield('after_script')

</body>

</html>
