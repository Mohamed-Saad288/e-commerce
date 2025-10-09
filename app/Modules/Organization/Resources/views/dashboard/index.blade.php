@extends('organization::dashboard.master')
@section('title', __('messages.home'))

@section('content')
    <style>
        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border-radius: 15px;
            backdrop-filter: blur(5px); /* Reduced blur for better visibility */
            background: rgba(255, 255, 255, 0.7); /* Increased opacity for less transparency */
            border: 1px solid rgba(255, 255, 255, 0.4); /* Slightly stronger border */
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }
        .card-body {
            padding: 1.5rem;
        }
        .progress {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 5px;
        }
        .progress-bar {
            border-radius: 5px;
        }
        h5 {
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        h2 {
            font-weight: 700;
            font-size: 2.5rem;
        }
        .options-card {
            background: linear-gradient(135deg, #1f4037 0%, #99f2c8 100%) !important;
            box-shadow: 0 0 20px rgba(153, 242, 200, 0.3);
        }
        .options-card .btn {
            transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
            border-radius: 10px;
            font-size: 1.1rem;
            padding: 0.75rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #ffffff 0%, #e0e0e0 100%);
            color: #1f4037;
            font-weight: 500;
        }
        .options-card .btn:hover {
            transform: scale(1.05);
            background: linear-gradient(135deg, #e0e0e0 0%, #ffffff 100%);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        .options-card .btn i {
            margin-right: 0.5rem;
        }
        .options-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1rem;
        }
    </style>

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row align-items-center mb-5">
                    <div class="col">
                        <h2 class="h3 page-title text-dark">{{ __('messages.welcome') }}!</h2>
                    </div>
                    <div class="col-auto">
                        <form class="form-inline">
                            <div class="form-group d-none d-lg-inline">
                                <span class="small text-dark"> {{ now()->format('F j, Y') }} <div class="clock" id="clock"></div>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Luxurious Statistics Section -->
                <div class="row my-4">
                    <!-- Pending Orders -->
                    <div class="col-md-4 col-lg-3 mb-4">
                        <div class="card shadow border-0 rounded-lg overflow-hidden" style="background: linear-gradient(135deg, #d4a017 0%, #e5734f 100%);">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h5 class="text-white mb-2">{{ __("messages.pending_orders") }}</h5>
                                        <h2 class="text-white mb-0">{{ $data['pendingOrders'] ?? 0 }}</h2>
                                    </div>
                                    <div class="ml-auto">
                                        <i class="fe fe-clock fe-3x text-white-50"></i>
                                    </div>
                                </div>
                                <div class="progress mt-3" style="height: 6px;">
                                    <div class="progress-bar bg-white" role="progressbar" style="width: 60%;" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Approved Orders -->
                    <div class="col-md-4 col-lg-3 mb-4">
                        <div class="card shadow border-0 rounded-lg overflow-hidden" style="background: linear-gradient(135deg, #5fc78a 0%, #5f9cc5 100%);">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h5 class="text-white mb-2">{{ __("messages.approved_orders") }}</h5>
                                        <h2 class="text-white mb-0">{{ $data['approvedOrders'] ?? 0 }}</h2>
                                    </div>
                                    <div class="ml-auto">
                                        <i class="fe fe-check-circle fe-3x text-white-50"></i>
                                    </div>
                                </div>
                                <div class="progress mt-3" style="height: 6px;">
                                    <div class="progress-bar bg-white" role="progressbar" style="width: 80%;" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Orders -->
                    <div class="col-md-4 col-lg-3 mb-4">
                        <div class="card shadow border-0 rounded-lg overflow-hidden" style="background: linear-gradient(135deg, #7b4ca0 0%, #d88eb2 100%);">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h5 class="text-white mb-2">{{ __("messages.total_orders") }}</h5>
                                        <h2 class="text-white mb-0">{{ $data['totalOrders'] ?? 0 }}</h2>
                                    </div>
                                    <div class="ml-auto">
                                        <i class="fe fe-shopping-cart fe-3x text-white-50"></i>
                                    </div>
                                </div>
                                <div class="progress mt-3" style="height: 6px;">
                                    <div class="progress-bar bg-white" role="progressbar" style="width: 90%;" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Products -->
                    <div class="col-md-4 col-lg-3 mb-4">
                        <div class="card shadow border-0 rounded-lg overflow-hidden" style="background: linear-gradient(135deg, #4a5db5 0%, #4a326b 100%);">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h5 class="text-white mb-2">{{ __("organizations.products") }}</h5>
                                        <h2 class="text-white mb-0">{{ $data['products'] ?? 0 }}</h2>
                                    </div>
                                    <div class="ml-auto">
                                        <i class="fe fe-package fe-3x text-white-50"></i>
                                    </div>
                                </div>
                                <div class="progress mt-3" style="height: 6px;">
                                    <div class="progress-bar bg-white" role="progressbar" style="width: 70%;" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Brands -->
                    <div class="col-md-4 col-lg-3 mb-4">
                        <div class="card shadow border-0 rounded-lg overflow-hidden" style="background: linear-gradient(135deg, #cc6569 0%, #d99bc3 100%);">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h5 class="text-white mb-2">{{ __("organizations.brand") }}</h5>
                                        <h2 class="text-white mb-0">{{ $data['brands'] ?? 0 }}</h2>
                                    </div>
                                    <div class="ml-auto">
                                        <i class="fe fe-tag fe-3x text-white-50"></i>
                                    </div>
                                </div>
                                <div class="progress mt-3" style="height: 6px;">
                                    <div class="progress-bar bg-white" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Categories -->
                    <div class="col-md-4 col-lg-3 mb-4">
                        <div class="card shadow border-0 rounded-lg overflow-hidden" style="background: linear-gradient(135deg, #6cc2bf 0%, #d998b2 100%);">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h5 class="text-white mb-2">{{ __("organizations.categories") }}</h5>
                                        <h2 class="text-white mb-0">{{ $data['categories'] ?? 0 }}</h2>
                                    </div>
                                    <div class="ml-auto">
                                        <i class="fe fe-grid fe-3x text-white-50"></i>
                                    </div>
                                </div>
                                <div class="progress mt-3" style="height: 6px;">
                                    <div class="progress-bar bg-white" role="progressbar" style="width: 40%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Users -->
                    <div class="col-md-4 col-lg-3 mb-4">
                        <div class="card shadow border-0 rounded-lg overflow-hidden" style="background: linear-gradient(135deg, #5cd6d4 0%, #b71fa6 100%);">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h5 class="text-white mb-2">{{__("messages.users")}}</h5>
                                        <h2 class="text-white mb-0">{{ $data['users'] ?? 0 }}</h2>
                                    </div>
                                    <div class="ml-auto">
                                        <i class="fe fe-users fe-3x text-white-50"></i>
                                    </div>
                                </div>
                                <div class="progress mt-3" style="height: 6px;">
                                    <div class="progress-bar bg-white" role="progressbar" style="width: 85%;" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Employees -->
                    <div class="col-md-4 col-lg-3 mb-4">
                        <div class="card shadow border-0 rounded-lg overflow-hidden" style="background: linear-gradient(135deg, #1e3c53 0%, #3a2f53 100%);">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h5 class="text-white mb-2">{{ __('organizations.supervisors') }}</h5>
                                        <h2 class="text-white mb-0">{{ $data['employees'] ?? 0 }}</h2>
                                    </div>
                                    <div class="ml-auto">
                                        <i class="fe fe-briefcase fe-3x text-white-50"></i>
                                    </div>
                                </div>
                                <div class="progress mt-3" style="height: 6px;">
                                    <div class="progress-bar bg-white" role="progressbar" style="width: 75%;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- end statistics section -->

                <!-- Full-Width Quick Actions Card -->
                <div class="row my-4">
                    <div class="col-12">
                        <div class="card shadow border-0 rounded-lg overflow-hidden options-card">
                            <div class="card-body">
                                <h5 class="text-white mb-4">{{ __("messages.quick_actions") }}</h5>
                                <div class="options-grid">
                                    <a href="{{ route("organization.categories.create") }}" class="btn btn-light"><i class="fe fe-plus-circle"></i>{{ __('organizations.add_category') }}</a>
                                    <a href="{{ route("organization.products.create") }}" class="btn btn-light"><i class="fe fe-package"></i>{{ __("organizations.add_product") }}</a>
                                    <a href="{{ route("organization.employees.create") }}" class="btn btn-light"><i class="fe fe-users"></i>{{ __("organizations.add_supervisor") }}</a>
                                    <a href="{{ route("organization.products.index") }}" class="btn btn-light"><i class="fe fe-bar-chart-2"></i>{{ __("organizations.products") }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- .col-12 -->
        </div> <!-- .row -->
    </div> <!-- .container-fluid -->
@endsection

@section('after_script')
    <script>
        function updateClock() {
            const currentTime = new Date();
            const hours = currentTime.getHours().toString().padStart(2, '0');
            const minutes = currentTime.getMinutes().toString().padStart(2, '0');
            const seconds = currentTime.getSeconds().toString().padStart(2, '0');

            document.getElementById('clock').textContent = `${hours}:${minutes}:${seconds}`;
        }

        // Update the clock every second
        setInterval(updateClock, 1000);
    </script>
@endsection
