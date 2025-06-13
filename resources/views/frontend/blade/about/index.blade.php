@extends('frontend.shared.layouts.app')
@push('title')
    {{ __('admin_local.About BipeBD') }}
@endpush

@section('content')

<section class="overflow-hidden space">
    <div class="container">
        <div class="title-area text-center">
            <span class="sub-title"><i class="fal fa-book me-2"></i>{{ __('admin_local.What We Do') }}</span>
            <h2 class="sec-title">{{ __('admin_local.Online Education Tailored to You') }}</h2>
        </div>
        <div class="row gy-4 justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="service-card style3">
                    <div class="service-card-content">
                        <div class="service-card-icon">
                            <img src="{{ asset('public/bipebd/assets/img/icon/service-icon-3-1.svg') }}" alt="Icon">
                        </div>
                        <h3 class="box-title">{{ __('admin_local.Learn From Anywhere') }}</h3>
                        <p class="service-card-text">{{ __('admin_local.Learn From Anywhere empowers you to access quality education anytime, from any location. With flexible online tools, learning becomes convenient and personalized.') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="service-card style3">
                    <div class="service-card-content">
                        <div class="service-card-icon">
                            <img src="{{ asset('public/bipebd/assets/img/icon/service-icon-3-2.svg') }}" alt="Icon">
                        </div>
                        <h3 class="box-title">{{ __('admin_local.Expert Instructor') }}</h3>
                        <p class="service-card-text">{{ __('admin_local.Expert Instructors bring deep knowledge and real-world experience to every lesson. They guide learners with practical insights and personalized support.') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="service-card style3">
                    <div class="service-card-content">
                        <div class="service-card-icon">
                            <img src="{{ asset('public/bipebd/assets/img/icon/service-icon-3-3.svg') }}" alt="Icon">
                        </div>
                        <h3 class="box-title">{{ __('admin_local.24/7 Live Support') }}</h3>
                        <p class="service-card-text">{{ __('admin_local.24/7 Live Support ensures help is always available, no matter the time or day. Get instant assistance to keep your learning smooth and uninterrupted.') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

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
                        <span class="sub-title"><i class="fal fa-book me-2"></i>{{ __('admin_local.About BipeBD') }}</span>
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
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
