<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ __('admin_local.BipeBD') }} - @stack('title')</title>
    <meta name="author" content="themeholy">
    <meta name="description" content="Edura - Online Courses & Education HTML Template">
    <meta name="keywords" content="Edura - Online Courses & Education HTML Template">
    <meta name="robots" content="INDEX,FOLLOW">

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicons - Place favicon.ico in the root directory -->
    <link rel="apple-touch-icon" sizes="57x57" href="assets/img/favicons/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="assets/img/favicons/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="assets/img/favicons/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/favicons/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="assets/img/favicons/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="assets/img/favicons/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="assets/img/favicons/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="assets/img/favicons/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/favicons/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('public/bipebd/assets/img/logou.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('public/bipebd/assets/img/logou.png')}}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('public/bipebd/assets/img/logou.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('public/bipebd/assets/img/logou.png')}}">
    {{-- <link rel="manifest" href="assets/img/favicons/manifest.json"> --}}
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="assets/img/favicons/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <!--==============================
	  Google Fonts
	============================== -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400;500;600;700;800&family=Jost:wght@300;400;500;600;700;800;900&family=Roboto:wght@100;300;400;500;700&display=swap" rel="stylesheet">


    <!--==============================
	    All CSS File
	============================== -->
    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('public/bipebd/assets/css/bootstrap.min.css') }}">
    <!-- Fontawesome Icon -->
    <link rel="stylesheet" href="{{ asset('public/bipebd/assets/css/fontawesome.min.css') }}">
    <!-- Magnific Popup -->
    <link rel="stylesheet" href="{{ asset('public/bipebd/assets/css/magnific-popup.min.css') }}">
    <!-- Slick Slider -->
    <link rel="stylesheet" href="{{ asset('public/bipebd/assets/css/slick.min.css') }}">
    <!-- Nice Select -->
    <link rel="stylesheet" href="{{ asset('public/bipebd/assets/css/nice-select.min.css') }}">
    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="{{ asset('public/bipebd/assets/css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>
        #toast-container > div {
            opacity:1;
        }
    </style>
    @stack('css')

    @php
        $logo_top = \App\Models\Admin\Logo::where([['logo_position','bipebd_top'],['logo_for','bipebd'],['logo_status','Active'],['logo_delete',0]])->first();
        $logo_bottom = \App\Models\Admin\Logo::where([['logo_position','bipebd_bottom'],['logo_for','bipebd'],['logo_status','Active'],['logo_delete',0]])->first();
        $contact_info = \App\Models\Admin\ContactInfo::find(1);
    @endphp
</head>

