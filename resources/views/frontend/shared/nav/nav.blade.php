<ul>
    <li >
        <a href="{{ url('/') }}">{{ __('admin_local.Home') }}</a>

    </li>
    <li class="menu-item-has-children">
        <a href="#">{{ __('admin_local.Courses') }}</a>
        <ul class="sub-menu">
            @php
                $course_categories = \App\Models\Admin\Course\CourseCategory::where([['category_status',1],['category_delete',0]])->get();
            @endphp
            @foreach ($course_categories as $course_category)
                @php
                    $course_sub_categories = \App\Models\Admin\Course\CourseSubCategory::where([['sub_category_status',1],['sub_category_delete',0],['category_id',$course_category->id]])->get();
                @endphp

                @if ($course_sub_categories)
                    <li class="menu-item-has-children">
                        <a href="{{ route('frontend.courses.getAllCourses',['category',$course_category->category_slug]) }}">{{ $course_category->category_name }}</a>
                        <ul class="sub-menu">
                            @foreach ($course_sub_categories as $course_sub_category)
                            @php
                                $courses = \App\Models\Admin\Course\Course::where([['course_status',1],['course_delete',0],['sub_category_id',$course_sub_category->id]])->select('id','course_name','course_name_slug')->get();
                            @endphp
                            @if ($courses)
                                <li class="menu-item-has-children">
                                    <a href="{{ route('frontend.courses.getAllCourses',['sub-category',$course_sub_category->sub_category_slug]) }}">{{ $course_sub_category->sub_category_name }}</a>
                                    <ul class="sub-menu">
                                        @foreach ($courses as $course)
                                        <li><a href="{{ route('frontend.courses.single',$course->course_name_slug) }}">{{ $course->course_name }}</a></li>
                                        @endforeach
                                    </ul>
                                </li>
                            @else
                                <li><a href="shop.html">{{ $course_sub_category->sub_category_name }}</a></li>
                            @endif

                            @endforeach
                        </ul>
                    </li>
                @else
                    <li><a href="{{ route('frontend.courses.getAllCourses',['category',$course_category->category_slug]) }}">{{ $course_category->category_name }}</a></li>
                @endif
            @endforeach

        </ul>
    </li>
    <li class="menu-item-has-children">
        <a href="#">{{ __('admin_local.About Us') }}</a>
        <ul class="sub-menu">
            {{-- <li><a href="team.html">{{ __('admin_local.Blogs') }}</a></li> --}}
            <li><a href="{{ url('all-instructor') }}">{{ __('admin_local.Instructors') }}</a></li>
            <li><a href="{{ url('about-us') }}">{{ __('admin_local.About BipeBD') }}</a></li>
        </ul>
    </li>
    <li>
        <a href="{{ url('contact-us') }}">{{ __('admin_local.Contact Us') }}</a>
    </li>
    <li @if (Auth::check()) class="menu-item-has-children"@endif id="mobile_li_hide">
        @if (Auth::check())
        <a href="#">{{ __('admin_local.My Profile') }}</a>
        <ul class="sub-menu">
            <li><a href="{{ url('my-profile') }}">{{ __('admin_local.View My Profile') }}</a></li>
            <li><a href="{{ route('user.attemptLogout') }}">{{ __('admin_local.Logout') }}</a></li>
        </ul>
        @else
        <a href="{{ route('user.login','login') }}">{{ __('admin_local.Login') }}</a> / <a href="{{ route('user.login','register') }}">{{ __('admin_local.Register') }}</a>
        @endif

    </li>
    <li class="menu-item-has-children">
        <a href="#">{{ __('admin_local.Language') }}</a>
        <ul class="sub-menu">
            {{-- <li><a href="team.html">{{ __('admin_local.Blogs') }}</a></li> --}}
            @php
                $languages =  \App\Models\Admin\Language::where([['status', 1], ['delete', 0]])
                    ->get();
            @endphp
            @foreach ($languages as $language)
            <li><a href="{{ route('front.changeLanguage',$language->lang) }}">{{  $language->name, $language->lang }}</a></li>
            @endforeach
        </ul>
    </li>
</ul>
