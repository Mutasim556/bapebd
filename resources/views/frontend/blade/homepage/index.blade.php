@extends('frontend.shared.layouts.app')
@push('title')
    {{ __('admin_local.Home Page') }}
@endpush

@section('content')
@php
    $sliders = DB::table('homepage_silders')->where([['status',1],['delete',0]])->get();
@endphp
<div class="th-hero-wrapper hero-1" id="hero">
    <div class="hero-slider-1 th-carousel" data-fade="true" data-slide-show="1" data-md-slide-show="1" data-dots="true">

        @foreach ($sliders as $slider)
            <div class="th-hero-slide">
                <div class="th-hero-bg" data-overlay="title" data-opacity="8" data-bg-src="{{ \URL::to('/').'/public/'.$slider->slider_image }}"></div>
                <div class="container">
                    <div class="row align-items-center justify-content-center">
                        <div class="col-md-6">
                            <div class="hero-style1">
                                {{-- <span class="hero-subtitle" data-ani="slideinleft" data-ani-delay="0.1s"><span>35% OFF</span> LEARN FROM TODAY</span> --}}
                                <h1 class="hero-title text-white" data-ani="slideinleft" data-ani-delay="0.4s">{{ $slider->slider_title }}</span></h1>
                                <p class="hero-text" data-ani="slideinleft" data-ani-delay="0.6s">{{ $slider->slider_short_description }}</p>
                                <div class="btn-group" data-ani="slideinleft" data-ani-delay="0.8s">
                                    <a href="contact.html" class="th-btn style3">{{ $slider->slider_button_text }}<i class="fas fa-arrow-right ms-2"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 text-lg-end text-center">
                            <div class="hero-img1">
                                <img src="{{ \URL::to('/').'/public/'.$slider->slider_image2 }}" alt="hero">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="hero-shape shape1">
                    <img src="{{ asset('public/bipebd/assets/img/hero/shape_1_1.png')}}" alt="shape">
                </div>
                <div class="hero-shape shape2">
                    <img src="{{ asset('public/bipebd/assets/img/hero/shape_1_2.png')}}" alt="shape">
                </div>
                <div class="hero-shape shape3"></div>

                <div class="hero-shape shape4 shape-mockup jump-reverse" data-right="3%" data-bottom="7%">
                    <img src="{{ asset('public/bipebd/assets/img/hero/shape_1_3.png')}}" alt="shape">
                </div>
                <div class="hero-shape shape5 shape-mockup jump-reverse" data-left="0" data-bottom="0">
                    <img src="{{ asset('public/bipebd/assets/img/hero/shape_1_4.png')}}" alt="shape">
                </div>
            </div>
        @endforeach



        {{-- <div class="th-hero-slide">
            <div class="th-hero-bg" data-overlay="title" data-opacity="8" data-bg-src="{{ asset('public/bipebd/assets/img/hero/hero_bg_1_2.jpg')}}"></div>
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-md-6">
                        <div class="hero-style1">
                            <span class="hero-subtitle" data-ani="slideinleft" data-ani-delay="0.1s"><span>35% OFF</span> LEARN FROM TODAY</span>
                            <h1 class="hero-title text-white" data-ani="slideinleft" data-ani-delay="0.4s">Edura Leads To A Brighter <span class="text-theme">Future.</span></h1>
                            <p class="hero-text" data-ani="slideinleft" data-ani-delay="0.6s">Education can be thought of as the transmission of a societys values and accumulated knowledge. In this sense, it is equivalent.</p>
                            <div class="btn-group" data-ani="slideinleft" data-ani-delay="0.8s">
                                <a href="contact.html" class="th-btn style3">Get Started<i class="fas fa-arrow-right ms-2"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 text-lg-end text-center">
                        <div class="hero-img1">
                            <img src="{{ asset('public/bipebd/assets/img/hero/hero_thumb_1_2.jpg')}}" alt="hero">
                        </div>
                    </div>
                </div>
            </div>
            <div class="hero-shape shape1">
                <img src="{{ asset('public/bipebd/assets/img/hero/shape_1_1.png')}}" alt="shape">
            </div>
            <div class="hero-shape shape2">
                <img src="{{ asset('public/bipebd/assets/img/hero/shape_1_2.png')}}" alt="shape">
            </div>
            <div class="hero-shape shape3"></div>

            <div class="hero-shape shape4 shape-mockup jump-reverse" data-right="3%" data-bottom="7%">
                <img src="{{ asset('public/bipebd/assets/img/hero/shape_1_3.png')}}" alt="shape">
            </div>
            <div class="hero-shape shape5 shape-mockup jump-reverse" data-left="0" data-bottom="0">
                <img src="{{ asset('public/bipebd/assets/img/hero/shape_1_4.png')}}" alt="shape">
            </div>
        </div> --}}
    </div>
