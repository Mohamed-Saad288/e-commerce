<aside class="sidebar-left border-right bg-white shadow" id="leftSidebar" data-simplebar>
    <a href="#" class="btn collapseSidebar toggle-btn d-lg-none text-muted ml-2 mt-3" data-toggle="toggle">
        <i class="fe fe-x"><span class="sr-only"></span></i>
    </a>
    <nav class="vertnav navbar navbar-light">
        <!-- nav bar -->
        <div class="w-100 mb-4 d-flex">
{{--            <a class="navbar-brand mx-auto mt-2 flex-fill text-center" href={{ route('admin.index') }}>--}}
            <a class="navbar-brand mx-auto mt-2 flex-fill text-center" href="#">
                <img src="{{ $logo }}" alt="logo" width="50%">
            </a>
        </div>

        <p class="text-muted nav-heading mt-4 mb-1">
            <span>{{ __('messages.dashboard') }}</span>
        </p>

        <ul class="navbar-nav flex-fill w-100 mb-2">
            <!-- HOME -->
            <li class="nav-item w-100">
{{--                <a class="nav-link" href="{{ route('admin.index') }}">--}}
                <a class="nav-link" href="#">
                    <i class="fe fe-home fe-16"></i>
                    <span class="ml-3 item-text">{{ __('messages.home') }}</span>
                </a>
            </li>
        </ul>

        <p class="text-muted nav-heading mt-4 mb-1">
            <span>{{ __('messages.users') }}</span>
        </p>

        <ul class="navbar-nav flex-fill w-100 mb-2">
{{--            @can('show_employees')--}}
                <!-- Employee -->


{{--            admin      --}}
            <li class="nav-item w-100">
                <a class="nav-link" href="{{ route('admin.admins.index') }}">
                    <i class="fe fe-users fe-16"></i>
                    <span class="ml-3 item-text">{{ __('messages.admins') }}</span>
                </a>
            </li>

            {{--            organization      --}}
            <li class="nav-item w-100">
                <a class="nav-link" href="{{ route('admin.organizations.index') }}">
                    <i class="fe fe-briefcase fe-16"></i>
                    <span class="ml-3 item-text">{{ __('messages.organizations') }}</span>
                </a>
            </li>

{{--            features     --}}
                <li class="nav-item w-100">
                    <a class="nav-link" href="{{ route('admin.features.index') }}">
                        <i class="fe fe-star fe-16"></i>
                        <span class="ml-3 item-text">{{ __('messages.features') }}</span>
                    </a>
                </li>

            <li class="nav-item w-100">
                    <a class="nav-link" href="{{ route('admin.plans.index') }}">
                        <i class="fe fe-star fe-16"></i>
                        <span class="ml-3 item-text">{{ __('messages.plans') }}</span>
                    </a>
                </li>



{{--            @endcan--}}
{{--            <!-- users -->--}}
{{--            <li class="nav-item w-100">--}}
{{--                <a class="nav-link" href="{{ route('admin.users.index') }}">--}}
{{--                    <i class="fe fe-user-plus fe-16"></i>--}}
{{--                    <span class="ml-3 item-text">{{ __('keys.users') }}</span>--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            @can('show_roles')--}}
{{--                <!-- ROLES -->--}}
{{--                <li class="nav-item w-100">--}}
{{--                    <a class="nav-link" href="{{ route('admin.roles.index') }}">--}}
{{--                         <i class="fe fe-shield fe-16"></i> --}}
{{--                        <i class="fe fe-lock fe-16"></i>--}}
{{--                        <span class="ml-3 item-text">{{ __('keys.roles') }}</span>--}}
{{--                    </a>--}}
{{--                </li>--}}
{{--            @endcan--}}

{{--            @can('show_jobs')--}}
{{--                <!-- JOBS -->--}}
{{--                <li class="nav-item w-100">--}}
{{--                    <a class="nav-link" href="{{ route('admin.jobs.index') }}">--}}
{{--                        <i class="fe fe-user-plus fe-16"></i>--}}
{{--                        <span class="ml-3 item-text">{{ __('jobs.Job_Hierarchy') }}</span>--}}
{{--                    </a>--}}
{{--                </li>--}}
{{--            @endcan--}}
        </ul>

{{--            <p class="text-muted nav-heading mt-4 mb-1">--}}
{{--                <span>{{ __('keys.Content_Management') }}</span>--}}
{{--            </p>--}}

{{--            <ul class="navbar-nav flex-fill w-100 mb-2">--}}

