@php
    $dir = 'material/assets';
@endphp
    <!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Sign In') }}</title>

    {{-- Styles --}}
    <link rel="stylesheet" href="{{ asset($dir.'/css/nucleo-icons.css') }}">
    <link rel="stylesheet" href="{{ asset($dir.'/css/nucleo-svg.css') }}">
    <link rel="stylesheet" href="{{ asset($dir.'/css/material-dashboard.css?v=3.0.0') }}">
    <link rel="stylesheet" href="{{ asset($dir.'/css/custom.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .card { transition: all 0.3s ease; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); }
        .card:hover { transform: translateY(-5px); box-shadow: 0 6px 25px rgba(0, 0, 0, 0.15); }
        .input-group input:focus { border-color: #4F46E5; }
        .bg-gradient-primary { background: linear-gradient(90deg, #4F46E5 0%, #7C3AED 100%); }
        .btn-gradient { transition: all 0.3s ease; }
        .btn-gradient:hover { transform: translateY(-2px); background: linear-gradient(90deg, #4338CA 0%, #6D28D9 100%); }
        .dark-mode { background-color: #1F2937; }
        .dark-mode .card { background-color: #374151; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3); }
        .dark-mode .bg-gray-200 { background-color: #111827; }
        .dark-mode .text-white { color: #F3F4F6; }
        .dark-mode .bg-gradient-primary { background: linear-gradient(90deg, #312E81 0%, #4338CA 100%); }
        .dark-mode .input-group input { background-color: #4B5563; color: #F3F4F6; }
        .dark-mode .input-group label { color: #D1D5DB; }
        .fadeInBottom { animation: fadeInBottom 0.6s ease-in-out; }
        @keyframes fadeInBottom { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body class="bg-gray-200">
<main class="main-content mt-0">
    <div class="page-header align-items-start min-vh-100"
         style="background-image: url('https://images.unsplash.com/photo-1497294815431-9365093b7331?auto=format&fit=crop&w=1950&q=80');">
        <span class="mask bg-gradient-dark opacity-6"></span>
        <div class="container mt-5">
            <div class="row signin-margin justify-content-center">
                <div class="col-lg-4 col-md-8 col-12">
                    <div class="card z-index-0 fadeInBottom">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg py-4 pe-1">
                                <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">{{ __('Sign In') }}</h4>
                                <div class="row mt-3">
                                    <div class="col-2 text-center ms-auto">
                                        <a class="btn btn-link px-3" href="javascript:;">
                                            <i class="fab fa-facebook text-white text-lg"></i>
                                        </a>
                                    </div>
                                    <div class="col-2 text-center px-1">
                                        <a class="btn btn-link px-3" href="javascript:;">
                                            <i class="fab fa-github text-white text-lg"></i>
                                        </a>
                                    </div>
                                    <div class="col-2 text-center me-auto">
                                        <a class="btn btn-link px-3" href="javascript:;">
                                            <i class="fab fa-google text-white text-lg"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-6">
                            <form role="form" method="POST" action="{{ route('organization.login') }}" class="text-start">
                                @csrf
                                <div class="d-flex justify-content-center mb-4">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="loginToggle" checked>
                                        <label class="form-check-label" for="loginToggle" id="toggleLabel">Use Email</label>
                                    </div>
                                </div>

                                <div class="input-group input-group-outline mt-4">
                                    <label class="form-label" id="inputLabel">{{ __('Email') }}</label>
                                    <input type="email" class="form-control" name="email" id="loginInput">
                                </div>
                                @error('email')
                                <p class="text-danger text-sm mt-1">{{ $message }}</p>
                                @enderror

                                <div class="input-group input-group-outline mt-4">
                                    <label class="form-label">{{ __('Password') }}</label>
                                    <input type="password" class="form-control" name="password">
                                </div>
                                @error('password')
                                <p class="text-danger text-sm mt-1">{{ $message }}</p>
                                @enderror

                                <div class="form-check form-switch d-flex align-items-center my-4">
                                    <input class="form-check-input" type="checkbox" id="rememberMe">
                                    <label class="form-check-label mb-0 ms-2" for="rememberMe">{{ __('Remember me') }}</label>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn bg-gradient-primary w-100 my-4 mb-2 btn-gradient">{{ __('Sign In') }}</button>
                                </div>

                                <p class="text-sm text-center">
                                    {{ __('Forgot your password? Reset it') }}
                                    <a href="#" class="text-primary text-gradient font-weight-bold">{{ __('here') }}</a>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('organization::dashboard.partials.footers.guest')
    </div>
</main>

{{-- Scripts --}}
<script src="{{ asset('material/assets/js/jquery.min.js') }}"></script>
<script>
    $(function() {
        $('.input-group input').each(function() {
            if ($(this).val()) {
                $(this).closest('.input-group').addClass('is-filled');
            }
            $(this).on('input focus', function() {
                $(this).closest('.input-group').addClass('is-filled');
            });
            $(this).on('blur', function() {
                if (!$(this).val()) {
                    $(this).closest('.input-group').removeClass('is-filled');
                }
            });
        });
    });
</script>

<script>
    $(function() {
        const loginToggle = $('#loginToggle');
        const loginInput = $('#loginInput');
        const inputLabel = $('#inputLabel');
        const toggleLabel = $('#toggleLabel');

        loginToggle.on('change', function() {
            if (loginToggle.is(':checked')) {
                loginInput.attr('type', 'email');
                loginInput.attr('name', 'email');
                inputLabel.text('{{ __("Email") }}');
                toggleLabel.text('Use Email');
                loginInput.val('{{ old("email", "admin@material.com") }}');
            } else {
                loginInput.attr('type', 'tel');
                loginInput.attr('name', 'phone');
                inputLabel.text('{{ __("Phone Number") }}');
                toggleLabel.text('Use Phone');
                loginInput.val('');
            }
            loginInput.closest('.input-group').removeClass('is-filled');
            if (loginInput.val()) {
                loginInput.closest('.input-group').addClass('is-filled');
            }
        });

        // Existing input group handling
        $('.input-group input').each(function() {
            if ($(this).val()) {
                $(this).closest('.input-group').addClass('is-filled');
            }
            $(this).on('input focus', function() {
                $(this).closest('.input-group').addClass('is-filled');
            });
            $(this).on('blur', function() {
                if (!$(this).val()) {
                    $(this).closest('.input-group').removeClass('is-filled');
                }
            });
        });
    });
</script>
</body>
</html>
