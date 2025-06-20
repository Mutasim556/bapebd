<ul class="sidebar-links" id="simple-bar">
    <li class="sidebar-list">
        <a class="sidebar-link sidebar-title link-nav" href="{{ route('admin.index') }}" aria-expanded="false"><i
                data-feather="home"></i><span>{{ __('admin_local.Dashboard') }}</span>
        </a>
    </li>
    @if (hasPermission(['user-index', 'user-create', 'user-update', 'user-delete','instructor-index', 'instructor-create', 'instructor-update', 'instructor-delete']))
        <li class="sidebar-list">
            <a class="sidebar-link sidebar-title" href="javascript:void(0)" aria-expanded="false">
                <i data-feather="user-plus"></i>
                <span class="lan-3">{{ __('admin_local.Users') }}</span>
            </a>
            <ul class="sidebar-submenu">
                @if (hasPermission(['user-index', 'user-create', 'user-update', 'user-delete']))
                <li>
                    <a href="{{ route('admin.user.index') }}" class="sidebar-link">
                        <span> {{ __('admin_local.User List') }} </span>
                    </a>
                </li>
                @endif
                @if (hasPermission(['instructor-index', 'instructor-create', 'instructor-update', 'instructor-delete']))
                <li>
                    <a href="{{ route('admin.instructor.index') }}" class="sidebar-link">
                        <span> {{ __('admin_local.Instructor List') }} </span>
                    </a>
                </li>
                @endif
            </ul>
        </li>
    @endif
    @if (hasPermission(['course-category-index', 'course-category-create', 'course-category-update', 'course-category-delete','course-subcategory-index', 'course-subcategory-create', 'course-subcategory-update', 'course-subcategory-delete']))
        <li class="sidebar-list">
            <a class="sidebar-link sidebar-title" id="course-sidebar-title" href="javascript:void(0)" aria-expanded="false">
                <i data-feather="user-plus"></i>
                <span class="lan-3">{{ __('admin_local.Courses') }}</span>
            </a>
            <ul class="sidebar-submenu" id="course-sidebar-submenu">
                @if (hasPermission(['course-category-index', 'course-category-create', 'course-category-update', 'course-category-delete']))
                <li>
                    <a href="{{ route('admin.course.category.index') }}" class="sidebar-link">
                        <span> {{ __('admin_local.Category') }} </span>
                    </a>
                </li>
                @endif
                @if (hasPermission(['course-subcategory-index', 'course-subcategory-create', 'course-subcategory-update', 'course-subcategory-delete']))
                <li>
                    <a href="{{ route('admin.course.subCategory.index') }}" class="sidebar-link">
                        <span> {{ __('admin_local.Sub-Category') }} </span>
                    </a>
                </li>
                @endif
                @if (hasPermission(['course-coupon-index', 'course-coupon-create', 'course-coupon-update', 'course-coupon-delete']))
                <li>
                    <a href="{{ route('admin.course.coupon.index') }}" class="sidebar-link">
                        <span> {{ __('admin_local.Coupons') }} </span>
                    </a>
                </li>
                @endif
                @if (hasPermission(['course-create']))
                <li>
                    <a href="{{ route('admin.course.create') }}" class="sidebar-link">
                        <span> {{ __('admin_local.Add Course') }} </span>
                    </a>
                </li>
                @endif
                @if (hasPermission(['course-index', 'course-update', 'course-delete']))
                <li>
                    <a href="{{ route('admin.course.index') }}" class="sidebar-link" id="course-sidebar-link">
                        <span> {{ __('admin_local.View Courses') }} </span>
                    </a>
                </li>
                @endif
            </ul>
        </li>
    @endif
     @if (hasPermission(['purchase-history-index', 'purchase-history-create', 'purchase-history-update', 'purchase-history-delete']))
        <li class="sidebar-list">
            <a class="sidebar-link sidebar-title" href="javascript:void(0)" aria-expanded="false">
                <i data-feather="unlock"></i>
                <span class="lan-3">{{ __('admin_local.Purchase History') }}</span>
            </a>
            <ul class="sidebar-submenu">
                @if (hasPermission(['purchase-history-index', 'purchase-history-create', 'purchase-history-update', 'purchase-history-delete']))
                    <li>
                        <a href="{{ route('admin.purchase-history.index') }}" class="sidebar-link">
                            <span> {{ __('admin_local.Purchase History') }} </span>
                        </a>
                    </li>
                @endif
            </ul>
        </li>
    @endif
    @if (hasPermission(['role-permission-index', 'role-permission-create', 'role-permission-update', 'role-permission-delete']))
        <li class="sidebar-list">
            <a class="sidebar-link sidebar-title" href="javascript:void(0)" aria-expanded="false">
                <i data-feather="unlock"></i>
                <span class="lan-3">{{ __('admin_local.Roles And Permissions') }}</span>
            </a>
            <ul class="sidebar-submenu">
                @if (hasPermission(['role-permission-index', 'role-permission-create', 'role-permission-update', 'role-permission-delete']))
                    <li>
                        <a href="{{ route('admin.role.index') }}" class="sidebar-link">
                            <span> {{ __('admin_local.Admin') }} </span>
                        </a>
                    </li>
                @endif
            </ul>
        </li>
    @endif
    @if (hasPermission(['language-index', 'language-create', 'language-update', 'language-delete', 'backend-string-index']))
        <li class="sidebar-list">
            <a class="sidebar-link sidebar-title" href="javascript:void(0)" aria-expanded="false">
                <i data-feather="slack"></i>
                <span class="lan-3">{{ __('admin_local.Language') }}</span>
            </a>
            <ul class="sidebar-submenu">
                @if (hasPermission(['language-index', 'language-create', 'language-update', 'language-delete']))
                    <li>
                        <a href="{{ route('admin.language.index') }}" class="sidebar-link">
                            <span> {{ __('admin_local.Language List') }} </span>
                        </a>
                    </li>
                @endif

                @if (hasPermission(['backend-string-index']))
                    <li>
                        <a href="{{ route('admin.backend.language.index') }}" class="sidebar-link">
                            <span> {{ __('admin_local.Backed Language') }} </span>
                        </a>
                    </li>
                @endif
            </ul>
        </li>
    @endif

    @if (hasPermission(['about-us-update','user-message-index']))
        <li class="sidebar-list">
            <a class="sidebar-link sidebar-title" href="javascript:void(0)" aria-expanded="false">
                <i data-feather="slack"></i>
                <span class="lan-3">{{ __('admin_local.Other Pages') }}</span>
            </a>
            <ul class="sidebar-submenu">
                @if (hasPermission(['about-us-update']))
                    <li>
                        <a href="{{ route('admin.about-us.index') }}" class="sidebar-link">
                            <span> {{ __('admin_local.About Us') }} </span>
                        </a>
                    </li>
                @endif
                @if (hasPermission(['user-message-index']))
                    <li>
                        <a href="{{ route('admin.getUserMessages') }}" class="sidebar-link">
                            <span> {{ __('admin_local.Messages') }} </span>
                        </a>
                    </li>
                @endif

            </ul>
        </li>
    @endif

    @if (hasPermission(['maintenance-mode-index','homepage-slider-index','logo-index','other-content-index','comments-index']))
        <li class="sidebar-list">
            <a class="sidebar-link sidebar-title" href="javascript:void(0)" aria-expanded="false">
                <i data-feather="settings"></i>
                <span class="lan-3">{{ __('admin_local.Settings') }}</span>
            </a>
            <ul class="sidebar-submenu">
                @if (hasPermission(['maintenance-mode-index']))
                    <li>
                        <a href="{{ route('admin.settings.server.maintenanceMode') }}" class="sidebar-link">
                            <span> {{ __('admin_local.Maintenance Mode') }} </span>
                        </a>
                    </li>
                @endif
                @if (hasPermission(['logo-index']))
                    <li>
                        <a href="{{ route('admin.logo') }}" class="sidebar-link">
                            <span> {{ __('admin_local.Logos') }} </span>
                        </a>
                    </li>
                @endif

                @if (hasPermission(['homepage-slider-index']))
                    <li>
                        <a href="{{ route('admin.settings.homepage.main_slider') }}">{{ __('admin_local.Main Slider') }}</a>
                    </li>
                @endif

                @if (hasPermission(['homepage-slider-index']))
                    <li>
                        <a href="{{ route('admin.settings.contactinfo.index') }}">{{ __('admin_local.Contact Info') }}</a>
                    </li>
                @endif
                @if (hasPermission(['other-content-index']))
                    <li>
                        <a href="{{ route('admin.settings.homepage.otherContent') }}">{{ __('admin_local.Other Contents') }}</a>
                    </li>
                @endif
                @if (hasPermission(['comments-index']))
                    <li>
                        <a href="{{ route('admin.settings.comments.index') }}">{{ __('admin_local.Comments') }}</a>
                    </li>
                @endif
            </ul>
        </li>
    @endif
</ul>