{{--                @can('show_heroSection')--}}
{{--                    <!-- Hero Section -->--}}
{{--                    <li class="nav-item w-100">--}}
{{--                        <a class="nav-link" href="{{ route('admin.hero_sections.edit', getFirstHeroSectionId()) }}">--}}
{{--                            <i class="fe fe-layout fe-16"></i>--}}
{{--                            <span class="ml-3 item-text">{{ __('heroSection.heroSections') }}</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                @endcan--}}
{{--                @can('show_services')--}}
{{--                    <!-- SERVICES -->--}}
{{--                    <li class="nav-item w-100">--}}
{{--                        <a class="nav-link collapsed" href="#serviceMenu" data-toggle="collapse" aria-expanded="false">--}}
{{--                            <i class="fe fe-briefcase fe-16"></i>--}}
{{--                            <span class="ml-3 item-text">{{ __('service.services') }}</span>--}}
{{--                        </a>--}}
{{--                        <ul class="collapse list-unstyled pl-4 w-100" id="serviceMenu">--}}
{{--                            <li class="nav-item">--}}
{{--                                <a class="nav-link" href="{{ route('admin.services.index') }}">--}}
{{--                                    <i class="fe fe-menu"></i>--}}
{{--                                    <span class="ml-3 item-text">{{ __('service.parentServices') }}</span>--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                            <li class="nav-item">--}}
{{--                                <a class="nav-link" href="{{ route('admin.services.getChildService') }}">--}}
{{--                                    <i class="fe fe-menu"></i>--}}
{{--                                    <span class="ml-3 item-text">{{ __('service.childServices') }}</span>--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                        </ul>--}}
{{--                    </li>--}}
{{--                @endcan--}}

{{--                --}}{{----}}{{--                @can('show_categories')--}}
{{--                --}}{{----}}{{--                    <!-- CATEGORIES -->--}}
{{--                --}}{{----}}{{--                    <li class="nav-item w-100">--}}
{{--                --}}{{----}}{{--                        <a class="nav-link" href="{{ route('admin.categories.index') }}">--}}
{{--                --}}{{----}}{{--                            <i class="fe fe-grid fe-16"></i>--}}
{{--                --}}{{----}}{{--                            <span class="ml-3 item-text">{{ __('keys.categories') }}</span>--}}
{{--                --}}{{----}}{{--                        </a>--}}
{{--                --}}{{----}}{{--                    </li>--}}
{{--                --}}{{----}}{{--                @endcan--}}

{{--                @can('show_abouts')--}}

{{--                    <!-- ABOUTS -->--}}
{{--                    <li class="nav-item w-100">--}}
{{--                        <a class="nav-link collapsed" href="#aboutMenu" data-toggle="collapse" aria-expanded="false">--}}
{{--                            <i class="fe fe-info fe-16"></i>--}}
{{--                            <span class="ml-3 item-text">{{ __('about.about_Pages') }}</span>--}}
{{--                        </a>--}}
{{--                        <ul class="collapse list-unstyled pl-4 w-100" id="aboutMenu">--}}
{{--                            @foreach ($aboutTypes as $type)--}}
{{--                                <li class="nav-item">--}}
{{--                                    <a class="nav-link" href="{{ route('admin.abouts.fetch_abouts', $type->value) }}">--}}
{{--                                        <i class="fe fe-menu"></i>--}}
{{--                                        <span class="ml-3 item-text">{{ __('about.' . $type->value) }}</span>--}}
{{--                                    </a>--}}
{{--                                </li>--}}
{{--                            @endforeach--}}
{{--                        </ul>--}}
{{--                    </li>--}}
{{--                @endcan--}}

{{--                @can('show_staticPages')--}}
{{--                    <!-- Static Pages -->--}}
{{--                    <li class="nav-item w-100">--}}
{{--                        <a class="nav-link" href="{{ route('admin.static_pages.index') }}">--}}
{{--                            <i class="fe fe-file-text fe-16"></i>--}}
{{--                            <span class="ml-3 item-text">{{ __('staticPage.staticPages') }}</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                @endcan--}}

{{--                @can('show_contacts')--}}
{{--                    <!-- CONTACTS -->--}}
{{--                    <li class="nav-item w-100">--}}
{{--                        <a class="nav-link" href="{{ route('admin.contacts.index') }}">--}}
{{--                            <i class="fe fe-phone fe-16"></i>--}}
{{--                            <span class="ml-3 item-text">{{ __('contact.contacts') }}</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                @endcan--}}

