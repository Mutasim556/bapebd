@extends('frontend.shared.layouts.app')
@push('title')
    {{ __('admin_local.My Profile') }}
@endpush

@section('content')

<section class="space-top space-extra2-bottom mt-5">
    <div class="container">
        <div class="row">
            <div class="col-xl-3 col-lg-4 order-lg-1">
                <aside class="sidebar-area sidebar-shop">
                    <div class="widget widget_categories style2  bg-info">
                        <h3 class="widget_title text-center">{{ __('admin_local.Profile Details') }}</h3>
                        <ul>
                            <li><label for="freecheck">{{ __('admin_local.Name') }} : <span class="checkmark">{{ Auth::user()->name }}</span></label>
                            </li>
                            <li><label for="freecheck">{{ __('admin_local.Email') }} : <span class="checkmark">{{ Auth::user()->email??'' }}</span></label>
                            </li>
                            <li><label for="freecheck">{{ __('admin_local.Phone') }} : <span class="checkmark">{{ Auth::user()->phone??'' }}</span></label>
                            </li>
                        </ul>
                    </div>
                </aside>
            </div>
            <div class="col-xl-9 col-lg-8 order-lg-2">
                <div class="row gy-30">
                    <h3 class="widget_title text-center">{{ __('admin_local.Purchase History') }}</h3>
                    @if (count($purchase_courses)>0)
                        @foreach ($purchase_courses as $purchase_course)
                        <div class="col-12">
                            <div class="course-grid">
                                <div class="course-img">
                                    @php
                                        $course_images = $purchase_course->course->course_images?explode(',',$purchase_course->course->course_images):asset('public/bipebd/assets/img/course/course_1_1.png');
                                    @endphp
                                    <img src="{{ $purchase_course->course->course_images?$course_images[0]:$course_images }}" alt="img">
                                    {{-- <span class="tag"><i class="fas fa-clock"></i> 03 WEEKS</span> --}}
                                </div>
                                <div class="course-content">


                                    <h3 class="course-title"><a href="{{ route('frontend.courses.single',$purchase_course->course->course_name_slug) }}">{{ $purchase_course->course->course_name }}</a></h3>
                                    <p class="course-text">
                                        {!! \Illuminate\Support\Str::limit(strip_tags($purchase_course->course->course_details), 100, '...') !!}
                                    </p>
                                    @if ($purchase_course->course->course_type=='Live')
                                    @php
                                        $inctructor = \App\Models\Admin\Course\CourseInstructor::with('instructor')->where([['course_id',$purchase_course->course->id]])->orderBy('id','DESC')->first();
                                        $batches = \App\Models\Admin\Course\CourseBatch::where([['batch_status',1],['batch_delete',0],['course_id',$purchase_course->course->id]])->get();
                                    @endphp
                                        <div class="course-meta text-primary">
                                            <span><i class="fal fa-file"></i>{{ __('admin_local.Batches') }} : {{ count($batches) }}</span>
                                            <span><i class="fal fa-user"></i>{{ __('admin_local.Students') }} : {{ $purchase_course->course->enrolled_count??0 }}</span>
                                            <span><i class="fal fa-chart-simple"></i>{{ $purchase_course->course->course_level }}</span>
                                        </div>
                                        <div class="course-author">
                                            <div class="author-info">
                                                <img src="@if($inctructor->instructor->image) {{ $inctructor->instructor->image }} @else public/bipebd/assets/img/course/author.png @endif" alt="author">
                                                <a href="#" class="author-name">{{ $inctructor->instructor->name }}</a>
                                            </div>
                                            <div class="offer-tag bg-danger text-white px-2" style="border-radius: 6px;font-size:11px;">{{ __('admin_local.Live') }}</div>
                                        </div>
                                    @else
                                    @php
                                        $inctructor = \App\Models\Admin\Course\CourseInstructor::with('instructor')->where([['course_id',$purchase_course->course->id]])->orderBy('id','DESC')->first();
                                        $videos = \App\Models\Admin\Course\CourseVideo::where([['video_status',1],['video_delete',0],['course_id',$purchase_course->course->id]])->get();
                                    @endphp
                                        <div class="course-meta">
                                            <span><i class="fal fa-file"></i>{{ __('admin_local.Videos') }} : {{ count($videos) }}</span>
                                            <span><i class="fal fa-user"></i>{{ __('admin_local.Enrolled') }} : {{ $purchase_course->course->enrolled_count??0 }}</span>
                                            <span><i class="fal fa-chart-simple"></i>{{ $purchase_course->course->course_level }}</span>
                                        </div>
                                        <div class="course-author">
                                            <div class="author-info">
                                                <img src="@if($inctructor->instructor->image) {{ $inctructor->instructor->image }} @else public/bipebd/assets/img/course/author.png @endif" alt="author">
                                                <a href="#" class="author-name">{{ $inctructor->instructor->name }}</a>
                                            </div>
                                            <div class="offer-tag bg-success text-white px-2" style="border-radius: 6px;font-size:11px;">{{ __('admin_local.Pre-recorded') }}</div>
                                        </div>
                                    @endif
                                    {{-- <div class="course-author">
                                        <div class="author-info">
                                            <img src="assets/img/course/author.png" alt="author">
                                            <a href="course.html" class="author-name">Max Alexix</a>
                                        </div>
                                        <a href="course-details.html" class="link-btn">View Details<i class="fas fa-arrow-right ms-2"></i></a>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="col-12 bg-warning pt-4 pb-3 text-center rounded">
                            <h5>{{ __('admin_lcoal.No purchase history found') }}</h5>
                        </div>
                    @endif

                </div>
            </div>
        </div>

    </div>
</section>

@endsection
