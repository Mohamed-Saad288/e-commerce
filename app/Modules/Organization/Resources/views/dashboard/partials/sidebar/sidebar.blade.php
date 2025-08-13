@props(['activePage' => 'dashboard'])
@php
    $dir = 'material/assets';
    $isRtl = app()->getLocale() === 'ar'; // Adjust as needed
@endphp

<aside
    class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 bg-gradient-dark"
    id="sidenav-main"
    role="navigation"
    aria-label="Main navigation menu">

    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
           aria-hidden="true" id="iconSidenav" aria-label="Close sidebar"></i>
        <a class="navbar-brand m-0 d-flex text-wrap align-items-center" href="{{ route('organization.home') }}" aria-current="page">
            <img src="{{ asset($dir) }}/img/logo-ct.png" class="navbar-brand-img h-100" alt="Creative Tim Logo">
            <span class="ms-2 font-weight-bold text-white">Material Dashboard 2</span>
        </a>
    </div>

    <hr class="horizontal light mt-0 mb-2">

    <div class="collapse navbar-collapse w-auto max-height-vh-100" id="sidenav-collapse-main">
        <ul class="navbar-nav" role="menubar">

            <!-- Laravel Examples -->
            <li class="nav-item mt-3" role="none">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8"
                    id="laravel-section">Laravel Examples</h6>
            </li>

            <li class="nav-item" role="none">
                <a class="nav-link text-white {{ $activePage === 'user-profile' ? 'active bg-gradient-primary' : '' }}"
                   href="{{ route('organization.profile') }}"
                   role="menuitem"
                   aria-current="{{ $activePage === 'user-profile' ? 'page' : 'false' }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-user-circle ps-2 pe-2" aria-hidden="true" style="font-size: 1.2rem;"></i>
                    </div>
                    <span class="nav-link-text ms-1">User Profile</span>
                </a>
            </li>

            <li class="nav-item" role="none">
                <a class="nav-link text-white {{ $activePage === 'user-management' ? 'active bg-gradient-primary' : '' }}"
                   href="{{ route('organization.user_profile') }}"
                   role="menuitem"
                   aria-current="{{ $activePage === 'user-management' ? 'page' : 'false' }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-users ps-2 pe-2" aria-hidden="true" style="font-size: 1rem;"></i>
                    </div>
                    <span class="nav-link-text ms-1">User Management</span>
                </a>
            </li>

            <!-- Pages -->
            <li class="nav-item mt-3" role="none">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8"
                    id="pages-section">Pages</h6>
            </li>

            <li class="nav-item" role="none">
                <a class="nav-link text-white {{ $activePage === 'dashboard' ? 'active bg-gradient-primary' : '' }}"
                   href="{{ route('organization.home') }}"
                   role="menuitem"
                   aria-current="{{ $activePage === 'dashboard' ? 'page' : 'false' }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">dashboard</i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>

            <li class="nav-item" role="none">
                <a class="nav-link text-white {{ $activePage === 'billing' ? 'active bg-gradient-primary' : '' }}"
                   href="#"
                   role="menuitem"
                   aria-current="{{ $activePage === 'billing' ? 'page' : 'false' }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">receipt_long</i>
                    </div>
                    <span class="nav-link-text ms-1">Billing</span>
                </a>
            </li>

            <!-- Account -->
            <li class="nav-item mt-3" role="none">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8"
                    id="account-section">Account</h6>
            </li>

            <li class="nav-item" role="none">
                <a class="nav-link text-white {{ $activePage === 'profile' ? 'active bg-gradient-primary' : '' }}"
                   href="{{ route('organization.profile') }}"
                   role="menuitem"
                   aria-current="{{ $activePage === 'profile' ? 'page' : 'false' }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">person</i>
                    </div>
                    <span class="nav-link-text ms-1">My Profile</span>
                </a>
            </li>

        </ul>
    </div>
</aside>