{!! Toastr::message() !!}
<body>
    @if (Auth::check())
    <div class="sidemenu-wrapper d-none d-lg-block">
        <div class="sidemenu-content">
            <button class="closeButton sideMenuCls"><i class="far fa-times"></i></button>
            <div class="widget woocommerce widget_shopping_cart">
                <h3 class="widget_title">{{ __('admin_local.Shopping cart') }}</h3>
                <div class="widget_shopping_cart_content">
                    <ul class="woocommerce-mini-cart cart_list product_list_widget ">
                        @php
                            $carts = \App\Models\FrontEnd\CourseCart::with('course')->where([['user_id',Auth::user()->id]])->get();
                            $subTotal = 0;
                        @endphp
                        @foreach ($carts as $kcart=>$cart)

                        @php
                            if($cart->course->course_status==0 || $cart->course->course_delete==1){
                                continue;
                            }
                            $cart_course_images = '';
                            $cart_course_images = $cart->course->course_images?explode(',',$cart->course->course_images):asset('public/bipebd/assets/img/course/course_1_1.png');
                        @endphp
                        <li class="woocommerce-mini-cart-item mini_cart_item " id="cart-item-{{ $kcart }}">
                            <a onclick="remove_item_from_cart('{{ $cart->course->course_name_slug }}','cart-item-{{ $kcart }}')" class="remove remove_from_cart_button" id="remove_item_from_cart"><i class="far fa-times"></i></a>
                            <a href="{{ route('frontend.courses.single', $cart->course->course_name_slug) }}"><img src="{{ $cart->course->course_images?asset($cart_course_images[0]):$cart_course_images }}" alt="Cart Image">{{ $cart->course->course_name }}</a>
                            <span class="quantity">1 ×
                                <span class="woocommerce-Price-amount amount">
                                    <span class="woocommerce-Price-currencySymbol"></span>{{ $cart->course->course_discount>0?$cart->course->course_discount_price:$cart->course->course_price }} {{ $cart->course->course_price_currency }}
                                </span>
                            </span>
                        </li>
                        @php
                            $subTotal = $subTotal + ($cart->course->course_discount>0?$cart->course->course_discount_price:$cart->course->course_price);
                        @endphp
                        @endforeach
                    </ul>
                    <p class="woocommerce-mini-cart__total total">
                        <strong>{{ __('admin_local.Subtotal') }}:</strong>

                        <span class="woocommerce-Price-amount amount" id="subTotal">{{ floor($subTotal) }} @if (count($carts)>0) {{ $cart->course->course_price_currency }} @endif</span>
                    </p>
                    <p class="woocommerce-mini-cart__buttons buttons">
                        <a href="{{ route('frontend.course.viewCart') }}" class="th-btn wc-forward py-3">{{ __('admin_local.View cart') }}</a>
                        {{-- <a href="checkout.html" class="th-btn checkout wc-forward">Checkout</a> --}}
                    </p>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="popup-search-box d-none d-lg-block">
        <button class="searchClose"><i class="fal fa-times"></i></button>
        <form action="#">
            <input type="text" placeholder="What are you looking for?">
            <button type="submit"><i class="fal fa-search"></i></button>
        </form>
    </div>
    <!--==============================
    Mobile Menu
  ============================== -->
    <div class="th-menu-wrapper">
        <div class="th-menu-area text-center">
            <button class="th-menu-toggle"><i class="fal fa-times"></i></button>
            <div class="mobile-logo">
                <a href="{{ url('/') }}"><img src="{{ $logo_top?asset($logo_top->logo_image):'' }}" alt="{{env('COMPANY_NAME ')}}"></a>
            </div>
            <div class="th-mobile-menu">
                {{-- <form class="search-form mx-3">
                    <input type="text" placeholder="Search For ....">
                    <button type="submit"><i class="far fa-search"></i></button>
                </form> --}}
                @include('frontend.shared.nav.nav')

            </div>
            <div class="row py-0 px-1">
                <div class="col-md-12 py-0 text-center">
                    @if (Auth::check())
                    <a class="th-btn style1 py-10 px-10" href="#"><i class="fa-solid fa-user"></i>  {{ Auth::user()->name }}</a><br><br>
                    <a class="th-btn style1 py-10 px-10 mt-3" href="{{ route('user.attemptLogout') }}"><i class="fa-solid fa-right-from-bracket"></i>  {{ __("admin_local.Sign Out") }}</a>
                    @else
                    <a class="th-btn style1 py-10 px-10 mr-5" href="{{ route('user.login','login') }}"><i class="fa-solid fa-right-to-bracket"></i>  {{ __('admin_local.Login') }}</a> <a href="{{ route('user.login','register') }}" class="th-btn style3 py-10 px-10" href="{{ url('contact-us') }}"><i class="fa-regular fa-user-plus"></i> {{ __('admin_local.Register') }}</a>
                    @endif

                </div>
            </div>
        </div>
    </div>
    <!--==============================
	Header Area
