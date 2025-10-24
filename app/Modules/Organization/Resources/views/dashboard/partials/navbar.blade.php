    <nav class="topnav navbar navbar-light bg-white shadow-sm">
        <!-- زر فتح/إغلاق الشريط الجانبي -->
        <button type="button" class="navbar-toggler text-muted mt-2 p-2 collapseSidebar" aria-label="Toggle Sidebar">
            <i class="fe fe-menu navbar-toggler-icon" style="font-size: 1.5rem;"></i>
        </button>

        <!-- قائمة العناصر -->
        <ul class="nav ms-auto align-items-center">
            <!-- أيقونة ملء الشاشة -->
            <li class="nav-item me-2">
                <button type="button" class="btn btn-link text-muted p-2 fullscreen-toggle" aria-label="Toggle Fullscreen" title="{{ __('messages.fullscreen') }}">
                    <i class="fe fe-maximize" style="font-size: 1.3rem;"></i>
                </button>
            </li>

            <!-- اختيار اللغة بأعلام مصر وأمريكا -->
            @php
                $locale = LaravelLocalization::getCurrentLocale() == 'ar' ? 'en' : 'ar';
                $currentLocale = LaravelLocalization::getCurrentLocale();
            @endphp
            <li class="nav-item me-2">
                <a class="nav-link p-2 lang-switcher"
                   href="{{ LaravelLocalization::getLocalizedURL($locale) }}"
                   id="langSwitcher"
                   title="{{ $locale == 'ar' ? 'العربية' : 'English' }}">
                    @if($currentLocale == 'ar')
                        <img src="https://flagcdn.com/w40/eg.png"
                             alt="العربية"
                             style="width: 28px; height: 20px; border-radius: 4px; border: 1px solid #e9ecef;">
                    @else
                        <img src="https://flagcdn.com/w40/us.png"
                             alt="English"
                             style="width: 28px; height: 20px; border-radius: 4px; border: 1px solid #e9ecef;">
                    @endif
                </a>
            </li>

            <!-- قائمة المستخدم المنسدلة -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-muted d-flex align-items-center py-2"
                   href="#"
                   id="navbarDropdownMenuLink"
                   role="button"
                   data-bs-toggle="dropdown"
                   aria-expanded="false">
                    <span class="avatar avatar-sm me-2">
                        <img src="{{ asset('/img/logo4.png') }}"
                             alt="{{ auth()->user()->name ?? 'User' }}"
                             class="avatar-img rounded-circle"
                             style="width: 32px; height: 32px; object-fit: cover;">
                    </span>
                    <span class="d-none d-md-inline-block">{{ auth()->user()->name ?? 'User' }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow-sm border-0" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="{{ route('organization.profile') }}">
                        <i class="fe fe-user me-2"></i> {{ __('messages.profile') }}
                    </a>
                    <form method="POST" action="{{ route('organization.logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger">
                            <i class="fe fe-log-out me-2"></i> {{ __('messages.logout') }}
                        </button>
                    </form>
                </div>
            </li>
        </ul>

        <!-- أنماط CSS مخصصة -->
        <style>
            /* تحسين مظهر شريط التنقل */
            .topnav.navbar {
                padding: 0.5rem 1rem;
                transition: all 0.3s ease;
            }

            /* تحسين زر فتح/إغلاق الشريط الجانبي */
            .navbar-toggler {
                border: none;
                transition: transform 0.2s ease, background-color 0.2s ease;
                border-radius: 0.5rem;
            }
            .navbar-toggler:hover {
                background-color: #f8f9fa;
                transform: scale(1.1);
            }

            /* تحسين زر ملء الشاشة */
            .fullscreen-toggle {
                border: none;
                background: transparent;
                transition: transform 0.2s ease, color 0.2s ease;
                border-radius: 0.5rem;
                text-decoration: none;
            }
            .fullscreen-toggle:hover {
                background-color: #f8f9fa;
                transform: scale(1.1);
                color: #0d6efd !important;
            }
            .fullscreen-toggle:focus {
                box-shadow: none;
            }

            /* تحسين زر تبديل اللغة */
            .lang-switcher {
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 0.5rem;
                border-radius: 0.5rem;
                transition: all 0.2s ease;
                text-decoration: none;
            }
            .lang-switcher:hover {
                background-color: #f8f9fa;
                transform: scale(1.05);
            }
            .lang-switcher img {
                transition: all 0.2s ease;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            }
            .lang-switcher:hover img {
                box-shadow: 0 4px 8px rgba(0,0,0,0.15);
                border-color: #0d6efd !important;
            }

            /* تحسين صورة المستخدم */
            .avatar-img {
                border: 2px solid #e9ecef;
                transition: border-color 0.2s ease;
            }
            .nav-link:hover .avatar-img {
                border-color: #0d6efd;
            }

            /* تحسين القائمة المنسدلة */
            .dropdown-menu {
                min-width: 12rem;
                border-radius: 0.5rem;
                padding: 0.5rem 0;
                animation: dropdownFadeIn 0.3s ease;
            }
            .dropdown-item {
                padding: 0.5rem 1.5rem;
                font-size: 0.95rem;
                transition: background-color 0.2s ease, color 0.2s ease;
            }
            .dropdown-item:hover {
                background-color: #f8f9fa;
                color: #0d6efd;
            }
            .dropdown-item.text-danger:hover {
                background-color: #fce8e6;
                color: #dc3545;
            }

            /* تأثير الفتح للقائمة المنسدلة */
            @keyframes dropdownFadeIn {
                from {
                    opacity: 0;
                    transform: translateY(-10px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            /* تحسين الاستجابة */
            @media (max-width: 767.98px) {
                .topnav.navbar {
                    padding: 0.5rem;
                }
                .navbar-toggler {
                    margin-right: 0.5rem;
                }
                .nav {
                    flex-direction: row;
                    gap: 0.5rem;
                }
                .dropdown-menu {
                    min-width: 10rem;
                }
                .lang-switcher img {
                    width: 24px !important;
                    height: 17px !important;
                }
            }
        </style>



    </nav>
