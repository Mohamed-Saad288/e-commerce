@php
    $dir = LaravelLocalization::getCurrentLocale() == 'ar' ? 'assets-admin-rtl' : 'assets-admin';
@endphp

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="{{ getSiteName() }} - Admin Dashboard">
    <meta name="author" content="">
    <link rel="icon" href="{{ htmlspecialchars($logo) }}">
    <title>{{ getSiteName() }} - @yield('title')</title>

    <!-- Simple bar CSS -->
    <link rel="stylesheet" href="{{ asset($dir . '/css/simplebar.css') }}">

    <!-- Icons CSS -->
    <link rel="stylesheet" href="{{ asset($dir . '/css/feather.css') }}">
    <link rel="stylesheet" href="{{ asset($dir . '/css/select2.css') }}">
    <link rel="stylesheet" href="{{ asset($dir . '/css/dropzone.css') }}">
    <link rel="stylesheet" href="{{ asset($dir . '/css/uppy.min.css') }}">
    <link rel="stylesheet" href="{{ asset($dir . '/css/jquery.steps.css') }}">
    <link rel="stylesheet" href="{{ asset($dir . '/css/jquery.timepicker.css') }}">
    <link rel="stylesheet" href="{{ asset($dir . '/css/quill.snow.css') }}">
    <link rel="stylesheet" href="{{ asset($dir . '/css/dataTables.bootstrap4.css') }}">

    <!-- Date Range Picker CSS -->
    <link rel="stylesheet" href="{{ asset($dir . '/css/daterangepicker.css') }}">

    <!-- App CSS -->
    <link rel="stylesheet" href="{{ asset($dir . '/css/app-light.css') }}" id="lightTheme">
    <link rel="stylesheet" href="{{ asset($dir . '/css/app-dark.css') }}" id="darkTheme" disabled>
    <link rel="stylesheet" href="{{ asset('custom.css') }}">

    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" onload="if(this.media!='all')this.media='all'" media="print">
    <!-- Fallback for Toastr CSS -->
    <script>
        if (!window.toastr) {
            document.write('<link rel="stylesheet" href="{{ asset($dir . '/css/toastr.min.css') }}">');
        }
    </script>

    <!-- Summernote CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs4.min.css" onload="if(this.media!='all')this.media='all'" media="print">
    <!-- Fallback for Summernote CSS -->
    <script>
        if (!window.summernote) {
            document.write('<link rel="stylesheet" href="{{ asset($dir . '/css/summernote-bs4.min.css') }}">');
        }
    </script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" defer></script>
    <!-- Fallback for jQuery -->
    <script>
        if (typeof jQuery === 'undefined') {
            document.write('<script src="{{ asset($dir . '/js/jquery-3.7.1.min.js') }}" defer><\/script>');
        }
    </script>

    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js" defer></script>
    <!-- Fallback for Bootstrap JS -->
    <script>
        if (typeof bootstrap === 'undefined') {
            document.write('<script src="{{ asset($dir . '/js/bootstrap.bundle.min.js') }}" defer><\/script>');
        }
    </script>

    <!-- Summernote JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs4.min.js" defer></script>
    <!-- Fallback for Summernote JS -->
    <script>
        if (!window.summernote) {
            document.write('<script src="{{ asset($dir . '/js/summernote-bs4.min.js') }}" defer><\/script>');
        }
    </script>

    @yield('styles')
</head>
