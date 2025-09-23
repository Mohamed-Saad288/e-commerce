<aside class="sidebar-left border-right shadow" id="leftSidebar" data-simplebar>
    <a href="#" class="btn collapseSidebar toggle-btn d-lg-none text-muted ml-2 mt-3" data-toggle="collapse">
        <i class="fe fe-x"><span class="sr-only"></span></i>
    </a>
    <nav class="vertnav navbar navbar-light">
        <!-- nav bar -->
        <div class="w-100 mb-4 d-flex">
            <a class="navbar-brand mx-auto mt-2 flex-fill text-center" href="{{ route('organization.home') }}">
                <img src="{{ $logo }}" alt="logo" style="max-width: 70%; height: auto;">
            </a>
        </div>

        <p class="text-muted nav-heading mt-4 mb-2">
            <span>{{ __('messages.dashboard') }}</span>
        </p>

        <ul class="navbar-nav flex-fill w-100 mb-3">
            <!-- HOME -->
            <li class="nav-item w-100">
                <a class="nav-link {{ request()->routeIs('organization.home') ? 'active' : '' }}"
                   href="{{ route('organization.home') }}">
                    <i class="fe fe-home fe-16"></i>
                    <span class="ml-3 item-text">{{ __('messages.home') }}</span>
                </a>
            </li>
        </ul>

        <p class="text-muted nav-heading mt-4 mb-2">
            <span>{{ __('messages.users') }}</span>
        </p>

        <ul class="navbar-nav flex-fill w-100 mb-3">
            <!-- Employee (Supervisors) -->
            <li class="nav-item w-100">
                <a class="nav-link {{ request()->routeIs('organization.employees.*') ? 'active' : '' }}" href="{{ route('organization.employees.index') }}">
                    <i class="fe fe-users fe-16"></i>
                    <span class="ml-3 item-text">{{ __('organizations.supervisors') }}</span>
                </a>
            </li>
        </ul>

        <p class="text-muted nav-heading mt-4 mb-2">
            <span>{{ __('organizations.product_management') }}</span>
        </p>

        <ul class="navbar-nav flex-fill w-100 mb-3">
            <!-- Product Management Collapse -->
            <li class="nav-item w-100">
                <a class="nav-link d-flex justify-content-between align-items-center"
                   href="#productMenu" data-toggle="collapse"
                   aria-expanded="{{ request()->routeIs('organization.categories.*') || request()->routeIs('organization.brands.*') || request()->routeIs('organization.options.*') || request()->routeIs('organization.option_items.*') || request()->routeIs('organization.products.*') ? 'true' : 'false' }}"
                   aria-controls="productMenu">
                    <span>
                        <i class="fe fe-shopping-cart fe-16"></i>
                        <span class="ml-3 item-text">{{ __('organizations.products_menu') }}</span>
                    </span>
                    <i class="fe fe-chevron-down rotate-icon"></i>
                </a>
                <ul class="collapse list-unstyled pl-4 w-100 {{ request()->routeIs('organization.categories.*') || request()->routeIs('organization.brands.*') || request()->routeIs('organization.options.*') || request()->routeIs('organization.option_items.*') || request()->routeIs('organization.products.*') ? 'show' : '' }}" id="productMenu">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('organization.categories.*') ? 'active' : '' }}" href="{{ route('organization.categories.index') }}">
                            <i class="fe fe-shopping-bag fe-16"></i>
                            <span class="ml-3 item-text">{{ __('organizations.categories') }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('organization.brands.*') ? 'active' : '' }}" href="{{ route('organization.brands.index') }}">
                            <i class="fe fe-tag fe-16"></i>
                            <span class="ml-3 item-text">{{ __('organizations.brands') }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('organization.options.*') ? 'active' : '' }}" href="{{ route('organization.options.index') }}">
                            <i class="fe fe-sliders fe-16"></i>
                            <span class="ml-3 item-text">{{ __('organizations.options') }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('organization.option_items.*') ? 'active' : '' }}" href="{{ route('organization.option_items.index') }}">
                            <i class="fe fe-list fe-16"></i>
                            <span class="ml-3 item-text">{{ __('organizations.option_items') }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('organization.products.*') ? 'active' : '' }}" href="{{ route('organization.products.index') }}">
                            <i class="fe fe-box fe-16"></i>
                            <span class="ml-3 item-text">{{ __('organizations.products') }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('organization.payment_settings.*') ? 'active' : '' }}" href="{{ route('organization.payment.settings.index') }}">
                            <i class="fe fe-box fe-16"></i>
                            <span class="ml-3 item-text">{{ __('organizations.payment') }}</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>

        <p class="text-muted nav-heading mt-4 mb-2">
            <span>{{ __('organizations.content_website') }}</span>
        </p>

        <ul class="navbar-nav flex-fill w-100 mb-3">
            <!-- Content Management Collapse -->
            <li class="nav-item w-100">
                <a class="nav-link d-flex justify-content-between align-items-center"
                   href="#contentMenu" data-toggle="collapse"
                   aria-expanded="{{ request()->routeIs('organization.headers.*') || request()->routeIs('organization.questions.*') || request()->routeIs('organization.terms.*') || request()->routeIs('organization.abouts.*') || request()->routeIs('organization.whys.*') ? 'true' : 'false' }}"
                   aria-controls="contentMenu">
                    <span>
                        <i class="fe fe-edit-3 fe-16"></i>
                        <span class="ml-3 item-text">{{ __('organizations.content_menu') }}</span>
                    </span>
                    <i class="fe fe-chevron-down rotate-icon"></i>
                </a>
                <ul class="collapse list-unstyled pl-4 w-100 {{ request()->routeIs('organization.headers.*') || request()->routeIs('organization.questions.*') || request()->routeIs('organization.terms.*') || request()->routeIs('organization.abouts.*') || request()->routeIs('organization.whys.*') ? 'show' : '' }}" id="contentMenu">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('organization.headers.*') ? 'active' : '' }}" href="{{ route('organization.headers.index') }}">
                            <i class="fe fe-layout fe-16"></i>
                            <span class="ml-3 item-text">{{ __('organizations.headers') }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('organization.questions.*') ? 'active' : '' }}" href="{{ route('organization.questions.index') }}">
                            <i class="fe fe-help-circle fe-16"></i>
                            <span class="ml-3 item-text">{{ __('organizations.questions') }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('organization.terms.*') ? 'active' : '' }}" href="{{ route('organization.terms.index') }}">
                            <i class="fe fe-file-text fe-16"></i>
                            <span class="ml-3 item-text">{{ __('organizations.terms') }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('organization.abouts.*') ? 'active' : '' }}" href="{{ route('organization.abouts.create') }}">
                            <i class="fe fe-info fe-16"></i>
                            <span class="ml-3 item-text">{{ __('organizations.abouts') }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('organization.whys.*') ? 'active' : '' }}" href="{{ route('organization.whys.index') }}">
                            <i class="fe fe-star fe-16"></i>
                            <span class="ml-3 item-text">{{ __('organizations.whys') }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('organization.our_teams.*') ? 'active' : '' }}" href="{{ route('organization.our_teams.index') }}">
                            <i class="fe fe-user-check fe-16"></i>
                            <span class="ml-3 item-text">{{ __('organizations.our_teams') }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('organization.organization_settings.edit.*') ? 'active' : '' }}" href="{{ route('organization.organization_settings.edit') }}">
                            <i class="fe fe-settings fe-16"></i>
                            <span class="ml-3 item-text">{{ __('organizations.organization_settings') }}</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
