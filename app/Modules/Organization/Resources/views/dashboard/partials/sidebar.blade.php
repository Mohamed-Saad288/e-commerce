<aside class="sidebar-left border-right bg-white shadow" id="leftSidebar" data-simplebar>
    <a href="#" class="btn collapseSidebar toggle-btn d-lg-none text-muted ml-2 mt-3" data-toggle="toggle">
        <i class="fe fe-x"><span class="sr-only"></span></i>
    </a>
    <nav class="vertnav navbar navbar-light">
        <!-- nav bar -->
        <div class="w-100 mb-4 d-flex">
            <a class="navbar-brand mx-auto mt-2 flex-fill text-center" href="{{ route('organization.home') }}">
                <img src="{{ $logo }}" alt="logo" width="50%">
            </a>
        </div>

        <p class="text-muted nav-heading mt-4 mb-1">
            <span>{{ __('messages.dashboard') }}</span>
        </p>

        <ul class="navbar-nav flex-fill w-100 mb-2">
            <!-- HOME -->
            <li class="nav-item w-100 ">
                <a class="nav-link {{ request()->routeIs('organization.home') ? 'active' : '' }}"
                   href="{{ route('organization.home') }}">
                    <i class="fe fe-home fe-16"></i>
                    <span class="ml-3 item-text">{{ __('messages.home') }}</span>
                </a>
            </li>
        </ul>

        <p class="text-muted nav-heading mt-4 mb-1">
            <span>{{ __('messages.users') }}</span>
        </p>

        <ul class="navbar-nav flex-fill w-100 mb-2">
            <!-- Employee (Supervisors) -->
            <li class="nav-item w-100">
                <a class="nav-link {{ request()->routeIs('organization.employees.*') ? 'active' : '' }}" href="{{ route('organization.employees.index') }}">
                    <i class="fe fe-users fe-16"></i>
                    <span class="ml-3 item-text">{{ __('organizations.supervisors') }}</span>
                </a>
            </li>
        </ul>

        <p class="text-muted nav-heading mt-4 mb-1">
            <span>{{ __('organizations.product_management') }}</span>
        </p>

        <ul class="navbar-nav flex-fill w-100 mb-2">
            <!-- Product Management Collapse -->
            <li class="nav-item w-100">
                <a class="nav-link collapsed d-flex justify-content-between align-items-center"
                   href="#productMenu" data-toggle="collapse"
                   aria-expanded="false" aria-controls="productMenu">
                    <span>
                        <i class="fe fe-shopping-cart fe-16"></i>
                        <span class="ml-3 item-text">{{ __('organizations.products_menu') }}</span>
                    </span>
                    <i class="fe fe-chevron-down rotate-icon"></i>
                </a>
                <ul class="collapse list-unstyled pl-4 w-100" id="productMenu">
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
                </ul>
            </li>
        </ul>

        <p class="text-muted nav-heading mt-4 mb-1">
            <span>{{ __('organizations.content_website') }}</span>
        </p>

        <ul class="navbar-nav flex-fill w-100 mb-2">
            <!-- Content Management Collapse -->
            <li class="nav-item w-100">
                <a class="nav-link collapsed d-flex justify-content-between align-items-center"
                   href="#contentMenu" data-toggle="collapse"
                   aria-expanded="false" aria-controls="contentMenu">
                    <span>
                        <i class="fe fe-edit-3 fe-16"></i>
                        <span class="ml-3 item-text">{{ __('organizations.content_menu') }}</span>
                    </span>
                    <i class="fe fe-chevron-down rotate-icon"></i>
                </a>
                <ul class="collapse list-unstyled pl-4 w-100" id="contentMenu">
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
                        <a class="nav-link {{ request()->routeIs('organization.abouts.*') ? 'active' : '' }}" href="{{ route('organization.abouts.index') }}">
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
                </ul>
            </li>
        </ul>
    </nav>
</aside>

{{-- CSS --}}
<style>
    .rotate-icon {
        transition: transform 0.3s ease;
    }
    .nav-link[aria-expanded="true"] .rotate-icon {
        transform: rotate(180deg);
    }
</style>

