@extends('organization::dashboard.master')
@section('title', __('messages.profile'))

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Profile Card -->
                <div class="card shadow-sm border-0 glow-card">
                    <div class="card-header bg-primary text-white text-center py-4">
                        <h3 class="mb-0">{{ __('messages.profile') }}</h3>
                    </div>
                    <div class="card-body p-4">
                        <!-- Profile Information -->
                        <div class="text-center mb-4">
                            <img src="{{ $auth->profile_photo_path ?? 'https://api.dicebear.com/9.x/adventurer/svg?seed=default' }}"
                                 class="rounded-circle img-fluid mb-3 profile-img"
                                 alt="Profile Picture"
                                 style="width: 120px; height: 120px; object-fit: cover;">
                            <h4 class="fw-bold">{{ $auth->name }}</h4>
                        </div>

                        <div class="row">
                            <!-- Email -->
                            <div class="col-md-6 mb-3">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-envelope-fill text-primary me-3" style="font-size: 1.5rem;"></i>
                                            <div>
                                                <small class="text-muted">{{ __('messages.email') }}</small>
                                                <p class="mb-0">{{ $auth->email ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Phone -->
                            <div class="col-md-6 mb-3">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-telephone-fill text-primary me-3" style="font-size: 1.5rem;"></i>
                                            <div>
                                                <small class="text-muted">{{ __('messages.phone') }}</small>
                                                <p class="mb-0">{{ $auth->phone ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Change Password Button -->
                        <div class="text-center mt-4">
                            <a href="{{ route('organization.password.change') }}"
                               class="btn btn-outline-primary px-4 pulse-btn">
                                <i class="bi bi-lock-fill me-2"></i>{{ __('messages.change_password') }}
                            </a>
                        </div>
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
        .btn-outline-primary {
            border-width: 2px;
            font-weight: 500;
        }
        .btn-outline-primary:hover {
            background-color: #0d6efd;
            color: white;
        }
        /* Profile Image Zoom Effect */
        .profile-img {
            transition: transform 0.3s ease;
        }
        .profile-img:hover {
            transform: scale(1.1);
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
        /* Glowing Border Animation */
        .glow-card:hover {
            animation: glow 1.5s infinite;
        }
        @keyframes glow {
            0% {
                box-shadow: 0 0 5px rgba(13, 110, 253, 0.5), 0 0 10px rgba(13, 110, 253, 0.3);
            }
            50% {
                box-shadow: 0 0 10px rgba(13, 110, 253, 0.7), 0 0 20px rgba(13, 110, 253, 0.5);
            }
            100% {
                box-shadow: 0 0 5px rgba(13, 110, 253, 0.5), 0 0 10px rgba(13, 110, 253, 0.3);
            }
        }
    </style>
@endsection
