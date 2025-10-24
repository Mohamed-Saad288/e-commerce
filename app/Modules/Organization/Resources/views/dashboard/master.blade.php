<!doctype html>
<html lang="{{ LaravelLocalization::getCurrentLocale() }}">
@include('organization::dashboard.partials.head')

<body class="vertical {{ session('theme', 'light') }} @if (LaravelLocalization::getCurrentLocale() == 'ar') rtl @endif">

<div class="wrapper">
    @include('organization::dashboard.partials.navbar')
    @include('organization::dashboard.partials.sidebar')

    <main role="main" class="main-content" aria-label="Main content">
        @yield('content')
    </main>
</div>

{{-- جميع السكربتات وملفات JS --}}
@include('organization::dashboard.partials.scripts')

{{-- رسائل التنبيه (توست) يجب أن تأتي بعد تحميل Toastr --}}
@include('organization::dashboard.partials.messages')

{{-- سكربتات الصفحات الإضافية --}}
@yield('after_script')

</body>
</html>