</div>
<!--======== / Hero Section ========-->
<!--==============================

Contact Area
==============================-->

@php
$categories = \App\Models\Admin\Course\CourseCategory::with('courses')->where([['category_status',1],['category_delete',0]])->orderBy('id','ASC')->get();
@endphp
<div class="space-top py-5">
    <div class="container">
        <div class="category-sec-wrap">
            <div class="shape-mockup category-shape-arrow d-xl-block d-none">
                <img src="{{ asset('public/bipebd/assets/img/normal/category-arrow.svg') }}" alt="img">
            </div>
            <div class="row">
                <div class="col-xl-4">
                    <div class="title-area mb-25 mb-lg-0 text-xl-start text-center">
                        <span class="sub-title"><i class="fal fa-book me-2"></i> {{ __('admin_local.Courses Categories') }}</span>
                        <h2 class="sec-title">{{ __('admin_local.Explore Top Categories') }}</h2>
                        <a href="{{ route('frontend.courses.getAllCourses',['view']) }}" class="th-btn p-2">{{ __('admin_local.View All Category') }}<i class="fa-regular fa-arrow-right ms-2"></i></a>
                    </div>
                </div>
                <div class="col-xl-8">
                    <div class="row slider-shadow th-carousel category-slider" data-slide-show="3" data-ml-slide-show="3" data-md-slide-show="3" data-sm-slide-show="2" data-arrows="true" data-xl-arrows="true">
                        @foreach ($categories as $category)
                            <div class="col-md-6 col-xl-4" >
                                <div class="category-card">
                                    <div class="category-card-icon mb-2">
                                        <img src="{{ $category->category_image }}" alt="image">
                                    </div>
                                    <div class="category-card_content">
                                        <h3 class="category-card_title" id="categories_slick_slider"><a href="{{ route('frontend.courses.getAllCourses',['category',$category->category_slug]) }}">{{ $category->category_name }}</a></h3>
                                        <p class="category-card_text">{{ count($category->courses) }} {{ __('admin_local.Courses') }} </p>
                                        <a href="{{ route('frontend.courses.getAllCourses',['category',$category->category_slug]) }}" class="th-btn py-2">{{ __('admin_local.View Courses') }}<i class="fa-solid fa-arrow-right ms-1"></i></a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<section class="space" data-bg-src="{{ asset('public/bipebd/assets/img/bg/course_bg_1.png')}}" id="course-sec">
    <div class="container">
        <div class="mb-35 text-center text-md-start">
            <div class="row align-items-center justify-content-between">
                <div class="col-md-8">
                    <div class="title-area mb-md-0">
                        <span class="sub-title"><i class="fal fa-book me-2"></i> {{ __('admin_local.Popular Courses') }}</span>
                        <h2 class="sec-title">{{ __('admin_local.Our Popular Courses') }}</h2>
                    </div>
                </div>
                <div class="col-md-auto">
                    <a href="{{ route('frontend.courses.getAllCourses',['view']) }}" class="th-btn p-2 ">{{ __('admin_local.View All Courses') }}<i class="fa-solid fa-arrow-right ms-2"></i></a>
                </div>
            </div>
        </div>
        <div class="row slider-shadow th-carousel course-slider-1" data-slide-show="4" data-ml-slide-show="3" data-lg-slide-show="3" data-md-slide-show="2" data-sm-slide-show="1" data-arrows="true">
            @php
                $courses = \App\Models\Admin\Course\Course::where([['course_status',1],['course_delete',0]])->orderBy('id','DESC')->get();
            @endphp
            @foreach ($courses as $key=>$course)
            @php
                if($course->course_status==0||$course->course_delete==1){
                    continue;
                }

                $course_images = $course->course_images?explode(',',$course->course_images):asset('public/bipebd/assets/img/course/course_1_1.png');
            @endphp
                <div class="col-md-6 col-xxl-3 col-lg-4" >
                    <div class="course-box px-0" style="border:1px dashed lightgrey">
                        <div class="course-img">
                            <a href="{{ route('frontend.courses.single',$course->course_name_slug) }}"><img style="height:250px" src="{{ $course->course_images?$course_images[0]:$course_images }}" alt="img"></a>
                            @if ($course->course_discount>0)
                            <span class="tag"><i class="fas fa-clock"></i>{{ $course->course_discount_type=='Flat'?__('admin_local.Flat'):'' }} {{$course->course_discount}} {{ $course->course_discount_type=='Flat'?$course->course_price_currency:'%' }} {{ __('admin_local.Discount') }}</span>
                            @else

                            @endif

                        </div>
                        <div class="course-content px-2 text-center" >
                            {{-- <div class="course-rating my-0">
                                <div class="star-rating" role="img" aria-label="Rated 4.00 out of 5">
                                    <span style="width:79%">Rated <strong class="rating">4.00</strong> out of 5</span>
                                </div>(4.7)
                            </div> --}}
                            <h3 class="course-title my-0"><a href="{{ route('frontend.courses.single',$course->course_name_slug) }}">{{ $course->course_name }}</a></h3>
                            @if ($course->course_discount>0)
                            <span></span>
                            <div class="course-meta mb-0">
                                <span class="text-success mx-auto" style="font-size: 15px;text-align: center"><Strong>{{ __('admin_local.Price') }}</Strong> : <strike class="text-danger">{{ $course->course_price }} {{ $course->course_price_currency }}</strike> {{ $course->course_discount_price }} {{ $course->course_price_currency }}</span>
                                {{-- <span class="text-success" style="font-size: 13px"><Strong>{{ __('admin_local.Descounted Price') }}</Strong> : {{ $course->course_discount_price }} {{ $course->course_price_currency }}</span> --}}

                            </div>
                            @else
                                <span class="text-success mx-auto" style="font-size: 15px;text-align: center"><Strong>{{ __('admin_local.Price') }}</Strong> : {{ $course->course_price }} {{ $course->course_price_currency }}</span>
                            @endif
                            <div class="course-meta py-1 my-0">

                                @if (Auth::user())
                                    @php
                                        $purchased_courses = Auth::user()->purchasedCourses(Auth::user()->id);
                                    @endphp
                                    @if (!empty($purchased_courses)&& in_array($course->id,$purchased_courses))
                                    <a href="{{ route('frontend.courses.single',$course->course_name_slug) }}" class="btn btn-success mx-auto mt-0 p-1 px-2" style="font-size: 15px;text-align: center">{{ __('admin_local.View Course') }}</a>
                                    @else
                                    <a class="btn btn-primary mx-auto mt-0 p-1 px-2" style="font-size: 15px;text-align: center">{{ __('admin_local.Enroll Now') }}</a>
                                    <a href="{{ route('frontend.course.addCart',$course->course_name_slug) }}" class="btn btn-info mx-auto mt-0 p-1 px-2" style="font-size: 15px;text-align: center">{{ __('admin_local.Add Cart') }}</a>
                                    @endif
                                @else
                                <a class="btn btn-primary mx-auto mt-0 p-1 px-2" style="font-size: 15px;text-align: center">{{ __('admin_local.Enroll Now') }}</a>
                                <a href="{{ route('frontend.course.addCart',$course->course_name_slug) }}" class="btn btn-info mx-auto mt-0 p-1 px-2" style="font-size: 15px;text-align: center">{{ __('admin_local.Add Cart') }}</a>
                                @endif

                            </div>

                            @if ($course->course_type=='Live')
                            @php
                                $inctructor = \App\Models\Admin\Course\CourseInstructor::with('instructor')->where([['course_id',$course->id]])->orderBy('id','DESC')->first();
                                $batches = \App\Models\Admin\Course\CourseBatch::where([['batch_status',1],['batch_delete',0],['course_id',$course->id]])->get();
                            @endphp
                                <div class="course-meta text-primary">
                                    <span><i class="fal fa-file"></i>{{ __('admin_local.Batches') }} : {{ count($batches) }}</span>
                                    <span><i class="fal fa-user"></i>{{ __('admin_local.Students') }} : {{ $course->enrolled_count??0 }}</span>
                                    <span><i class="fal fa-chart-simple"></i>{{ $course->course_level }}</span>
                                </div>
                                <div class="course-author">
                                    <div class="author-info">
                                        <img src="@if($inctructor->instructor->image) {{ $inctructor->instructor->image }} @else public/bipebd/assets/img/course/author.png @endif" alt="author">
                                        <a href="course.html" class="author-name">{{ $inctructor->instructor->name }}</a>
                                    </div>
                                    <div class="offer-tag bg-danger text-white px-2" style="border-radius: 6px;font-size:11px;">{{ __('admin_local.Live') }}</div>
                                </div>
                            @else
                            @php
                                $inctructor = \App\Models\Admin\Course\CourseInstructor::with('instructor')->where([['course_id',$course->id]])->orderBy('id','DESC')->first();
                                $videos = \App\Models\Admin\Course\CourseVideo::where([['video_status',1],['video_delete',0]])->get();
                            @endphp
                                <div class="course-meta">
                                    <span><i class="fal fa-file"></i>{{ __('admin_local.Videos') }} : {{ count($videos) }}</span>
                                    <span><i class="fal fa-user"></i>{{ __('admin_local.Enrolled') }} : {{ $course->enrolled_count??0 }}</span>
                                    <span><i class="fal fa-chart-simple"></i>{{ $course->course_level }}</span>
                                </div>
                                <div class="course-author">
                                    <div class="author-info">
                                        <img src="@if($inctructor->instructor->image) {{ $inctructor->instructor->image }} @else public/bipebd/assets/img/course/author.png @endif" alt="author">
                                        <a href="course.html" class="author-name">{{ $inctructor->instructor->name }}</a>
                                    </div>
                                    <div class="offer-tag bg-success text-white px-2" style="border-radius: 6px;font-size:11px;">{{ __('admin_local.Pre-recorded') }}</div>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            @endforeach
            </div>

        </div>
    </div>