==============================-->
    <header class="th-header header-layout-default">
        <div class="logo-bg-half"></div>
        <div class="header-top">
            <div class="container-fluid">
                <div class="row justify-content-center justify-content-lg-between align-items-center gy-2">
                    <div class="col-auto d-none d-lg-block">
                        <div class="header-links">
                            <ul>
                                @if($contact_info->phone)<li><i class="far fa-phone"></i><a href="tel:{{ $contact_info->phone }}">{{ $contact_info->phone }}</a></li>@endif
                                @if($contact_info->phone)<li class="d-none d-xl-inline-block"><i class="far fa-envelope"></i><a href="mailto:{{ $contact_info->email }}">{{ $contact_info->email }}</a></li>@endif

                                <li class="d-none d-lg-inline-block" style="text-align: right">
                                    @if (Auth::check())
                                    <a style="text-align: right" href="{{ route('user.login','login') }}"><i class="far fa-user"></i> {{ Auth::user()->name }}</a>
                                    @else
                                    <i class="far fa-user"></i><a href="{{ route('user.login','login') }}">{{ __('admin_local.Login') }}</a> / <a href="{{ route('user.login','register') }}">{{ __('admin_local.Register') }}</a>
                                    @endif

                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="header-links header-right">
                            <ul>
                                <li >
                                    <div class="header-social">
                                        <span class="social-title">{{ __('admin_local.Follow Us') }}:</span>
                                        @if($contact_info->facebook)<a target="__blank" href="{{ $contact_info->facebook }}"><i class="fab fa-facebook-f"></i></a>@endif
                                        @if($contact_info->twitter)<a target="__blank" href="{{ $contact_info->twitter }}"><i class="fab fa-twitter"></i></a>@endif
                                        @if($contact_info->linkedin)<a target="__blank" href="{{ $contact_info->linkedin }}"><i class="fab fa-linkedin-in"></i></a>@endif
                                        @if($contact_info->youtube)<a target="__blank" href="{{ $contact_info->youtube }}"><i class="fab fa-youtube"></i></a>@endif
                                        {{-- <a href="https://www.instagram.com/"><i class="fab fa-skype"></i></a> --}}
                                    </div>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="sticky-wrapper">
            <!-- Main Menu Area -->
            <div class="menu-area" id="menu-area">
                <div class="container-fluid">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-xl-auto">
                            <div class="row align-items-center justify-content-between" style="backgroud:white;">
                                <div class="col-auto" style="backgroud:white;">
                                    <div class="header-logo" style="backgroud:white;">
                                        <a href="{{ url('/') }}"><img src="{{ $logo_top?asset($logo_top->logo_image):'' }}" style="height: 44px;" alt="{{env('COMPANY_NAME ')}}"></a>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <div class="header-button">
                                        <a href="{{ route('frontend.course.viewCart') }}" class="icon-btn cartbt1">
                                            <i class="far fa-shopping-cart"></i>
                                            <span class="badge" id="show_shopping_cart_mob">
                                                @if (Auth::check())
                                                {{ count($carts) }}
                                                @else
                                                    0
                                                @endif
                                        </span>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <nav class="main-menu d-none d-lg-inline-block">
                                        @include('frontend.shared.nav.nav')
                                    </nav>
                                    <button type="button" class="th-menu-toggle d-block d-lg-none"><i class="far fa-bars"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto d-none d-xl-block">
                            <div class="row">
                                <div class="col-auto">
                                    <div class="header-button">
                                        <div class="category-menu-wrap mr-5">
                                            <a class="menu-expand" href="#"><i class="fa-solid fa-grid-2 me-2"></i>{{ __('admin_local.Categories') }} <i class="fa-solid fa-angle-down ms-auto"></i></a>
                                            <nav class="category-menu">
                                                <ul>
                                                    @php
                                                        $course_categories = \App\Models\Admin\Course\CourseCategory::where([['category_status',1],['category_delete',0]])->get();
                                                    @endphp
                                                    @foreach ($course_categories as $course_category)
                                                        <li><a href="course">{{ $course_category->category_name }}</a></li>
                                                    @endforeach
                                                </ul>
                                            </nav>
                                            {{-- <form class="search-form">
                                                <input type="text" placeholder="Search For Course....">
                                                <button type="submit"><i class="far fa-search"></i></button>
                                            </form> --}}
                                        </div>
                                        {{-- <a href="wishlist.html" class="icon-btn">
                                            <i class="far fa-heart"></i>
                                            <span class="badge">3</span>
                                        </a> --}}
                                        <button type="button" class="icon-btn  @if (Auth::check()) @if(Request::url()!=route('frontend.course.viewCart')) sideMenuToggler @endif @else goToLogin @endif">
                                            <i class="far fa-shopping-cart"></i>
                                            <span class="badge" id="show_shopping_cart">
                                                @if (Auth::check())
                                                    {{ count($carts) }}
                                                @else
                                                    0
                                                @endif
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="logo-bg"></div>
            </div>
        </div>
    </header>
    <!--==============================
Hero Area
==============================-->
    @yield('content')
    <!--==============================
	Footer Area
