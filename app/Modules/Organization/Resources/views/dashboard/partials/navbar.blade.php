<nav class="topnav navbar navbar-light bg-white shadow-sm">
    <!-- زر فتح/إغلاق الشريط الجانبي -->
    <button type="button" class="navbar-toggler text-muted mt-2 p-2 collapseSidebar" aria-label="Toggle Sidebar">
        <i class="fe fe-menu navbar-toggler-icon" style="font-size: 1.5rem;"></i>
    </button>

    <!-- قائمة العناصر -->
    <ul class="nav ms-auto align-items-center">
        <!-- اختيار اللغة -->
        <li class="nav-item">
            @include('admin::dashboard.partials.language')
        </li>

        <!-- قائمة المستخدم المنسدلة -->
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-muted d-flex align-items-center py-2" href="#" id="navbarDropdownMenuLink" role="button"
               data-bs-toggle="dropdown" aria-expanded="false">
                <span class="avatar avatar-sm me-2">
                    <img src="{{   asset('/img/logo4.png') }}"
                         alt="{{ auth()->user()->name ?? 'User' }}"
                         class="avatar-img rounded-circle" style="width: 32px; height: 32px; object-fit: cover;">
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
        }
    </style>

    <!-- JavaScript لتحسين التفاعلية -->
    <script>
        $(document).ready(function () {
            // إضافة تأثير عند النقر على زر فتح/إغلاق الشريط الجانبي
            $('.collapseSidebar').on('click', function () {
                $(this).toggleClass('active');
                if ($(this).hasClass('active')) {
                    $(this).css('background-color', '#e9ecef');
                } else {
                    $(this).css('background-color', 'transparent');
                }
            });

            // إضافة تأثير عند فتح/إغلاق القائمة المنسدلة
            $('.dropdown').on('show.bs.dropdown', function () {
                $(this).find('.dropdown-menu').css('opacity', '0').animate({ opacity: 1 }, 200);
            });
            $('.dropdown').on('hide.bs.dropdown', function () {
                $(this).find('.dropdown-menu').animate({ opacity: 0 }, 200);
            });
        });
    </script>
</nav>
