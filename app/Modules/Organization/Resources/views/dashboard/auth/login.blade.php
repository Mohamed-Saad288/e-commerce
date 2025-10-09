@extends('admin::dashboard.auth.master')
@section('title', 'Admin Login')

@section('content')
    <style>
        * {
            box-sizing: border-box;
        }

        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: 'Poppins', sans-serif;
            overflow: hidden;
        }

        .login-wrapper {
            position: relative;
            width: 100%;
            height: 100vh;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 50%, #7e22ce 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        /* Animated mesh gradient background */
        .mesh-gradient {
            position: absolute;
            width: 100%;
            height: 100%;
            opacity: 0.6;
            background:
                radial-gradient(at 20% 30%, rgba(124, 58, 237, 0.5) 0px, transparent 50%),
                radial-gradient(at 80% 70%, rgba(59, 130, 246, 0.5) 0px, transparent 50%),
                radial-gradient(at 50% 50%, rgba(139, 92, 246, 0.5) 0px, transparent 50%);
            animation: mesh-move 10s ease-in-out infinite;
        }

        @keyframes mesh-move {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(50px, 50px); }
        }

        /* Grid pattern overlay */
        .grid-overlay {
            position: absolute;
            width: 100%;
            height: 100%;
            background-image:
                linear-gradient(rgba(255,255,255,.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,.03) 1px, transparent 1px);
            background-size: 50px 50px;
            animation: grid-scroll 20s linear infinite;
        }

        @keyframes grid-scroll {
            0% { transform: translate(0, 0); }
            100% { transform: translate(50px, 50px); }
        }

        /* Floating orbs */
        /* Floating commerce icons */
        .commerce-icon {
            position: absolute;
            color: rgba(255, 255, 255, 0.15);
            animation: float-icon 20s ease-in-out infinite;
        }

        .commerce-icon.icon-1 {
            font-size: 3rem;
            top: 10%;
            right: 10%;
            animation-delay: 0s;
        }

        .commerce-icon.icon-2 {
            font-size: 2.5rem;
            bottom: 15%;
            left: 8%;
            animation-delay: 3s;
        }

        .commerce-icon.icon-3 {
            font-size: 2rem;
            top: 25%;
            left: 15%;
            animation-delay: 6s;
        }

        .commerce-icon.icon-4 {
            font-size: 2.2rem;
            bottom: 30%;
            right: 12%;
            animation-delay: 9s;
        }

        @keyframes float-icon {
            0%, 100% {
                transform: translateY(0) rotate(0deg);
                opacity: 0.15;
            }
            50% {
                transform: translateY(-20px) rotate(10deg);
                opacity: 0.25;
            }
        }

        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            opacity: 0.4;
            animation: float-smooth 15s ease-in-out infinite;
        }

        .orb-1 {
            width: 400px;
            height: 400px;
            background: linear-gradient(135deg, #8b5cf6, #ec4899);
            top: -100px;
            left: -100px;
        }

        .orb-2 {
            width: 350px;
            height: 350px;
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            bottom: -100px;
            right: -100px;
            animation-delay: 5s;
        }

        @keyframes float-smooth {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(30px, 30px) scale(1.1); }
        }

        /* Main login card - split design */
        .login-container {
            position: relative;
            z-index: 10;
            display: flex;
            width: 100%;
            max-width: 1000px;
            min-height: 600px;
            background: rgba(255, 255, 255, 0.98);
            border-radius: 30px;
            overflow: hidden;
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.4);
            animation: slideIn 0.8s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: scale(0.9) translateY(50px);
            }
            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        /* Left side - Branding */
        .login-brand {
            flex: 1;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 60px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .login-brand::before {
            content: '';
            position: absolute;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: rotate-slow 30s linear infinite;
        }

        @keyframes rotate-slow {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .brand-content {
            position: relative;
            z-index: 2;
            text-align: center;
            color: white;
        }

        .logo-circle {
            width: 140px;
            height: 140px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            transition: transform 0.5s ease;
        }

        .logo-circle:hover {
            transform: rotate(360deg) scale(1.1);
        }

        .logo-circle img {
            height: 80px;
            filter: brightness(0) invert(1) drop-shadow(0 4px 8px rgba(0,0,0,0.3));
        }

        .brand-title {
            font-size: 2.2rem;
            font-weight: 700;
            margin: 0 0 15px;
            text-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .brand-subtitle {
            font-size: 1.1rem;
            opacity: 0.95;
            margin: 0 0 40px;
            line-height: 1.6;
        }

        .brand-features {
            display: flex;
            flex-direction: column;
            gap: 20px;
            margin-top: 30px;
        }

        /* E-commerce stats badges */
        .stats-badges {
            display: flex;
            gap: 15px;
            margin-top: 35px;
            justify-content: center;
        }

        .stat-badge {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            padding: 12px 20px;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            text-align: center;
        }

        .stat-number {
            font-size: 1.4rem;
            font-weight: 700;
            display: block;
            margin-bottom: 3px;
        }

        .stat-label {
            font-size: 0.75rem;
            opacity: 0.9;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 15px;
            background: rgba(255, 255, 255, 0.15);
            padding: 15px 20px;
            border-radius: 15px;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .feature-item:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateX(10px);
        }

        .feature-icon {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        .feature-text {
            font-size: 0.95rem;
            font-weight: 500;
        }

        /* Right side - Form */
        .login-form-section {
            flex: 1;
            padding: 60px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: linear-gradient(180deg, #ffffff 0%, #f9fafb 100%);
        }

        .form-header {
            margin-bottom: 40px;
        }

        .form-header h2 {
            font-size: 2rem;
            font-weight: 700;
            color: #1f2937;
            margin: 0 0 10px;
            letter-spacing: -0.5px;
        }

        .form-header p {
            font-size: 1rem;
            color: #6b7280;
            margin: 0;
        }

        .alert {
            border-radius: 15px;
            border: none;
            padding: 15px 20px;
            margin-bottom: 25px;
            font-size: 0.95rem;
            animation: slideDown 0.5s ease;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
        }

        .alert-danger {
            background: #fee2e2;
            color: #991b1b;
        }

        /* Toggle Switch - Modern Style */
        .toggle-container {
            display: flex;
            justify-content: center;
            margin: 0 0 35px 0;
        }

        .toggle-switch {
            position: relative;
            display: inline-flex;
            background: #f3f4f6;
            border-radius: 50px;
            padding: 5px;
            gap: 5px;
        }

        .toggle-switch input {
            display: none;
        }

        .toggle-option {
            padding: 12px 28px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.3s ease;
            color: #6b7280;
            display: flex;
            align-items: center;
            gap: 8px;
            z-index: 2;
            position: relative;
        }

        .toggle-option i {
            font-size: 1.1rem;
        }

        .toggle-slider {
            position: absolute;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 50px;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
            height: calc(100% - 10px);
            top: 5px;
        }

        input:not(:checked) ~ .toggle-slider {
            left: 5px;
            width: calc(50% - 7.5px);
        }

        input:checked ~ .toggle-slider {
            left: calc(50% + 2.5px);
            width: calc(50% - 7.5px);
        }

        input:not(:checked) ~ .toggle-option:first-of-type,
        input:checked ~ .toggle-option:last-of-type {
            color: white;
        }

        /* Form inputs */
        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 10px;
            font-size: 0.95rem;
            display: block;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            z-index: 2;
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 2;
            padding: 5px;
        }

        .password-toggle:hover {
            color: #667eea;
        }

        .password-toggle:active {
            transform: translateY(-50%) scale(0.9);
        }

        .form-control {
            width: 100%;
            padding: 15px 20px 15px 50px;
            border: 2px solid #e5e7eb;
            border-radius: 15px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: white;
            font-family: 'Poppins', sans-serif;
        }

        .form-control.has-toggle {
            padding-right: 55px;
        }

        .form-control:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }

        .form-control:focus + .input-icon {
            color: #667eea;
            transform: translateY(-50%) scale(1.1);
        }

        .form-control::placeholder {
            color: #d1d5db;
        }

        .form-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 20px 0 30px;
        }

        .form-check {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-check-input {
            width: 20px;
            height: 20px;
            border: 2px solid #d1d5db;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
            appearance: none;
            background: white;
            position: relative;
        }

        .form-check-input:checked {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-color: #667eea;
        }

        .form-check-input:checked::after {
            content: '✓';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 12px;
            font-weight: bold;
        }

        .form-check-label {
            font-size: 0.9rem;
            color: #6b7280;
            cursor: pointer;
            user-select: none;
        }

        .forgot-link {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            position: relative;
        }

        .forgot-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -2px;
            left: 0;
            background: #667eea;
            transition: width 0.3s ease;
        }

        .forgot-link:hover::after {
            width: 100%;
        }

        .btn-primary {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            border-radius: 15px;
            font-size: 1.05rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.4s ease;
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
            position: relative;
            overflow: hidden;
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s ease;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(102, 126, 234, 0.5);
        }

        .btn-primary:hover::before {
            left: 100%;
        }

        .btn-primary:active {
            transform: translateY(-1px);
        }

        .login-footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 25px;
            border-top: 2px solid #e5e7eb;
            font-size: 0.85rem;
            color: #9ca3af;
        }

        .invalid-feedback {
            display: block;
            margin-top: 8px;
            font-size: 0.85rem;
            color: #ef4444;
            font-weight: 500;
        }

        /* Responsive */
        @media (max-width: 968px) {
            .login-container {
                flex-direction: column;
                max-width: 500px;
            }

            .login-brand {
                padding: 40px 30px;
                min-height: auto;
            }

            .brand-features {
                display: none;
            }

            .login-form-section {
                padding: 40px 30px;
            }

            .logo-circle {
                width: 100px;
                height: 100px;
                margin-bottom: 20px;
            }

            .logo-circle img {
                height: 60px;
            }

            .brand-title {
                font-size: 1.6rem;
            }

            .brand-subtitle {
                font-size: 0.95rem;
                margin-bottom: 0;
            }

            .form-header h2 {
                font-size: 1.6rem;
            }
        }

        @media (max-width: 576px) {
            .login-wrapper {
                padding: 10px;
            }

            .login-container {
                border-radius: 20px;
            }

            .login-brand,
            .login-form-section {
                padding: 30px 20px;
            }

            .form-header h2 {
                font-size: 1.4rem;
            }

            .toggle-option {
                padding: 10px 20px;
                font-size: 0.9rem;
            }

            .form-control {
                padding: 13px 18px 13px 45px;
            }
        }
    </style>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <div class="login-wrapper">
        <div class="mesh-gradient"></div>
        <div class="grid-overlay"></div>
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>

        <div class="login-container">
            <!-- Left Side - Branding -->
            <div class="login-brand">
                <i class="fas fa-credit-card commerce-icon icon-1"></i>
                <i class="fas fa-box commerce-icon icon-2"></i>
                <i class="fas fa-truck commerce-icon icon-3"></i>
                <i class="fas fa-percent commerce-icon icon-4"></i>

                <div class="brand-content">
                    <div class="logo-circle">
                        <img src="{{ $logo }}" alt="E-Shop Logo">
                    </div>
                    <h1 class="brand-title">E-Commerce Admin</h1>
                    <p class="brand-subtitle">Your complete solution for<br>managing online store success</p>

                    <div class="stats-badges">
                        <div class="stat-badge">
                            <span class="stat-number">24/7</span>
                            <span class="stat-label">Support</span>
                        </div>
                        <div class="stat-badge">
                            <span class="stat-number">100%</span>
                            <span class="stat-label">Secure</span>
                        </div>
                    </div>

                    <div class="brand-features">
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <span class="feature-text">Manage Orders & Inventory</span>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <span class="feature-text">Customer Management</span>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <span class="feature-text">Sales Analytics & Reports</span>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-tags"></i>
                            </div>
                            <span class="feature-text">Products & Categories</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side - Form -->
            <div class="login-form-section">
                <div class="form-header">
                    <h2>Welcome Back</h2>
                    <p>Access your store dashboard and manage everything</p>
                </div>

                @if(session('status'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        {{ session('status') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('organization.login.submit') }}" id="loginForm">
                    @csrf

                    <!-- Toggle Switch -->
                    <div class="toggle-container">
                        <label class="toggle-switch">
                            <input type="checkbox" id="loginTypeToggle">
                            <span class="toggle-slider"></span>
                            <span class="toggle-option" id="emailOption">
                                <i class="fas fa-envelope"></i>
                                Email
                            </span>
                            <span class="toggle-option" id="phoneOption">
                                <i class="fas fa-phone"></i>
                                Phone
                            </span>
                        </label>
                    </div>

                    <!-- Login Input -->
                    <div class="form-group">
                        <label for="loginInput" class="form-label" id="inputLabel">Email Address</label>
                        <div class="input-wrapper">
                            <input
                                type="text"
                                name="login"
                                id="loginInput"
                                class="form-control @error('login') is-invalid @enderror"
                                placeholder="Enter your email"
                                value="{{ old('login') }}"
                                required
                            >
                            <i class="fas fa-envelope input-icon" id="inputIcon"></i>
                        </div>
                        @error('login')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-wrapper">
                            <input
                                type="password"
                                name="password"
                                id="password"
                                class="form-control has-toggle @error('password') is-invalid @enderror"
                                placeholder="Enter your password"
                                required
                            >
                            <i class="fas fa-lock input-icon"></i>
                            <i class="fas fa-eye password-toggle" id="togglePassword"></i>
                        </div>
                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Remember & Forgot -->
                    <div class="form-row">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="rememberMe">
                            <label class="form-check-label" for="rememberMe">Remember me</label>
                        </div>
                        <a href="#" class="forgot-link">Forgot Password?</a>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-sign-in-alt" style="margin-right: 10px;"></i>
                        Sign In
                    </button>
                </form>

                <div class="login-footer">
                    &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        const toggle = document.getElementById('loginTypeToggle');
        const loginInput = document.getElementById('loginInput');
        const inputLabel = document.getElementById('inputLabel');
        const inputIcon = document.getElementById('inputIcon');
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');

        // Password toggle functionality
        togglePassword.addEventListener('click', function () {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            // Toggle icon
            if (type === 'text') {
                this.classList.remove('fa-eye');
                this.classList.add('fa-eye-slash');
            } else {
                this.classList.remove('fa-eye-slash');
                this.classList.add('fa-eye');
            }
        });

        // Check old value on load
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
            loginInput.value = '';
            loginInput.focus();
        });

        function updateToPhone() {
            inputLabel.textContent = 'Phone Number';
            loginInput.placeholder = 'Enter your phone (e.g. +1234567890)';
            loginInput.type = 'tel';
            inputIcon.className = 'fas fa-phone input-icon';
        }

        function updateToEmail() {
            inputLabel.textContent = 'Email Address';
            loginInput.placeholder = 'Enter your email';
            loginInput.type = 'email';
            inputIcon.className = 'fas fa-envelope input-icon';
        }
    </script>
@endsection