==============================-->
    <footer class="footer-wrapper footer-layout1" data-bg-src="{{ asset('public/bipebd/assets/img/bg/footer-bg.png')}}">
        <div class="shape-mockup footer-shape1 jump" data-left="60px" data-top="70px">
            <img src="{{ asset('public/bipebd/assets/img/normal/footer-bg-shape1.png') }}" alt="img">
        </div>
        <div class="shape-mockup footer-shape2 jump-reverse" data-right="80px" data-bottom="120px">
            <img src="{{ asset('public/bipebd/assets/img/normal/footer-bg-shape2.png') }}" alt="img">
        </div>
        <div class="footer-top">
            <div class="container">
                <div class="footer-contact-wrap">
                    <div class="footer-contact">
                        <div class="footer-contact_icon icon-btn">
                            <i class="fal fa-phone"></i>
                        </div>
                        <div class="media-body">
                            <p class="footer-contact_text">{{ __('admin_local.Call us any time') }}:</p>
                            <a href="tel{{ $contact_info->phone }}" class="footer-contact_link">{{ $contact_info->phone }}</a>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <div class="footer-contact">
                        <div class="footer-contact_icon icon-btn">
                            <i class="fal fa-envelope"></i>
                        </div>
                        <div class="media-body">
                            <p class="footer-contact_text">{{ __('admin_local.Email us 24/7 hours') }}:</p>
                            <a href="mailto:{{ $contact_info->email }}" class="footer-contact_link">{{ $contact_info->email }}</a>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <div class="footer-contact" style="max-width: 400px">
                        <div class="footer-contact_icon icon-btn">
                            <i class="fal fa-location-dot"></i>
                        </div>
                        <div class="media-body">
                            <p class="footer-contact_text">{{ __('admin_local.Our office location') }}:</p>
                            <a @if($contact_info->location) target="__blank" @endif href="{{ url('contact-us') }}" class="footer-contact_link" style="font-size: 14px;">{{ $contact_info->address }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="footer-wrap" data-bg-src="{{ asset('public/bipebd/assets/img/bg/jiji.png')}}"> --}}
        <div class="footer-wrap" >
            <div class="widget-area">
                <div class="container">
                    <div class="row justify-content-between">
                        <div class="col-md-6 col-xxl-3 col-xl-3">
                            <div class="widget footer-widget">
                                <div class="th-widget-about">
                                    <div class="about-logo">
                                        <a href="{{ url('/') }}"><img src="{{ $logo_bottom?asset($logo_bottom->logo_image):'' }}" alt="{{env('COMPANY_NAME ')}}"></a>
                                    </div>
                                    {{-- <p class="about-text">Continually optimize backward manufactured products whereas communities negotiate life compelling alignments</p> --}}
                                    <div class="th-social">
                                        <h6 class="title text-white">{{ __('admin_local.FOLLOW US ON') }}:</h6>
                                        @if($contact_info->facebook)<a target="__blank" href="{{ $contact_info->facebook }}"><i class="fab fa-facebook-f"></i></a>@endif
                                        @if($contact_info->twitter)<a target="__blank" href="{{ $contact_info->twitter }}"><i class="fab fa-twitter"></i></a>@endif
                                        @if($contact_info->linkedin)<a target="__blank" href="{{ $contact_info->linkedin }}"><i class="fab fa-linkedin-in"></i></a>@endif
                                        @if($contact_info->youtube)<a target="__blank" href="{{ $contact_info->youtube }}"><i class="fab fa-youtube"></i></a>@endif
                                        {{-- <a href="https://www.skype.com/"><i class="fab fa-skype"></i></a> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-auto">
                            <div class="widget widget_nav_menu footer-widget">
                                <h3 class="widget_title">{{ __('admin_local.Categories') }}</h3>
                                <div class="menu-all-pages-container">
                                    <ul class="menu">
                                        @php
                                            $course_categories = \App\Models\Admin\Course\CourseCategory::where([['category_status',1],['category_delete',0]])->get();
                                        @endphp
                                        @foreach ($course_categories as $course_category)
                                        <li><a href="{{ route('frontend.courses.getAllCourses',['category',$course_category->category_slug]) }}">{{ $course_category->category_name }}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-auto">
                            <div class="widget widget_nav_menu footer-widget">
                                <h3 class="widget_title">{{ __('admin_local.Resources') }}</h3>
                                <div class="menu-all-pages-container">
                                    <ul class="menu">
                                        {{-- <li><a href="contact.html">{{ __('admin_local.Blogs') }}</a></li> --}}
                                        <li><a href="{{ url('all-instructor') }}">{{ __('admin_local.Instructors') }}</a></li>
                                        <li><a href="{{ url('about-us') }}">{{ __('admin_local.About Us') }}</a></li>
                                        <li><a href="{{ url('contact-us') }}">{{ __('admin_local.Contact Us') }}</a></li>
                                        {{-- <li><a href="contact.html">{{ __('admin_local.Privacy and Policy') }}</a></li> --}}
                                    </ul>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-md-6 col-xxl-3 col-xl-3">
                            <div class="widget newsletter-widget footer-widget">
                                <h3 class="widget_title">{{ __('admin_local.Get in touch') }}!</h3>
                                <p class="footer-text">{{ __('admin_local.Send us email to get touch in with us') }}</p>
                                <form class="newsletter-form form-group">
                                    <input class="form-control" type="email" placeholder="Email Email" required="">
                                    <i class="far fa-envelope"></i>
                                    <button type="submit" class="th-btn style3">{{ __('admin_local.Send') }}<i class="far fa-arrow-right ms-1"></i></button>
                                </form>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="copyright-wrap">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-md-6">
                            <p class="copyright-text">{{ __('admin_local.Copyright') }} © {{ date('Y') }} <a href="{{ url('/') }}">{{ config('info')['institute_name'] }}</a> {{ __('admin_local.All Rights Reserved') }}</p>
                        </div>
                        <div class="col-md-6 text-end d-none d-md-block">
                            <div class="footer-links">
                                <ul>
                                    <li><a href="#">Designed & Developed By Md. Mutasim Naib</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!--********************************
			Code End  Here
	******************************** -->

    <!-- Scroll To Top -->
    <div class="scroll-top">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" style="transition: stroke-dashoffset 10ms linear 0s; stroke-dasharray: 307.919, 307.919; stroke-dashoffset: 307.919;"></path>
        </svg>
    </div>

    <!--==============================
    All Js File
============================== -->
    <!-- Jquery -->
    <script src="{{ asset('public/bipebd/assets/js/vendor/jquery-3.6.0.min.js') }}"></script>
    @yield('custom_js')
    <!-- Slick Slider -->
    <script src="{{ asset('public/bipebd/assets/js/slick.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('public/bipebd/assets/js/bootstrap.min.js') }}"></script>
    <!-- Magnific Popup -->
    <script src="{{ asset('public/bipebd/assets/js/jquery.magnific-popup.min.js') }}"></script>
    <!-- Counter Up -->
    <script src="{{ asset('public/bipebd/assets/js/jquery.counterup.min.js') }}"></script>
    <!-- Circle Progress -->
    <script src="{{ asset('public/bipebd/assets/js/circle-progress.js') }}"></script>
    <!-- Range Slider -->
    <script src="{{ asset('public/bipebd/assets/js/jquery-ui.min.js') }}"></script>
    <!-- Isotope Filter -->
    <script src="{{ asset('public/bipebd/assets/js/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('public/bipebd/assets/js/isotope.pkgd.min.js') }}"></script>
    <!-- Tilt JS -->
    <script src="{{ asset('public/bipebd/assets/js/tilt.jquery.min.js') }}"></script>
    <!-- Tweenmax JS -->
    <script src="{{ asset('public/bipebd/assets/js/tweenmax.min.js') }}"></script>
    <!-- Nice Select JS -->
    <script src="{{ asset('public/bipebd/assets/js/nice-select.min.js') }}"></script>

    <!-- Main Js File -->
    <script src="{{ asset('public/bipebd/assets/js/main.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    @stack('js')
    @if (session()->get('cart_add_success'))
    <script>
        toastr.success("{{ session()->get('cart_add_success') }}",{timeOut:5000,showMethod:'slideDown'});
        // toastr.success('We do have the Kapua suite available.', 'Turtle Bay Resort', {timeOut: 15000})

        // toastr.success({
        //     text:'asdasdasdasdas'
        // })
    </script>
    @endif
    @if (session()->get('cart_add_invalid'))
    <script>
        toastr.error("{{ session()->get('cart_add_invalid') }}",{timeOut:5000,showMethod:'slideDown'});
        // toastr.success('We do have the Kapua suite available.', 'Turtle Bay Resort', {timeOut: 15000})

        // toastr.success({
        //     text:'asdasdasdasdas'
        // })
    </script>
    @endif
    @if (session()->get('success_payment'))
    <script>
        toastr.success("{{ session()->get('success_payment') }}",{timeOut:5000,showMethod:'slideDown'});
    </script>
    @endif
    @stack('toastr')
    <script>
        $('.goToLogin').click(function(){
            window.location.replace("{{ route('user.login','login') }}");
        })
        function remove_item_from_cart(slug,rid){
            $.ajax({
                type: "get",
                url: "{{ url('course/delete-from-cart') }}"+"/"+slug,
                dataType: 'JSON',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    $("#"+rid).remove();
                    $('#subTotal').empty().append(data.subTotal);
                    $('#show_shopping_cart').empty().append(data.cart_count);
                    $('#show_shopping_cart_mob').empty().append(data.cart_count);
                },
                error : function(err){
                    // if(err.status=401){
                    //     window.location.replace("{{ route('user.login','login') }}");
                    // }
                }
            })
        }
    </script>
</body>

</html>