</section>

<!--==============================
About Area
==============================-->
<section class="py-5 bg-smoke overflow-hidden" id="team-sec">
    <div class="shape-mockup team2-bg-shape1 jump-reverse d-lg-block d-none" data-left="-2%" data-top="0">
        <img src="{{ asset('public/bipebd/assets/img/team/team-shape_1_1.png') }}" alt="img">
    </div>

    <div class="shape-mockup team2-bg-shape2 jump d-lg-block d-none" data-left="95%" data-top="7%" >
        <img src="{{ asset('public/bipebd/assets/img/team/team-shape_1_2.png') }}" alt="img">
    </div>

    <div class="shape-mockup team2-bg-shape3 jump d-md-block d-none" ata-left="75%" data-top="7%">
        <img src="{{ asset('public/bipebd/assets/img/team/team-shape_1_3.png') }}" alt="img">
    </div>

    <div class="shape-mockup team2-bg-shape4 spin d-md-block d-none" data-left="40%" data-bottom="4%">
        <img src="{{ asset('public/bipebd/assets/img/team/team-shape_1_4.png') }}" alt="img">
    </div>

    <div class="shape-mockup team2-bg-shape5 jump d-xxl-block d-none" data-right="-7%" data-top="10%">
        <img src="{{ asset('public/bipebd/assets/img/team/team-shape_1_5.png') }}" alt="img">
    </div>

    <div class="container">
        <div class="title-area text-center">
            <span class="sub-title"><i class="fal fa-book me-2"></i> Our Instructor</span>
            <h2 class="sec-title">Meet Our Expert Instructor</h2>
        </div>
        <div class="row th-carousel slider-shadow py-0" data-slide-show="4" data-lg-slide-show="3" data-md-slide-show="2" data-sm-slide-show="2" data-xs-slide-show="1">
            <!-- Single Item -->
            @php
                $instructors = \App\Models\Admin::where([['delete','0']])->get();
                $instructors = $instructors->reject(function ($instructor, $key) {
                    return $instructor->getRoleNames()->first()!='Instructor';
                });
            @endphp
            @foreach ($instructors as $instructor)
            @php
                $instructor_prof = \App\Models\Admin\AdminProfileDetails::where([['instructor_id',$instructor->id]])->first();
            @endphp
                <div class="col-lg-6">
                    <div class="team-card style2">
                        <div class="team-img-wrap">
                            <svg class="team-shape" xmlns="http://www.w3.org/2000/svg" width="327" height="337" viewBox="0 0 327 337" fill="none">
                                <path d="M158.167 331C158.167 333.946 160.555 336.333 163.5 336.333C166.446 336.333 168.833 333.946 168.833 331C168.833 328.054 166.446 325.667 163.5 325.667C160.555 325.667 158.167 328.054 158.167 331ZM158.167 6C158.167 8.94552 160.555 11.3333 163.5 11.3333C166.446 11.3333 168.833 8.94552 168.833 6C168.833 3.05448 166.446 0.666667 163.5 0.666667C160.555 0.666667 158.167 3.05448 158.167 6ZM325 167.5C325 257.254 253.238 330 163.5 330V332C254.359 332 327 258.343 327 167.5H325ZM2.00012 167.5C2.00012 77.7618 73.7458 7 163.5 7V5C72.6574 5 0.00012207 76.6411 0.00012207 167.5H2.00012Z" fill="#0D5EF4" />
                            </svg>
                            <div class="team-img">
                                <img src="{{ asset($instructor->image?$instructor->image:'public/bipebd/assets/img/team/team_2_1.jpg')}}" alt="Team">
                            </div>
                            <div class="team-social">
                                <a  class="icon-btn">
                                    <i class="far fa-plus"></i>
                                </a>
                                <div class="th-social">
                                    <a target="_blank" href="{{ $instructor_prof?$instructor_prof->twitter:'' }}"><i class="fab fa-twitter"></i></a>
                                    <a target="_blank" href="{{ $instructor_prof?$instructor_prof->facebook:'' }}"><i class="fab fa-facebook-f"></i></a>
                                    <a target="_blank" href="{{ $instructor_prof?$instructor_prof->linkedin:'' }}"><i class="fab fa-linkedin"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="team-content">
                            <h3 class="team-title"><a href="team-details.html">{{ $instructor->name }}</a></h3>
                            <span class="team-desig"><strong>{{ $instructor_prof?$instructor_prof->designation:'' }}</strong></span>
                            <span><strong>{{ $instructor_prof?$instructor_prof->department:'' }}</strong></span>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</section>
{{-- <div class="counter-area-2" data-bg-src="{{ asset('public/bipebd/assets/img/bg/counter-bg_1.png') }}" > --}}
<div class="counter-area-2" >
    @php
        $counter = \App\Models\Admin\HomepageCounter::first();
    @endphp
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-sm-6 col-xl-3 counter-card-wrap">
                <div class="counter-card">
                    <h2 class="counter-card_number"><span class="counter-number">{{ $counter?$counter->successfully_completed:0 }}</span><span class="fw-normal">+</span></h2>
                    <p class="counter-card_text"><strong>{{ __('admin_local.Successfully Completed') }}</strong></p>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3 counter-card-wrap">
                <div class="counter-card">
                    <h2 class="counter-card_number"><span class="counter-number">{{ $counter?$counter->trainer:0 }}</span><span class="fw-normal">+</span></h2>
                    <p class="counter-card_text"><strong>{{ __('admin_local.Experienced Trainer') }}</strong></p>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3 counter-card-wrap">
                <div class="counter-card">
                    <h2 class="counter-card_number"><span class="counter-number">{{ $counter?$counter->certification:0 }}</span><span class="fw-normal">+</span></h2>
                    <p class="counter-card_text"><strong>{{ __('admin_local.Satisfaction Rate') }}</strong> </p>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3 counter-card-wrap">
                <div class="counter-card">
                    <h2 class="counter-card_number"><span class="counter-number">{{ $counter?$counter->student:0 }}</span><span class="fw-normal">+</span></h2>
                    <p class="counter-card_text"><strong>{{ __('admin_local.Students Community') }}</strong> </p>
                </div>
            </div>
        </div>
    </div>