</aside>

{{-- CSS --}}
<style>
    .sidebar-left {
        background: linear-gradient(180deg, #1f4037 0%, #2a5b4e 100%);
        color: #fff;
        min-width: 250px;
        max-width: 280px;
        transition: all 0.3s ease;
    }
    .sidebar-left .navbar-brand img {
        transition: transform 0.3s ease;
    }
    .sidebar-left .navbar-brand img:hover {
        transform: scale(1.05);
    }
    .nav-heading {
        font-size: 0.9rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #99f2c8;
        margin-left: 1rem;
    }
    .nav-link {
        color: #e0e0e0 !important;
        font-weight: 500;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        margin: 0.25rem 0.75rem;
        transition: all 0.3s ease;
    }
    .nav-link:hover {
        background: rgba(255, 255, 255, 0.1);
        color: #fff !important;
        transform: translateX(5px);
    }
    .nav-link.active {
        background: linear-gradient(90deg, #99f2c8 0%, #1f4037 100%);
        color: #fff !important;
        box-shadow: 0 4px 10px rgba(0, 0,omatosis: 0.3s ease;
    }
    .rotate-icon {
        transition: transform 0.3s ease;
    }
    .nav-link[aria-expanded="true"] .rotate-icon {
        transform: rotate(180deg);
    }
    .collapse {
        transition: height 0.3s ease;
    }
    .collapse .nav-link {
        font-size: 0.95rem;
        color: #d0d0d0 !important;
        padding: 0.5rem 1.5rem 0.5rem 2.5rem;
    }
    .collapse .nav-link:hover {
        background: rgba(255, 255, 255, 0.05);
        color: #fff !important;
    }
    .collapse .nav-link.active {
        background: rgba(153, 242, 200, 0.2);
        color: #fff !important;
    }
    .toggle-btn {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        padding: 0.5rem;
    }
    .toggle-btn:hover {
        background: rgba(255, 255, 255, 0.2);
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Prevent event propagation for collapse menu links
        document.querySelectorAll('#productMenu .nav-link, #contentMenu .nav-link').forEach(function (link) {
            link.addEventListener('click', function (e) {
                e.stopPropagation();
            });
        });

        // Ensure collapse functionality is initialized
        const collapseElements = document.querySelectorAll('.collapse');
        collapseElements.forEach(function (element) {
            new bootstrap.Collapse(element, {
                toggle: false
            });
        });

        // Handle sidebar toggle for mobile
        document.querySelector('.collapseSidebar').addEventListener('click', function (e) {
            e.preventDefault();
            const sidebar = document.getElementById('leftSidebar');
            sidebar.classList.toggle('d-none');
        });
    });
</script>
