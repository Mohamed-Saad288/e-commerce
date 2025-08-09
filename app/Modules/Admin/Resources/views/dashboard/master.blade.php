<!doctype html>
<html lang="en">

@include('admin::dashboard.partials.head')

<body class="vertical  light  @if (LaravelLocalization::getCurrentLocale() == 'ar') rtl @endif">
    <div class="wrapper">

        @include('admin::dashboard.partials.navbar')

        @include('admin::dashboard.partials.sidebar')

        <main role="main" class="main-content">
            @include('admin::dashboard.partials.messages')
            @yield('content')
        </main>
    </div>

    @include('admin::dashboard.partials.scripts')

    @yield('after_script')

</body>

</html>