</div>
<!--==============================
Contact Area
==============================-->

<div class="overflow-hidden space" id="about-sec">
    <div class="shape-mockup jump d-md-block d-none" data-right="0" data-bottom="10%"><img src="{{ asset('public/bipebd/assets/img/normal/about_2_shape1.png') }}" alt="shapes"></div>
    <div class="shape-mockup jump d-md-block d-none" data-right="76px" data-bottom="10%"><img src="{{ asset('public/bipebd/assets/img/normal/about_1_shape1.png') }}" alt="shapes"></div>
    <div class="container-fluid p-0">
        <div class="row">
            @php
                $aboutus = \App\Models\Admin\HomeAboutus::first();
            @endphp
            <div class="col-xl-6 mb-50 mb-xl-0">
                <div class="img-box2">
                    <div class="img1">
                        <img src="{{ $aboutus&&$aboutus->image1?asset('public/'.$aboutus->image1):asset('public/bipebd/assets/img/normal/about_2_1.png') }}" alt="About">
                    </div>
                    <div class="img2 tilt-active">
                        <img src="{{ $aboutus&&$aboutus->image2?asset('public/'.$aboutus->image2):asset('public/bipebd/assets/img/normal/about_2_2.png') }}" alt="About">
                    </div>
                    <div class="about-experience-wrap">
                        <div class="about-experience-icon">
                            <img src="{{ asset('public/bipebd/assets/img/icon/logo-icon.svg') }}" alt="img">
                        </div>
                        <div class="about-experience-tag">
                            <?php
                                $date1 = new DateTime(env('COMPANY_START_DATE'));
                                $date2 = new DateTime(date('Y-m-d'));

                                $interval = $date1->diff($date2);
                                // echo ; // Outputs: 25
                            ?>
                            <span class="about-title-anime">{{ $aboutus&&$aboutus->number_of_experience?$aboutus->number_of_experience:$interval->y+1 }}+ {{ __('admin_local.YEARS EXPERIENCE') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="about2-title-wrap">
                    <div class="title-area mb-30">
                        <span class="sub-title"><i class="fal fa-book me-2"></i> {{ __('admin_local.Get to Know About Us') }} </span>
                        <h2 class="sec-title">{{ $aboutus&&$aboutus->headline?$aboutus->headline:'' }}</h2>
                    </div>
                    <p class="mt-n2 mb-35">{{ $aboutus&&$aboutus->short_details?$aboutus->short_details:'' }}</p>
                    <div class="checklist style3 mb-45">
                        <ul>
                            @php
                                $points = $aboutus&&$aboutus->points?json_decode($aboutus->points):[];
                            @endphp
                            @foreach ($points as $key=>$point)
                            <li> {{ $point }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <a href="about.html" class="th-btn">{{ $aboutus&&$aboutus->button_text?$aboutus->button_text:'' }}<i class="far fa-arrow-right ms-2"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>
<!--==============================
Testimonial Area
==============================-->

<section class="testi-area-4 overflow-hidden space py-4" data-bg-src="{{ asset('public/bipebd/assets/img/bg/testi_bg_3.png') }}">

    <div class="shape-mockup testi2-bg-shape2 spin d-xl-block d-none" data-left="2%" data-top="20%">
        <img src="{{ asset('public/bipebd/assets/img/testimonial/testi-bg-shape_3_1.png') }}" alt="img">
    </div>

    <div class="shape-mockup testi2-bg-shape3 spin d-lg-block d-none" data-right="4%" data-bottom="10%">
        <img src="{{ asset('public/bipebd/assets/img/testimonial/testi-bg-shape_3_1.png') }}" alt="img">
    </div>
    <div class="container">
        <div class="title-area text-center">
            <span class="sub-title"><i class="fal fa-book me-2"></i> Our Students Testimonials</span>
            <h2 class="sec-title text-white">Students Say’s About Us!</h2>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row slider-shadow th-carousel testi-slider-4 dot-style2" data-slide-show="4" data-ml-slide-show="3" data-lg-slide-show="2" data-md-slide-show="1" data-dots="true">
            <div class="col-lg-6">
                <div class="testi-box style3">
                    <div class="testi-box_review">
                        <i class="fa-solid fa-star-sharp"></i>
                        <i class="fa-solid fa-star-sharp"></i>
                        <i class="fa-solid fa-star-sharp"></i>
                        <i class="fa-solid fa-star-sharp"></i>
                        <i class="fa-solid fa-star-sharp"></i>
                        (4.7)
                    </div>
                    <div class="testi-box-bg-shape">
                        <svg width="78" height="111" viewBox="0 0 78 111" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 0L78 30V71C78 93.0914 60.0914 111 38 111H10C4.47715 111 0 106.523 0 101V0Z" fill="#0D5EF4" />
                        </svg>
                    </div>
                    <div class="testi-box_content">

                        <p class="testi-box_text">“Quickly maximize visionary solutions after mission critical action item productivity premium portals for impactful -services inactively negotiate enabled niche markets via growth strategies. University is accredited by the Higher Learning Commission.</p>
                    </div>
                    <div class="testi-box_bottom">
                        <div class="testi-box_img">
                            <img src="{{ asset('public/bipebd/assets/img/testimonial/testi_3_1.jpg')}}" alt="Avater">
                        </div>
                        <div class="testi-box-author-details">
                            <h3 class="testi-box_name">Zara Head Milan</h3>
                            <span class="testi-box_desig">IT Student</span>
                        </div>
                        <div class="testi-box_quote">
                            <img src="{{ asset('public/bipebd/assets/img/icon/testi-quote2.svg')}}" alt="quote">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="testi-box style3">
                    <div class="testi-box_review">
                        <i class="fa-solid fa-star-sharp"></i>
                        <i class="fa-solid fa-star-sharp"></i>
                        <i class="fa-solid fa-star-sharp"></i>
                        <i class="fa-solid fa-star-sharp"></i>
                        <i class="fa-solid fa-star-sharp"></i>
                        (4.7)
                    </div>
                    <div class="testi-box-bg-shape">
                        <svg width="78" height="111" viewBox="0 0 78 111" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 0L78 30V71C78 93.0914 60.0914 111 38 111H10C4.47715 111 0 106.523 0 101V0Z" fill="#0D5EF4" />
                        </svg>
                    </div>
                    <div class="testi-box_content">

                        <p class="testi-box_text">They were able to provide me with a range of options for my roof replacement, item productivity premium portals for impactful -services inactively negotiate enabled niche markets via growth strategies. University is accredited by the Higher Learning.</p>
                    </div>
                    <div class="testi-box_bottom">
                        <div class="testi-box_img">
                            <img src="{{ asset('public/bipebd/assets/img/testimonial/testi_3_2.jpg')}}" alt="Avater">
                        </div>
                        <div class="testi-box-author-details">
                            <h3 class="testi-box_name">David H. Smith</h3>
                            <span class="testi-box_desig">Regular Student</span>
                        </div>
                        <div class="testi-box_quote">
                            <img src="{{ asset('public/bipebd/assets/img/icon/testi-quote2.svg')}}" alt="quote">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="testi-box style3">
                    <div class="testi-box_review">
                        <i class="fa-solid fa-star-sharp"></i>
                        <i class="fa-solid fa-star-sharp"></i>
                        <i class="fa-solid fa-star-sharp"></i>
                        <i class="fa-solid fa-star-sharp"></i>
                        <i class="fa-solid fa-star-sharp"></i>
                        (4.7)
                    </div>
                    <div class="testi-box-bg-shape">
                        <svg width="78" height="111" viewBox="0 0 78 111" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 0L78 30V71C78 93.0914 60.0914 111 38 111H10C4.47715 111 0 106.523 0 101V0Z" fill="#0D5EF4" />
                        </svg>
                    </div>
                    <div class="testi-box_content">

                        <p class="testi-box_text">They worked tirelessly to complete the job on time and the final result item productivity premium portals for impactful -services inactively negotiate enabled niche markets via growth strategies. University is accredited by the Higher Learning Commission.</p>
                    </div>
                    <div class="testi-box_bottom">
                        <div class="testi-box_img">
                            <img src="{{ asset('public/bipebd/assets/img/testimonial/testi_3_3.jpg')}}" alt="Avater">
                        </div>
                        <div class="testi-box-author-details">
                            <h3 class="testi-box_name">Anadi Juila</h3>
                            <span class="testi-box_desig">IT Student</span>
                        </div>
                        <div class="testi-box_quote">
                            <img src="{{ asset('public/bipebd/assets/img/icon/testi-quote2.svg')}}" alt="quote">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="testi-box style3">
                    <div class="testi-box_review">
                        <i class="fa-solid fa-star-sharp"></i>
                        <i class="fa-solid fa-star-sharp"></i>
                        <i class="fa-solid fa-star-sharp"></i>
                        <i class="fa-solid fa-star-sharp"></i>
                        <i class="fa-solid fa-star-sharp"></i>
                        (4.7)
                    </div>
                    <div class="testi-box-bg-shape">
                        <svg width="78" height="111" viewBox="0 0 78 111" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 0L78 30V71C78 93.0914 60.0914 111 38 111H10C4.47715 111 0 106.523 0 101V0Z" fill="#0D5EF4" />
                        </svg>
                    </div>
                    <div class="testi-box_content">

                        <p class="testi-box_text">“Quickly maximize visionary solutions after mission critical action item productivity premium portals for impactful -services inactively negotiate enabled niche markets via growth strategies. University is accredited by the Higher Learning Commission.</p>
                    </div>
                    <div class="testi-box_bottom">
                        <div class="testi-box_img">
                            <img src="{{ asset('public/bipebd/assets/img/testimonial/testi_3_1.jpg')}}" alt="Avater">
                        </div>
                        <div class="testi-box-author-details">
                            <h3 class="testi-box_name">Zara Head Milan</h3>
                            <span class="testi-box_desig">Regular Student</span>
                        </div>
                        <div class="testi-box_quote">
                            <img src="{{ asset('public/bipebd/assets/img/icon/testi-quote2.svg')}}" alt="quote">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="testi-box style3">
                    <div class="testi-box_review">
                        <i class="fa-solid fa-star-sharp"></i>
                        <i class="fa-solid fa-star-sharp"></i>
                        <i class="fa-solid fa-star-sharp"></i>
                        <i class="fa-solid fa-star-sharp"></i>
                        <i class="fa-solid fa-star-sharp"></i>
                        (4.7)
                    </div>
                    <div class="testi-box-bg-shape">
                        <svg width="78" height="111" viewBox="0 0 78 111" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 0L78 30V71C78 93.0914 60.0914 111 38 111H10C4.47715 111 0 106.523 0 101V0Z" fill="#0D5EF4" />
                        </svg>
                    </div>
                    <div class="testi-box_content">

                        <p class="testi-box_text">“Quickly maximize visionary solutions after mission critical action item productivity premium portals for impactful -services inactively negotiate enabled niche markets via growth strategies. University is accredited by the Higher Learning Commission.</p>
                    </div>
                    <div class="testi-box_bottom">
                        <div class="testi-box_img">
                            <img src="{{ asset('public/bipebd/assets/img/testimonial/testi_3_1.jpg')}}" alt="Avater">
                        </div>
                        <div class="testi-box-author-details">
                            <h3 class="testi-box_name">Zara Head Milan</h3>
                            <span class="testi-box_desig">Regular Student</span>
                        </div>
                        <div class="testi-box_quote">
                            <img src="{{ asset('public/bipebd/assets/img/icon/testi-quote2.svg')}}" alt="quote">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="testi-box style3">
                    <div class="testi-box_review">
                        <i class="fa-solid fa-star-sharp"></i>
                        <i class="fa-solid fa-star-sharp"></i>
                        <i class="fa-solid fa-star-sharp"></i>
                        <i class="fa-solid fa-star-sharp"></i>
                        <i class="fa-solid fa-star-sharp"></i>
                        (4.7)
                    </div>
                    <div class="testi-box-bg-shape">
                        <svg width="78" height="111" viewBox="0 0 78 111" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 0L78 30V71C78 93.0914 60.0914 111 38 111H10C4.47715 111 0 106.523 0 101V0Z" fill="#0D5EF4" />
                        </svg>
                    </div>
                    <div class="testi-box_content">

                        <p class="testi-box_text">“Quickly maximize visionary solutions after mission critical action item productivity premium portals for impactful -services inactively negotiate enabled niche markets via growth strategies. University is accredited by the Higher Learning Commission.</p>
                    </div>
                    <div class="testi-box_bottom">
                        <div class="testi-box_img">
                            <img src="{{ asset('public/bipebd/assets/img/testimonial/testi_3_1.jpg')}}" alt="Avater">
                        </div>
                        <div class="testi-box-author-details">
                            <h3 class="testi-box_name">Zara Head Milan</h3>
                            <span class="testi-box_desig">Regular Student</span>
                        </div>
                        <div class="testi-box_quote">
                            <img src="{{ asset('public/bipebd/assets/img/icon/testi-quote2.svg')}}" alt="quote">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="space-top py-0 py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="title-area mb-lg-0 text-lg-start text-center">
                    <span class="sub-title"><i class="fal fa-book me-2"></i> Our Trusted Partners</span>
                    <h2 class="sec-title mb-0">We Have More Than <span class="text-theme"><span class="counter-number">4263</span>+</span> Global Partners</h2>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="client-wrap text-lg-end text-center">
                    <div class="row gy-40">
                        <div class="col-3">
                            <a href="blog.html" class="client-thumb">
                                <img src="{{ asset('public/bipebd/assets/img/client/cilent_1_1.png') }}" alt="img">
                            </a>
                        </div>
                        <div class="col-3">
                            <a href="blog.html" class="client-thumb">
                                <img src="{{ asset('public/bipebd/assets/img/client/cilent_1_2.png') }}" alt="img">
                            </a>
                        </div>
                        <div class="col-3">
                            <a href="blog.html" class="client-thumb">
                                <img src="{{ asset('public/bipebd/assets/img/client/cilent_1_3.png') }}" alt="img">
                            </a>
                        </div>
                        <div class="col-3">
                            <a href="blog.html" class="client-thumb">
                                <img src="{{ asset('public/bipebd/assets/img/client/cilent_1_4.png') }}" alt="img">
                            </a>
                        </div>
                        <div class="col-3">
                            <a href="blog.html" class="client-thumb">
                                <img src="{{ asset('public/bipebd/assets/img/client/cilent_1_5.png') }}" alt="img">
                            </a>
                        </div>
                        <div class="col-3">
                            <a href="blog.html" class="client-thumb">
                                <img src="{{ asset('public/bipebd/assets/img/client/cilent_1_6.png') }}" alt="img">
                            </a>
                        </div>
                        <div class="col-3">
                            <a href="blog.html" class="client-thumb">
                                <img src="{{ asset('public/bipebd/assets/img/client/cilent_1_7.png') }}" alt="img">
                            </a>
                        </div>
                        <div class="col-3">
                            <a href="blog.html" class="client-thumb">
                                <img src="{{ asset('public/bipebd/assets/img/client/cilent_1_8.png') }}" alt="img">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
