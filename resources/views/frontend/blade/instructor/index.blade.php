@extends('frontend.shared.layouts.app')
@push('title')
    {{ __('admin_local.Instructors') }}
@endpush

@section('content')

    <div class="team-area overflow-hidden space">
        <div class="container">
            <div class="title-area text-center">
                <span class="sub-title"><i class="fal fa-book me-2"></i>{{ __('admin_local.Our Instructors') }}</span>
                <h2 class="sec-title">{{ __('admin_local.Meet our expart instructors') }}</h2>
            </div>
            <div class="row align-items-center gy-4">
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
                <div class="col-sm-6 col-lg-4 col-xl-3">
                    <div class="team-card style3">
                        <div class="team-img-wrap">
                            <div class="team-img">
                                <img src="{{ asset($instructor->image?$instructor->image:'public/bipebd/assets/img/team/team_2_1.jpg')}}" alt="Team">
                            </div>
                        </div>
                        <div class="team-hover-wrap">
                            <div class="team-social">
                                <a href="#" class="icon-btn">
                                    <i class="far fa-plus"></i>
                                </a>
                                <div class="th-social">
                                    <a target="_blank" href="{{ $instructor_prof?$instructor_prof->twitter:'' }}"><i class="fab fa-twitter"></i></a>
                                    <a target="_blank" href="{{ $instructor_prof?$instructor_prof->facebook:'' }}"><i class="fab fa-facebook-f"></i></a>
                                    <a target="_blank" href="{{ $instructor_prof?$instructor_prof->linkedin:'' }}"><i class="fab fa-linkedin"></i></a>
                                </div>
                            </div>
                            <div class="team-content">
                                <h3 class="team-title"><a href="#">{{ $instructor->name }}</a></h3>
                                <span class="team-desig"><strong>{{ $instructor_prof?$instructor_prof->designation:'' }}</strong></span>
                                <span><strong>{{ $instructor_prof?$instructor_prof->department:'' }}</strong></span>
                            </div>
                            {{-- <div class="team-info">
                                <span><i class="fal fa-file-check"></i>2 Courses</span>
                                <span><i class="fa-light fa-users"></i>Students 60+</span>
                            </div> --}}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

@endsection