{{--                --}}{{----}}{{--                @can('show_partners')--}}
{{--                --}}{{----}}{{--                    <!-- PARTNERS -->--}}
{{--                --}}{{----}}{{--                    <li class="nav-item w-100">--}}
{{--                --}}{{----}}{{--                        <a class="nav-link" href="{{ route('admin.partners.index') }}">--}}
{{--                --}}{{----}}{{--                            <i class="fe fe-user-check  fe-16"></i>--}}
{{--                --}}{{----}}{{--                            <span class="ml-3 item-text">{{ __('partner.partners') }}</span>--}}
{{--                --}}{{----}}{{--                        </a>--}}
{{--                --}}{{----}}{{--                    </li>--}}
{{--                --}}{{----}}{{--                @endcan--}}
{{--                --}}{{----}}{{--                @can('show_testimonials')--}}
{{--                --}}{{----}}{{--                    <!-- TESTIMONIALS -->--}}
{{--                --}}{{----}}{{--                    <li class="nav-item w-100">--}}
{{--                --}}{{----}}{{--                        <a class="nav-link" href="{{ route('admin.testimonials.index') }}">--}}
{{--                --}}{{----}}{{--                            <i class="fe fe-star fe-16"></i>--}}
{{--                --}}{{----}}{{--                            <span class="ml-3 item-text">{{ __('keys.testimonials') }}</span>--}}
{{--                --}}{{----}}{{--                        </a>--}}
{{--                --}}{{----}}{{--                    </li>--}}
{{--                --}}{{----}}{{--                @endcan--}}

{{--                @can('show_blogs')--}}
{{--                    <!-- BLOGS -->--}}
{{--                    <li class="nav-item w-100">--}}
{{--                        <a class="nav-link" href="{{ route('admin.blogs.index') }}">--}}
{{--                            <i class="fe fe-edit fe-16"></i>--}}
{{--                            <span class="ml-3 item-text">{{ __('blogs.blog') }}</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                @endcan--}}
{{--                --}}{{----}}{{--                @can('show_pages')--}}
{{--                --}}{{----}}{{--                    <!-- Pages -->--}}
{{--                --}}{{----}}{{--                    <li class="nav-item w-100">--}}
{{--                --}}{{----}}{{--                        <a class="nav-link" href="{{ route('admin.pages.index') }}">--}}
{{--                --}}{{----}}{{--                            <i class="fe fe-file fe-16"></i>--}}
{{--                --}}{{----}}{{--                            <span class="ml-3 item-text">{{ __('Page.pages') }}</span>--}}
{{--                --}}{{----}}{{--                        </a>--}}
{{--                --}}{{----}}{{--                    </li>--}}
{{--                --}}{{----}}{{--                @endcan--}}
{{--                --}}{{----}}{{--                @can('show_offers')--}}
{{--                --}}{{----}}{{--                    <!-- OFFERS -->--}}
{{--                --}}{{----}}{{--                    <li class="nav-item w-100">--}}
{{--                --}}{{----}}{{--                        <a class="nav-link" href="{{ route('admin.offers.index') }}">--}}
{{--                --}}{{----}}{{--                            <i class="fe fe-tag fe-16"></i>--}}
{{--                --}}{{----}}{{--                            <span class="ml-3 item-text">{{ __('offers.Offers') }}</span>--}}
{{--                --}}{{----}}{{--                        </a>--}}
{{--                --}}{{----}}{{--                    </li>--}}
{{--                --}}{{----}}{{--                @endcan--}}

{{--                --}}{{----}}{{--                @can('show_fags')--}}
{{--                --}}{{----}}{{--                    <!-- FAQS -->--}}
{{--                --}}{{----}}{{--                    <li class="nav-item w-100">--}}
{{--                --}}{{----}}{{--                        <a class="nav-link" href="{{ route('admin.faqs.index') }}">--}}
{{--                --}}{{----}}{{--                            <i class="fe fe-help-circle fe-16"></i>--}}
{{--                --}}{{----}}{{--                            <span class="ml-3 item-text">{{ __('keys.faqs') }}</span>--}}
{{--                --}}{{----}}{{--                        </a>--}}
{{--                --}}{{----}}{{--                    </li>--}}
{{--                --}}{{----}}{{--                @endcan--}}

