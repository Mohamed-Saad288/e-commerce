@extends('organization::dashboard.master')
@section('title', __('messages.change_password'))

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <!-- Change Password Card -->
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white text-center py-4">
                        <h3 class="mb-0">{{ __('messages.change_password') }}</h3>
                        <p class="mt-2 mb-0 text-light">{{ $auth->name ?? "N/A" }}</p>
                    </div>
                    <div class="card-body p-4">
                        <!-- Change Password Form -->
                        <form action="{{ route('organization.password.store') }}" method="POST" id="change-password-form">
                            @csrf
                            @method('PUT')

                            <!-- New Password -->
                            <div class="mb-3 form-floating">
                                <input type="password" name="password" id="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       placeholder="{{ __('messages.enter_new_password') }}"
                                       required>
                                <label for="password" class="form-label">{{ __('messages.new_password') }}</label>
                                <div class="input-group mt-1">
                                <span class="input-group-text">
                                    <i class="bi bi-lock-fill"></i>
                                </span>
                                    @error('password')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Confirm New Password -->
                            <div class="mb-4 form-floating">
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                       class="form-control @error('password_confirmation') is-invalid @enderror"
                                       placeholder="{{ __('messages.confirm_new_password') }}"
                                       required>
                                <label for="password_confirmation" class="form-label">{{ __('messages.confirm_password') }}</label>
                                <div class="input-group mt-1">
                                <span class="input-group-text">
                                    <i class="bi bi-lock-fill"></i>
                                </span>
                                    @error('password_confirmation')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary px-4 pulse-btn">
                                    <i class="bi bi-check-circle-fill me-2"></i>{{ __('messages.update_password') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Bootstrap Icons for better visuals -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        .card {
            transition: transform 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .card-header {
            border-radius: 0.5rem 0.5rem 0 0;
        }
        .card-body {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        }
        .btn-primary {
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #005cbf;
            transform: translateY(-2px);
        }
        /* Pulse Animation for Button */
        .pulse-btn {
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(13, 110, 253, 0.4);
            }
            70% {
                box-shadow: 0 0 0 10px rgba(13, 110, 253, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(13, 110, 253, 0);
            }
        }
        /* Input Focus Animation */
        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 8px rgba(13, 110, 253, 0.3);
            transform: scale(1.02);
            transition: all 0.2s ease;
        }
        /* Floating Label Styling */
        .form-floating > .form-control {
            height: calc(3.5rem + 2px);
        }
        .form-floating > .form-control:focus ~ label,
        .form-floating > .form-control:not(:placeholder-shown) ~ label {
            opacity: 0.65;
            transform: scale(0.85) translateY(-0.5rem) translateX(0.15rem);
            color: #0d6efd;
        }
    </style>

    <!-- JavaScript for Form Interaction -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('change-password-form');
            form.addEventListener('submit', function (e) {
                const newPassword = document.getElementById('password').value;
                const confirmPassword = document.getElementById('password_confirmation').value;
                if (newPassword !== confirmPassword) {
                    e.preventDefault();
                    alert('{{ __('messages.password_mismatch') }}');
                }
            });
        });
    </script>
@endsection
