@extends('admin::dashboard.auth.master')
@section('title', 'Admin Login')

@section('content')
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow: hidden;
        }

        .login-wrapper {
            position: relative;
            width: 100%;
            height: 100vh;
            background-image: url('https://images.unsplash.com/photo-1607082348823-0a826c89695b?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: fadeIn 1s ease-in;
        }

        /* Overlay */
        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            z-index: 1;
        }

        .login-container {
            position: relative;
            z-index: 2;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
            width: 90%;
            max-width: 480px;
            overflow: hidden;
            opacity: 0;
            transform: translateY(30px);
            animation: slideUp 0.8s ease forwards;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-header {
            text-align: center;
            padding: 2.5rem 2rem;
            background: linear-gradient(135deg, #5a36dc 0%, #4a27b7 100%);
            color: white;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .login-header .logo {
            margin-bottom: 1rem;
        }

        .login-header .logo img {
            height: 60px;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));
            transition: transform 0.3s ease;
        }

        .login-header .logo img:hover {
            transform: scale(1.1);
        }

        .login-header h3 {
            font-size: 1.6rem;
            font-weight: 600;
            margin: 0;
        }

        .login-header p {
            font-size: 0.95rem;
            opacity: 0.9;
            margin: 0.5rem 0 0;
        }

        .login-body {
            padding: 2.5rem;
        }

        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 0.6rem;
        }

        .input-group-text {
            background: #f1f3f5;
            border: 1px solid #ced4da;
            border-top-left-radius: 8px;
            border-bottom-left-radius: 8px;
        }

        .form-control {
            border-top-right-radius: 8px;
            border-bottom-right-radius: 8px;
            border: 1px solid #ced4da;
            padding: 0.7rem 1rem;
            font-size: 1rem;
        }

        .form-control:focus {
            border-color: #5a36dc;
            box-shadow: 0 0 0 0.2rem rgba(90, 54, 220, 0.25);
        }

        /* Toggle Switch */
        .toggle-container {
            display: flex;
            justify-content: center;
            margin: 1.5rem 0;
        }

        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 220px;
            height: 46px;
        }

        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ddd;
            transition: .3s;
            border-radius: 23px;
        }

        .toggle-slider:before {
            position: absolute;
            content: "";
            height: 38px;
            width: 106px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            border-radius: 19px;
            transition: .3s;
        }

        input:checked + .toggle-slider {
            background-color: #5a36dc;
        }

        input:checked + .toggle-slider:before {
            transform: translateX(110px);
        }

        .toggle-labels {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 100%;
            text-align: center;
            font-weight: 600;
            font-size: 0.95rem;
            color: #fff;
            pointer-events: none;
            z-index: 2;
        }

        .toggle-labels .email {
            left: 12px;
        }

        .toggle-labels .phone {
            right: 12px;
        }

        .form-control-lg {
            font-size: 1rem;
            padding: 0.8rem 1rem;
        }

        .forgot-password {
            text-align: right;
            margin: 1rem 0;
            font-size: 0.9rem;
        }

        .forgot-password a {
            color: #5a36dc;
            text-decoration: none;
            font-weight: 500;
        }

        .forgot-password a:hover {
            text-decoration: underline;
        }

        .btn-primary {
            background: #5a36dc;
            border: none;
            padding: 0.9rem 0;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 10px;
            width: 100%;
            transition: background 0.3s ease, transform 0.2s ease;
            box-shadow: 0 4px 15px rgba(90, 54, 220, 0.3);
        }

        .btn-primary:hover {
            background: #4a27b7;
            transform: translateY(-2px);
        }

        .login-footer {
            text-align: center;
            margin-top: 1.8rem;
            font-size: 0.85rem;
            color: #6c757d;
        }

        .invalid-feedback {
            display: block;
            margin-top: 0.3rem;
            font-size: 0.85rem;
        }

        @media (max-width: 576px) {
            .login-body, .login-header {
                padding: 1.8rem;
            }
            .login-header h3 {
                font-size: 1.4rem;
            }
        }
    </style>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Segoe+UI:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <div class="login-wrapper">
        <div class="overlay"></div>

        <div class="login-container">
            <!-- Header -->
            <div class="login-header">
                <div class="logo">
                    <a href="{{ route('admin.dashboard') }}">
                        <img src="{{ $logo }}" alt="E-Shop Logo">
                    </a>
                </div>
                <h3>Welcome Back, Admin</h3>
                <p>Manage your e-commerce store with ease</p>
            </div>

            <!-- Body -->
            <div class="login-body">
                @if(session('status'))
                    <div class="alert alert-success alert-sm">
                        {{ session('status') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-sm">
                        {{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('organization.login') }}" id="loginForm">
                    @csrf
                    <!-- Toggle: Email or Phone -->
                    <div class="toggle-container">
                        <label class="toggle-switch">
                            <input type="checkbox" id="loginTypeToggle">
                            <span class="toggle-slider"></span>
                            <div class="toggle-labels">
                                <span class="email">with Email</span>
                                <span class="phone">with Phone</span>
                            </div>
                        </label>
                    </div>

                    <!-- Dynamic Input Field -->
                    <div class="mb-3">
                        <label for="loginInput" class="form-label" id="inputLabel">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <input
                                type="text"
                                name="login"
                                id="loginInput"
                                class="form-control form-control-lg @error('login') is-invalid @enderror"
                                placeholder="Enter your email"
                                value="{{ old('login') }}"
                                required
                            >
                        </div>
                        @error('login')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input
                                type="password"
                                name="password"
                                id="password"
                                class="form-control form-control-lg @error('password') is-invalid @enderror"
                                placeholder="Enter your password"
                                required
                            >
                        </div>
                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="rememberMe">
                            <label class="form-check-label" for="rememberMe">Remember me</label>
                        </div>
                        <a href="#" class="forgot-password">Forgot password?</a>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary btn-lg mt-3">
                        <i class="fas fa-sign-in-alt me-2"></i> Sign In
                    </button>
                </form>

                <!-- Footer -->
                <div class="login-footer">
                    &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for Toggle -->
    <script>
        const toggle = document.getElementById('loginTypeToggle');
        const loginInput = document.getElementById('loginInput');
        const inputLabel = document.getElementById('inputLabel');
        const icon = loginInput.closest('.input-group').querySelector('.fa-envelope');

        // On load: check if old value is phone-like
        window.onload = function () {
            const oldValue = loginInput.value.trim();
            if (oldValue && (oldValue.startsWith('+') || /^\d{10,}$/.test(oldValue))) {
                toggle.checked = true;
                updateToPhone();
            } else {
                updateToEmail();
            }
        };

        toggle.addEventListener('change', function () {
            if (toggle.checked) {
                updateToPhone();
            } else {
                updateToEmail();
            }
            loginInput.value = ''; // Optional: clear on switch
            loginInput.focus();
        });

        function updateToPhone() {
            inputLabel.textContent = 'Phone Number';
            loginInput.placeholder = 'Enter your phone (e.g. +1234567890)';
            loginInput.type = 'tel';
            icon.className = 'fas fa-phone';
        }

        function updateToEmail() {
            inputLabel.textContent = 'Email Address';
            loginInput.placeholder = 'Enter your email';
            loginInput.type = 'email';
            icon.className = 'fas fa-envelope';
        }
    </script>
@endsection
