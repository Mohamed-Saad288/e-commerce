@extends('admin::dashboard.master')
@section('title', __('messages.plan_details'))

@section('content')
    <div class="container-fluid">
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="page-title mb-1">{{ __('messages.plan_details') }}</h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('messages.dashboard') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.plans.index') }}">{{ __('messages.plans') }}</a></li>
                        <li class="breadcrumb-item active">{{ $plan->name }}</li>
                    </ol>
                </nav>
            </div>
            <div class="btn-group">
                <a href="{{ route('admin.plans.edit', $plan->id) }}" class="btn btn-outline-primary">
                    <i class="fe fe-edit"></i> {{ __('messages.edit') }}
                </a>
                <a href="{{ route('admin.plans.index') }}" class="btn btn-light">
                    <i class="fe fe-arrow-left"></i> {{ __('messages.back') }}
                </a>
            </div>
        </div>

        <div class="row">
            <!-- Plan Overview Card -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="plan-image mb-3">
                            @if($plan->getImage())
                                <img src="{{ $plan->getImage() }}" alt="Plan Image" class="rounded-lg mb-3" style="width: 120px; height: 120px; object-fit: cover;">
                            @else
                                <div class="image-placeholder mb-3">
                                    <div class="bg-light rounded-lg d-flex align-items-center justify-content-center" style="width: 120px; height: 120px; margin: 0 auto;">
                                        <i class="fe fe-package text-muted" style="font-size: 48px;"></i>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <h4 class="plan-name mb-2">{{ $plan->name }}</h4>

                        <div class="plan-price mb-3">
                            <span class="h2 text-dark mb-0">${{ number_format($plan->price, 2) }}</span>
                            <small class="text-muted">/ {{ $plan->billing_type == 1 ? __('messages.month') : __('messages.year') }}</small>
                        </div>

                        <div class="plan-status">
                            @if($plan->is_active)
                                <span class="badge badge-soft-success px-3 py-2">
                                    <i class="fe fe-check-circle me-1"></i>{{ __('messages.active') }}
                                </span>
                            @else
                                <span class="badge badge-soft-danger px-3 py-2">
                                    <i class="fe fe-x-circle me-1"></i>{{ __('messages.inactive') }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Plan Information Card -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-transparent border-0 pb-0">
                        <h5 class="card-title mb-0">{{ __('messages.plan_information') }}</h5>
                    </div>
                    <div class="card-body pt-0">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="info-item">
                                    <label class="info-label">{{ __('messages.slug') }}</label>
                                    <div class="info-value">{{ $plan->slug ?: '-' }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <label class="info-label">{{ __('messages.sort_order') }}</label>
                                    <div class="info-value">{{ $plan->sort_order }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <label class="info-label">{{ __('messages.duration') }}</label>
                                    <div class="info-value">{{ $plan->duration }} {{ __('messages.days') }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <label class="info-label">{{ __('messages.trial_period') }}</label>
                                    <div class="info-value">{{ $plan->trial_period }} {{ __('messages.days') }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <label class="info-label">{{ __('messages.created_at') }}</label>
                                    <div class="info-value">{{ $plan->created_at->format('M d, Y - H:i') }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <label class="info-label">{{ __('messages.updated_at') }}</label>
                                    <div class="info-value">{{ $plan->updated_at->format('M d, Y - H:i') }}</div>
                                </div>
                            </div>
                        </div>

                        @if($plan->description)
                            <div class="mt-4">
                                <label class="info-label">{{ __('messages.description') }}</label>
                                <div class="description-box">
                                    {{ $plan->description }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Plan Features Card -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="fe fe-layers me-2"></i>{{ __('messages.plan_features') }}
                        </h5>
                        @if(count($planFeatures) > 0)
                            <span class="badge badge-soft-primary">{{ count($planFeatures) }} {{ __('messages.features') }}</span>
                        @endif
                    </div>
                    <div class="card-body pt-0">
                        @if(count($planFeatures) > 0)
                            <div class="features-grid">
                                @foreach($planFeatures as $planFeature)
                                    <div class="feature-item {{ !$planFeature->is_active ? 'feature-disabled' : '' }}">
                                        <div class="feature-header">
                                            <div class="feature-name">
                                                {{ $planFeature->feature->name ?? 'N/A' }}
                                                @if(!$planFeature->is_active)
                                                    <span class="feature-inactive-badge">{{ __('messages.inactive') }}</span>
                                                @endif
                                            </div>
                                            <div class="feature-type">
                                                @if($planFeature->feature)
                                                    @switch($planFeature->feature->type)
                                                        @case(1)
                                                            <span class="type-badge type-limit">{{ __('messages.limit') }}</span>
                                                            @break
                                                        @case(2)
                                                            <span class="type-badge type-boolean">{{ __('messages.boolean') }}</span>
                                                            @break
                                                        @case(3)
                                                            <span class="type-badge type-text">{{ __('messages.text') }}</span>
                                                            @break
                                                    @endswitch
                                                @endif
                                            </div>
                                        </div>

                                        @if($planFeature->feature && $planFeature->feature->description)
                                            <div class="feature-description">
                                                {{ $planFeature->feature->description }}
                                            </div>
                                        @endif

                                        <div class="feature-value">
                                            @if($planFeature->feature && $planFeature->feature->type == 2)
                                                <!-- Boolean type -->
                                                <div class="value-display boolean-value {{ $planFeature->feature_value == '1' ? 'value-yes' : 'value-no' }}">
                                                    <i class="fe {{ $planFeature->feature_value == '1' ? 'fe-check' : 'fe-x' }}"></i>
                                                    {{ $planFeature->feature_value == '1' ? __('messages.yes') : __('messages.no') }}
                                                </div>
                                            @else
                                                <!-- Limit or Text type -->
                                                <div class="value-display">
                                                    {{ $planFeature->feature_value ?: __('messages.not_set') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="fe fe-package"></i>
                                </div>
                                <h6 class="empty-title">{{ __('messages.no_features_found') }}</h6>
                                <p class="empty-description">{{ __('messages.no_features_assigned_to_plan') }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('after_script')
    <style>
        .page-title {
            color: #2d3748;
            font-weight: 600;
        }

        .breadcrumb {
            background: none;
            padding: 0;
        }

        .breadcrumb-item a {
            color: #718096;
            text-decoration: none;
        }

        .breadcrumb-item.active {
            color: #4a5568;
        }

        .card {
            transition: all 0.3s ease;
        }

        .plan-name {
            color: #2d3748;
            font-weight: 600;
        }

        .plan-price {
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 1rem;
        }

        .badge-soft-success {
            background-color: #f0fff4;
            color: #38a169;
            border: 1px solid #9ae6b4;
        }

        .badge-soft-danger {
            background-color: #fed7d7;
            color: #e53e3e;
            border: 1px solid #feb2b2;
        }

        .badge-soft-primary {
            background-color: #ebf8ff;
            color: #3182ce;
            border: 1px solid #90cdf4;
        }

        .info-item {
            margin-bottom: 1.5rem;
        }

        .info-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: #718096;
            margin-bottom: 0.5rem;
        }

        .info-value {
            color: #2d3748;
            font-weight: 500;
        }

        .description-box {
            background-color: #f7fafc;
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            padding: 1rem;
            color: #4a5568;
            line-height: 1.6;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 1.5rem;
        }

        .feature-item {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 0.75rem;
            padding: 1.25rem;
            transition: all 0.3s ease;
        }

        .feature-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .feature-disabled {
            opacity: 0.6;
            background: #f8f9fa;
        }

        .feature-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 0.75rem;
        }

        .feature-name {
            font-weight: 600;
            color: #2d3748;
            font-size: 1rem;
        }

        .feature-inactive-badge {
            font-size: 0.75rem;
            color: #e53e3e;
            margin-left: 0.5rem;
            font-weight: 400;
        }

        .type-badge {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            border-radius: 0.375rem;
            font-weight: 500;
        }

        .type-limit {
            background-color: #e6fffa;
            color: #319795;
        }

        .type-boolean {
            background-color: #fef5e7;
            color: #d69e2e;
        }

        .type-text {
            background-color: #edf2f7;
            color: #4a5568;
        }

        .feature-description {
            color: #718096;
            font-size: 0.875rem;
            margin-bottom: 1rem;
            line-height: 1.5;
        }

        .value-display {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 0.375rem;
            padding: 0.75rem;
            font-weight: 500;
            color: #2d3748;
        }

        .boolean-value {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .value-yes {
            background-color: #f0fff4;
            border-color: #9ae6b4;
            color: #38a169;
        }

        .value-no {
            background-color: #fed7d7;
            border-color: #feb2b2;
            color: #e53e3e;
        }

        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
        }

        .empty-icon {
            font-size: 4rem;
            color: #cbd5e0;
            margin-bottom: 1rem;
        }

        .empty-title {
            color: #4a5568;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .empty-description {
            color: #718096;
            margin: 0;
        }

        .btn-group .btn {
            border-radius: 0.375rem;
            font-weight: 500;
        }

        .btn-outline-primary {
            color: #3182ce;
            border-color: #3182ce;
        }

        .btn-outline-primary:hover {
            background-color: #3182ce;
            border-color: #3182ce;
        }

        .btn-light {
            background-color: #f7fafc;
            border-color: #e2e8f0;
            color: #4a5568;
        }

        .btn-light:hover {
            background-color: #edf2f7;
            border-color: #cbd5e0;
        }

        @media (max-width: 768px) {
            .features-grid {
                grid-template-columns: 1fr;
            }

            .btn-group {
                flex-direction: column;
                width: 100%;
            }

            .btn-group .btn {
                width: 100%;
                margin-bottom: 0.5rem;
            }
        }
    </style>
@endsection
