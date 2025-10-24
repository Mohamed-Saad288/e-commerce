@php
    $dir = LaravelLocalization::getCurrentLocale() == 'ar' ? 'assets-admin-rtl' : 'assets-admin';
@endphp

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ getSiteName() }} - @yield('title')</title>
    <link rel="icon" href="{{ htmlspecialchars($logo) }}">

    <!-- Core Styles -->
    <link rel="stylesheet" href="{{ asset("$dir/css/simplebar.css") }}">
    <link rel="stylesheet" href="{{ asset("$dir/css/feather.css") }}">
    <link rel="stylesheet" href="{{ asset("$dir/css/select2.css") }}">
    <link rel="stylesheet" href="{{ asset("$dir/css/dropzone.css") }}">
    <link rel="stylesheet" href="{{ asset("$dir/css/uppy.min.css") }}">
    <link rel="stylesheet" href="{{ asset("$dir/css/jquery.steps.css") }}">
    <link rel="stylesheet" href="{{ asset("$dir/css/quill.snow.css") }}">
    <link rel="stylesheet" href="{{ asset("$dir/css/daterangepicker.css") }}">

    <!-- App Themes -->
    <link rel="stylesheet" href="{{ asset("$dir/css/app-light.css") }}" id="lightTheme">
    <link rel="stylesheet" href="{{ asset("$dir/css/app-dark.css") }}" id="darkTheme" disabled>
    <link rel="stylesheet" href="{{ asset('custom.css') }}">

    <!-- Toastr -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <!-- Summernote -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs4.min.css">

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.3.2/dist/select2-bootstrap4.min.css" rel="stylesheet" />




    <style>
        .image-preview {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }
        .rotate-icon {
            transition: transform 0.3s ease;
        }
        .nav-link[aria-expanded="true"] .rotate-icon {
            transform: rotate(180deg);
        }
    </style>
    @yield('styles')
</head>