{{--                --}}{{----}}{{--                @can('show_galleries')--}}
{{--                --}}{{----}}{{--                    <!-- Gallery -->--}}
{{--                --}}{{----}}{{--                    <li class="nav-item w-100">--}}
{{--                --}}{{----}}{{--                        <a class="nav-link" href="{{ route('admin.galleries.index') }}">--}}
{{--                --}}{{----}}{{--                            <i class="fe fe-image fe-16"></i>--}}
{{--                --}}{{----}}{{--                            <span class="ml-3 item-text">{{ __('keys.galleries') }}</span>--}}
{{--                --}}{{----}}{{--                        </a>--}}
{{--                --}}{{----}}{{--                    </li>--}}
{{--                --}}{{----}}{{--                @endcan--}}
{{--                --}}{{----}}{{--                @can('show_works')--}}
{{--                --}}{{----}}{{--                    <!-- WORKS -->--}}
{{--                --}}{{----}}{{--                    <li class="nav-item w-100">--}}
{{--                --}}{{----}}{{--                        <a class="nav-link" href="{{ route('admin.works.index') }}">--}}
{{--                --}}{{----}}{{--                            <i class="fe fe-layers fe-16"></i>--}}
{{--                --}}{{----}}{{--                            --}}{{----}}{{----}}{{----}}{{-- <i class="fe fe-tool fe-16"></i> --}}
{{--                --}}{{----}}{{--                            <span class="ml-3 item-text">{{ __('work.works') }}</span>--}}
{{--                --}}{{----}}{{--                        </a>--}}
{{--                --}}{{----}}{{--                    </li>--}}
{{--                --}}{{----}}{{--                @endcan--}}

{{--            </ul>--}}

{{--            <p class="text-muted nav-heading mt-4 mb-1">--}}
{{--                <span>{{ __('keys.General_Settings') }}</span>--}}
{{--            </p>--}}

{{--            <ul class="navbar-nav flex-fill w-100 mb-2">--}}
{{--                @can('show_settings')--}}
{{--                    <!-- settings -->--}}
{{--                    <li class="nav-item w-100">--}}
{{--                        <a class="nav-link" href="{{ route('admin.settings.edit', getFirstSettingId()) }}">--}}
{{--                            <i class="fe fe-settings fe-16"></i>--}}
{{--                            <span class="ml-3 item-text">{{ __('setting.settings') }}</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                @endcan--}}
{{--                @can('show_newsLetters')--}}
{{--                    <li class="nav-item w-100">--}}
{{--                        <a class="nav-link" href="{{ route('admin.fetch_news_letters') }}">--}}
{{--                            <i class="fe fe-send fe-16"></i>--}}
{{--                            <span class="ml-3 item-text">{{ __('keys.newsLetters') }}</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                @endcan--}}
{{--                --}}{{----}}{{--                @can('show_seo')--}}
{{--                --}}{{----}}{{--                    <!-- Seo -->--}}
{{--                --}}{{----}}{{--                    <li class="nav-item w-100">--}}
{{--                --}}{{----}}{{--                        <a class="nav-link" href="{{ route('admin.seo.index') }}">--}}
{{--                --}}{{----}}{{--                            <i class="fe fe-trending-up fe-16"></i>--}}
{{--                --}}{{----}}{{--                            <span class="ml-3 item-text">{{ __('seo.seos') }}</span>--}}
{{--                --}}{{----}}{{--                        </a>--}}
{{--                --}}{{----}}{{--                    </li>--}}
{{--                --}}{{----}}{{--                @endcan--}}
{{--                --}}{{----}}{{--            @can('show_countries') --}}
{{--                --}}{{----}}{{--                <!-- ACTIVITY LOG -->--}}
{{--                --}}{{----}}{{--                <li class="nav-item w-100">--}}
{{--                --}}{{----}}{{--                    <a class="nav-link" href="{{ route('admin.fetch_activity') }}">--}}
{{--                --}}{{----}}{{--                        <i class="fe fe-database fe-16"></i>--}}
{{--                --}}{{----}}{{--                        <span class="ml-3 item-text">{{ __('activity.activity_log') }}</span>--}}
{{--                --}}{{----}}{{--                    </a>--}}
{{--                --}}{{----}}{{--                </li>--}}
{{--                --}}{{----}}{{--            @endcan --}}
{{--                --}}{{----}}{{--                @can('show_countries')--}}
{{--                --}}{{----}}{{--                    <!-- COUNTRIES -->--}}
{{--                --}}{{----}}{{--                    <li class="nav-item w-100">--}}
{{--                --}}{{----}}{{--                        <a class="nav-link" href="{{ route('admin.countries.index') }}">--}}
{{--                --}}{{----}}{{--                            <i class="fe fe-map fe-16"></i>--}}
{{--                --}}{{----}}{{--                            <span class="ml-3 item-text">{{ __('keys.countries') }}</span>--}}
{{--                --}}{{----}}{{--                        </a>--}}
{{--                --}}{{----}}{{--                    </li>--}}
{{--                --}}{{----}}{{--                @endcan--}}
{{--            </ul>--}}
{{--        </ul>--}}

    </nav>
</aside>
