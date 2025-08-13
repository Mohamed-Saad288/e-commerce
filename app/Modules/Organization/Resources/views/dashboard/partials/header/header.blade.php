@props(['dir' => 'material/assets', 'isRtl' => false])

<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
<meta name="description" content="Admin dashboard for your organization">

<!-- Favicon -->
<link rel="apple-touch-icon" sizes="76x76" href="{{ asset($dir) }}/img/apple-icon.png">
<link rel="icon" type="image/png" href="{{ asset($dir) }}/img/favicon.png">

<!-- Title -->
<title>@yield('title', 'Material Dashboard 2')</title>

<!-- Fonts & Icons -->
<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700"/>

<!-- Nucleo Icons -->
<link href="{{ asset($dir) }}/css/nucleo-icons.css" rel="stylesheet"/>
<link href="{{ asset($dir) }}/css/nucleo-svg.css" rel="stylesheet"/>

<!-- Font Awesome -->
<script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>

<!-- Material Icons -->
<link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">

<!-- RTL Support -->
@if($isRtl)
    <link id="rtl-style" href="{{ asset($dir) }}/css/material-dashboard-rtl.css" rel="stylesheet"/>
@else
    <link id="pagestyle" href="{{ asset($dir) }}/css/material-dashboard.css?v=3.0.0" rel="stylesheet"/>
@endif
