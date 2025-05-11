@extends('frontend.shared.layouts.app')
@push('title')
    {{ __('admin_local.Course Details') }}
@endpush
@push('css')

<!-- Main css -->
<link rel="stylesheet" href="{{ asset('public/bipebd/edual/css/main.css') }}">
@endpush
@section('content')
<style>
    @media (min-width: 1300px) {
        .header-layout-default .menu-area {
            padding: 0px 30px 0px 10px !important;
        }
    }
    .main-menu ul.sub-menu {
        padding: 10px 6px;
        left: -27px;
        box-shadow: 0px 0px 3px rgb(140, 98, 255);
        margin-right: 20px;
        top: 60px;
    }
</style>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" style="margin-top: 90px;">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="btn-primary btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="youtube_player_body">

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary p-5" onclick="$('#youtube_player').attr('src','')" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>
@php
    $purchased_courses = Auth::user()->purchasedCourses(Auth::user()->id);
    $flag = 0;
    if(!empty($purchased_courses)&& in_array($course->id,$purchased_courses)){
        $flag=1;
    }
@endphp
<section class="space-top space-extra2-bottom">
    <div class="container">
        <div class="row">
            <div class="col-xxl-9 col-lg-8">
                <div class="course-single">
                    <div class="course-single-top">
                        <div class="course-img">
                            @php
                                $course_images = $course->course_images?explode(',',$course->course_images):asset('public/bipebd/assets/img/course/course_1_1.png');
                            @endphp
                            <img style="height:auto;" src="{{ asset($course->course_images?$course_images[0]:$course_images) }}" alt="Course Image">
                            @if ($course->course_discount>0)
                                <span class="tag mt-0"><i class="fas fa-clock"></i>{{ $course->course_discount_type=='Flat'?__('admin_local.Flat'):'' }} {{$course->course_discount}} {{ $course->course_discount_type=='Flat'?$course->course_price_currency:'%' }} {{ __('admin_local.Discount') }}</span>
                            @else

                            @endif
                        </div>
                        @if ($course->course_type=='Live')
                        @php
                            $inctructor = \App\Models\Admin\Course\CourseInstructor::with('instructor')->where([['course_id',$course->id]])->orderBy('id','DESC')->first();
                            $batches = \App\Models\Admin\Course\CourseBatch::where([['batch_status',1],['batch_delete',0],['course_id',$course->id]])->get();
                        @endphp
                        <div class="course-meta style2">
                            <span><i class="fal fa-file"></i>{{ __('admin_local.Batches') }} : {{ count($batches) }}</span>
                            <span><i class="fal fa-user"></i>{{ __('admin_local.Students') }} : {{ $course->enrolled_count??0 }}</span>
                            <span><i class="fal fa-chart-simple"></i>{{ $course->course_level }}</span>
                        </div>
                        @else
                        @php
                            $inctructor = \App\Models\Admin\Course\CourseInstructor::with('instructor')->where([['course_id',$course->id]])->orderBy('id','DESC')->first();
                            $videos = \App\Models\Admin\Course\CourseVideo::where([['video_status',1],['video_delete',0],['course_id',$course->id]])->get();
                        @endphp
                        <div class="course-meta style2">
                            <span><i class="fal fa-file"></i>{{ __('admin_local.Videos') }} : {{ count($videos) }}</span>
                            <span><i class="fal fa-user"></i>{{ __('admin_local.Enrolled') }} : {{ $course->enrolled_count??0 }}</span>
                            <span><i class="fal fa-chart-simple"></i>{{ $course->course_level }}</span>
                        </div>
                        @endif

                        <h2 class="course-title">{{ $course->course_name }}</h2>
                        <ul class="course-single-meta">
                            <li class="course-single-meta-author">
                                <img src="@if($inctructor->instructor->image) {{ asset($inctructor->instructor->image) }} @else {{ asset('public/bipebd/assets/img/course/author.png') }} @endif" alt="author">
                                <span>
                                    <span class="meta-title">{{ __('admin_local.Instructor') }}: </span>
                                    <a href="#">{{ $inctructor->instructor->name }}</a>
                                </span>
                            </li>
                            <li>
                                <span class="meta-title">{{ __('admin_local.Category') }}: </span>
                                <a href="#">{{ $course->category->category_name }}</a>
                            </li>
                            <li>
                                <span class="meta-title">{{ __('admin_local.Last Update') }}: </span>
                                <a href="course.html">{{ date('d-M-Y',strtotime($course->updated_at)) }}</a>
                            </li>
                            <li>
                                <span class="meta-title">Review: </span>
                                <div class="course-rating">
                                    <div class="star-rating" role="img" aria-label="Rated 4.00 out of 5">
                                        <span style="width:80%">Rated <strong class="rating">4.00</strong> out of 5</span>
                                    </div>
                                    (4.00)
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="course-single-bottom" style="box-shadow: 0px 0px 8px grey">
                        <ul class="nav course-tab" id="courseTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="description-tab" data-bs-toggle="tab" href="#Coursedescription" role="tab" aria-controls="Coursedescription" aria-selected="true"><i class="fa-regular fa-bookmark"></i>@if($course->course_type=='Pre-recorded') {{ __('admin_local.Course Content') }}@else {{ __('admin_local.Avaiable Batches') }}@endif</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="curriculam-tab" data-bs-toggle="tab" href="#curriculam" role="tab" aria-controls="curriculam" aria-selected="false"><i class="fa-regular fa-book"></i>Curriculam</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="instructor-tab" data-bs-toggle="tab" href="#instructor" role="tab" aria-controls="instructor" aria-selected="false"><i class="fa-regular fa-user"></i>Instructor</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="reviews-tab" data-bs-toggle="tab" href="#reviews" role="tab" aria-controls="reviews" aria-selected="false"><i class="fa-regular fa-star-sharp"></i>Reviews</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="productTabContent px-0" >
                            <div class="tab-pane fade show active" id="Coursedescription" role="tabpanel" aria-labelledby="description-tab" >
                                <div class="course-description px-2 mb-0 pb-0" >

                                        @if ($course->course_type=='Live')
                                        <div class="border border-neutral-30 rounded-12 bg-main-25 px-10 py-20" style="box-shadow: 0px 0px 10px lightgray">
                                            <div class="accordion common-accordion style-three" id="accordionExampleTwo">
                                                @php
                                                    $batches = \App\Models\Admin\Course\CourseBatch::with('instructor')->where([['batch_status',1],['batch_delete',0],['course_id',$course->id]])->whereDate('batch_start_date','>=',date('Y-m-d'))->get();
                                                @endphp
                                                @if (count($batches)>0)
                                                    @foreach ($batches as $key=>$batch)
                                                    <div class="accordion-item mb-5" style="border:1px solid #0d5ef4">
                                                        <h2 class="accordion-header p-0">
                                                            <button class="accordion-button {{ $key!=0?'collapsed':'' }} py-12" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOneTwo{{ $key."batch" }}" aria-expanded="{{ $key==0?'true':'false' }}" aria-controls="collapseOneTwo{{ $key."batch" }}">
                                                                {{  $batch->batch_name }}
                                                            </button>
                                                        </h2>
                                                        <div id="collapseOneTwo{{ $key."batch" }}" class="accordion-collapse collapse {{ $key==0?'show':'' }}" data-bs-parent="#accordionExampleTwo">
                                                            <div class="accordion-body p-0 px-0">
                                                                    <span class="curriculam-item flex-between text-neutral-500 fw-medium hover-text-main-600 py-5">
                                                                        <span class="flex-align gap-12">
                                                                            <a class="text-line-2" ><span>{{ __('admin_local.Instructor') }} : </span> {{ $batch->instructor->name }} , <span>{{ __('admin_local.Total Enroll') }} : </span>{{ $batch->enrolled_count }}/{!! $batch->enroll_limit>0?$batch->enroll_limit:'<span class="" style="color:black;font-size:18px;">&infin;</span>' !!}</a>
                                                                        </span>
                                                                    </span>
                                                                    <span class="curriculam-item flex-between text-neutral-500 fw-medium hover-text-main-600 py-5">
                                                                        <span class="flex-align gap-12">
                                                                            <a class="text-line-2" ><span>{{ __('admin_local.Batch Time') }} : </span> {{ date('d-M-Y',strtotime($batch->batch_start_date)) }} {{ __('admin_local.To') }} {{ date('d-M-Y',strtotime($batch->batch_end_date)) }} ( {{ ($batch->batch_day?$batch->batch_day." - ":'').date('h:i A',strtotime($batch->batch_time)) }} )</a>
                                                                        </span>
                                                                    </span>
                                                                    <span class="curriculam-item flex-between text-neutral-500 fw-medium hover-text-main-600 py-5">
                                                                        <span class="flex-align gap-12">
                                                                            <a class="text-line-2" ><span>{{ __('admin_local.Live In') }} : </span> {{ $batch->live_in }}</a>
                                                                        </span>
                                                                    </span>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    @endforeach
                                                @else
                                                    <h4 class="mx-auto text-center">{{ __('admin_local.No Batch Available Right Now') }}</h4>
                                                @endif

                                            </div>
                                        </div>
                                        @else
                                        <div class="border border-neutral-30 rounded-12 bg-main-25 px-10 py-20" style="box-shadow: 0px 0px 10px lightgray">
                                            <div class="accordion common-accordion style-three" id="accordionExampleTwo">

                                                <div class="accordion-item mb-5" style="border:1px solid #0d5ef4">
                                                    <h2 class="accordion-header p-0">
                                                        <button class="accordion-button py-12" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOneTwo" aria-expanded="true" aria-controls="collapseOneTwo">
                                                            {{ __('admin_local.Overview') }}
                                                        </button>
                                                    </h2>
                                                    <div id="collapseOneTwo" class="accordion-collapse collapse show" data-bs-parent="#accordionExampleTwo">
                                                        <div class="accordion-body p-0 px-0">
                                                            @php
                                                                $free_videos = \App\Models\Admin\Course\CourseVideo::where([['video_status',1],['video_delete',0],['video_type','Free'],['course_id',$course->id]])->get();
                                                            @endphp
                                                            @foreach ($free_videos as $key=>$free_video)
                                                                <span class="curriculam-item flex-between text-neutral-500 fw-medium hover-text-main-600">
                                                                    <span class="flex-align gap-12">
                                                                        <i class="text-xl d-flex ph-bold ph-video-camera"></i>
                                                                        <a data-video="{{ encrypt($free_video->id) }}" id="get_video_details" data-title="{{ $free_video->video_no }}. {{ $free_video->video_title }}" onclick="$('#exampleModalLabel').empty().append($(this).data('title'))" class="text-line-2" data-bs-keyboard="false" data-bs-backdrop="static" data-bs-toggle="modal" data-bs-target="#exampleModal">{{ $free_video->video_no }}. {{ $free_video->video_title }}</a>
                                                                    </span>

                                                                    <span class="flex-align gap-12 flex-shrink-0">
                                                                        {{ $free_video->video_duration }}
                                                                        <i class="text-xl d-flex ph-bold ph-lock-open"></i>
                                                                    </span>
                                                                </span>
                                                                @if ($free_video->videos_file)
                                                                <span class="ml-25" style="margin-top: -20px">
                                                                    <a target="__blank" href="{{ URL::to('/').'/'.$free_video->videos_file }}" class="btn btn-info p-5" style="font-size: 12px;">{{ __('admin_local.Download Video File') }}</a>
                                                                </span>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                                @php
                                                    $group_videos = \App\Models\Admin\Course\CourseVideo::where([['video_status',1],['video_delete',0],['course_id',$course->id]])->orderBy('video_no')->get()->groupBy('video_group');
                                                @endphp
                                                @foreach ($group_videos as  $group=>$group_video)
                                                    <div class="accordion-item mb-5">
                                                        <h2 class="accordion-header">
                                                        <button class="accordion-button collapsed py-12" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwoTwo{{ $group }}" aria-expanded="false" aria-controls="collapseTwoTwo{{ $group }}">
                                                            {{ $group }}
                                                        </button>
                                                        </h2>
                                                        <div id="collapseTwoTwo{{ $group }}" class="accordion-collapse collapse" data-bs-parent="#accordionExampleTwo">
                                                        <div class="accordion-body p-0">
                                                            @foreach ($group_video as $key=>$video)
                                                                <span class="curriculam-item flex-between text-neutral-500 fw-medium hover-text-main-600">
                                                                    <span class="flex-align gap-12">
                                                                        <i class="text-xl d-flex ph-bold ph-video-camera"></i>
                                                                        @if ($video->video_type=='Free' || $flag==1)

                                                                        <a data-video="{{ encrypt($video->id) }}" id="get_video_details" data-title="{{ $video->video_no }}. {{ $video->video_title }}" onclick="$('#exampleModalLabel').empty().append($(this).data('title'))" class="text-line-2" data-bs-keyboard="false" data-bs-backdrop="static" data-bs-toggle="modal" data-bs-target="#exampleModal">{{ $video->video_no }}. {{ $video->video_title }}</a>
                                                                        @else
                                                                        <span>{{ $video->video_no }}. {{ $video->video_title }}</span>
                                                                        @endif

                                                                    </span>

                                                                    <span class="flex-align gap-12 flex-shrink-0">
                                                                        {{ $video->video_duration }}
                                                                        @if ($video->video_type=='Free' || $flag==1)
                                                                        <i class="text-xl d-flex ph-bold ph-lock-open"></i>
                                                                        @else
                                                                        <i class="text-xl d-flex ph-bold ph-lock"></i>
                                                                        @endif
                                                                    </span>
                                                                </span>
                                                                @if ($video->videos_file)
                                                                    @if ($video->video_type=='Free' || $flag==1)
                                                                    <span class="ml-25" style="margin-top: -20px">
                                                                        <a target="__blank" href="{{ URL::to('/').'/'.$video->videos_file }}" class="btn btn-info p-5" style="font-size: 12px;">{{ __('admin_local.Download Video File') }}</a>
                                                                    </span>
                                                                    @else
                                                                    <span class="ml-25" style="margin-top: -20px">
                                                                        <a target="__blank" href="#" class="btn btn-info p-5" style="font-size: 12px;">{{ __('admin_local.Download Video File') }}</a>
                                                                    </span>
                                                                    @endif

                                                                @endif
                                                            @endforeach
                                                        </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        @endif
                                </div>
                            </div>
                            <div class="tab-pane fade" id="curriculam" role="tabpanel" aria-labelledby="curriculam-tab">
                                <div class="tab-pan-2">
                                    {{-- <h5 class="h5">The Course Curriculam</h5>
                                    <p class="mb-30">Grursus mal suada faci lisis Lorem ipsum dolarorit more ametion consectetur elit. Vesti at bulum nec odio aea the dumm ipsumm ipsum that dolocons rsus mal suada and fadolorit to the consectetur elit. All the Lorem Ipsum generators on the Internet tend to repeat that predefined chunks as necessary, making this the first true dummy generator on the Internet.</p>
                                    <div class="checklist mb-1">
                                        <ul>
                                            <li>How to use social media to reach local, national and international audiences</li>
                                            <li>How to set up and market events, using online tools, so you no longer depend</li>
                                            <li>How to create and run online shows, adapt your performance techniques and</li>
                                            <li>Mentoring and troubleshooting and post-training support from Jason</li>
                                            <li>How to use social media to reach local, national and international audiences</li>
                                            <li>How to set up and market events, using online tools</li>
                                            <li>Adapt your performance techniques and manage your audience throughout</li>
                                        </ul>
                                    </div> --}}
                                    {!! $course->course_details !!}
                                </div>
                            </div>
                            <div class="tab-pane fade" id="instructor" role="tabpanel" aria-labelledby="instructor-tab">
                                <div class="course-instructor">
                                    @if ($course->course_type=='Live')
                                        @php
                                            $batches = \App\Models\Admin\Course\CourseBatch::where([['batch_status',1],['batch_delete',0],['course_id',$course->id]])->whereDate('batch_start_date','>=',date('Y-m-d'))->select('batch_instructor')->distinct('batch_instructor')->get();
                                        @endphp
                                        @foreach ($batches as $batch)
                                        @php
                                            $instructor = \App\Models\Admin::where('id',$batch->batch_instructor)->first();
                                            $instructor_details = \App\Models\Admin\AdminProfileDetails::with('courses')->where('instructor_id',$batch->batch_instructor)->first();
                                        @endphp
                                        <div class="course-author-box">
                                            <div class="auhtor-img">
                                                <img src="@if($instructor->image) {{ asset($instructor->image) }} @else {{ asset('public/bipebd/assets/img/course/author.png') }} @endif" alt="Author Image">
                                            </div>
                                            <div class="media-body">
                                                    <h3 class="author-name"><a class="text-inherit" href="team-details.html"></a>{{ $instructor->name }}</h3>
                                                    <p class="author-text">{{ $instructor_details->designation }} , {{ $instructor_details->department }}</p>
                                                    <div class="author-meta">
                                                        <a href="course.html"><i class="fal fa-file-video"></i>{{ count($instructor_details->courses) }} {{ __("admin_local.Courses") }}</a>
                                                        {{-- <span><i class="fal fa-users"></i>2500 Students</span> --}}
                                                    </div>
                                                    <div class="th-social">
                                                        <a href="{{ $instructor_details->facebook }}" target="_blank"><i class="fab fa-facebook-f"></i></a>
                                                        <a href="{{ $instructor_details->twitter }}" target="_blank"><i class="fab fa-twitter"></i></a>
                                                        <a href="{{ $instructor_details->linkedin }}" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                                                    </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    @else
                                    <div class="course-author-box">
                                        <div class="auhtor-img">
                                            <img src="@if($inctructor->instructor->image) {{ asset($inctructor->instructor->image) }} @else {{ asset('public/bipebd/assets/img/course/author.png') }} @endif" alt="Author Image">
                                        </div>
                                        <div class="media-body">
                                            @php
                                                $instructor_details = \App\Models\Admin\AdminProfileDetails::with('courses')->where('instructor_id',$inctructor->instructor->id)->first();
                                            @endphp
                                                <h3 class="author-name"><a class="text-inherit" href="team-details.html"></a>{{ $inctructor->instructor->name }}</h3>
                                                <p class="author-text">{{ $instructor_details->designation }} , {{ $instructor_details->department }}</p>
                                                <div class="author-meta">
                                                    <a href="course.html"><i class="fal fa-file-video"></i>{{ count($instructor_details->courses) }} {{ __("admin_local.Courses") }}</a>
                                                    {{-- <span><i class="fal fa-users"></i>2500 Students</span> --}}
                                                </div>
                                                <div class="th-social">
                                                    <a href="{{ $instructor_details->facebook }}" target="_blank"><i class="fab fa-facebook-f"></i></a>
                                                    <a href="{{ $instructor_details->twitter }}" target="_blank"><i class="fab fa-twitter"></i></a>
                                                    <a href="{{ $instructor_details->linkedin }}" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                                                </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                                <div class="course-Reviews">
                                    <div class="th-comments-wrap ">
                                        <ul class="comment-list">
                                            <li class="review th-comment-item">
                                                <div class="th-post-comment">
                                                    <div class="comment-avater">
                                                        <img src="assets/img/blog/comment-author-3.jpg" alt="Comment Author">
                                                    </div>
                                                    <div class="comment-content">
                                                        <h4 class="name">Mark Jack</h4>
                                                        <span class="commented-on"><i class="fal fa-calendar-alt"></i>22 April, 2022</span>
                                                        <div class="star-rating" role="img" aria-label="Rated 5.00 out of 5">
                                                            <span style="width:100%">Rated <strong class="rating">5.00</strong> out of 5 based on <span class="rating">1</span> customer rating</span>
                                                        </div>
                                                        <p class="text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco</p>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="review th-comment-item">
                                                <div class="th-post-comment">
                                                    <div class="comment-avater">
                                                        <img src="assets/img/blog/comment-author-2.jpg" alt="Comment Author">
                                                    </div>
                                                    <div class="comment-content">
                                                        <h4 class="name">Alexa Deo</h4>
                                                        <span class="commented-on"><i class="fal fa-calendar-alt"></i>26 April, 2022</span>
                                                        <div class="star-rating" role="img" aria-label="Rated 5.00 out of 5">
                                                            <span style="width:100%">Rated <strong class="rating">5.00</strong> out of 5 based on <span class="rating">1</span> customer rating</span>
                                                        </div>
                                                        <p class="text">The purpose of lorem ipsum is to create a natural looking block of text (sentence, paragraph, page, etc.) that doesn't distract from the layout. A practice not without controversy, laying out pages.</p>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="review th-comment-item">
                                                <div class="th-post-comment">
                                                    <div class="comment-avater">
                                                        <img src="assets/img/blog/comment-author-1.jpg" alt="Comment Author">
                                                    </div>
                                                    <div class="comment-content">
                                                        <h4 class="name">Tara sing</h4>
                                                        <span class="commented-on"><i class="fal fa-calendar-alt"></i>26 April, 2022</span>
                                                        <div class="star-rating" role="img" aria-label="Rated 5.00 out of 5">
                                                            <span style="width:100%">Rated <strong class="rating">5.00</strong> out of 5 based on <span class="rating">1</span> customer rating</span>
                                                        </div>
                                                        <p class="text">The passage experienced a surge in popularity during the 1960s when Letraset used it on their dry-transfer sheets, and again during the 90s as desktop publishers bundled the text with their software.</p>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div> <!-- Comment Form -->
                                    <div class="th-comment-form ">
                                        <div class="form-title">
                                            <h3 class="blog-inner-title ">Add a review</h3>
                                        </div>
                                        <div class="row">
                                            <div class="form-group rating-select d-flex align-items-center">
                                                <label>Your Rating</label>
                                                <p class="stars">
                                                    <span>
                                                        <a class="star-1" href="#">1</a>
                                                        <a class="star-2" href="#">2</a>
                                                        <a class="star-3" href="#">3</a>
                                                        <a class="star-4" href="#">4</a>
                                                        <a class="star-5" href="#">5</a>
                                                    </span>
                                                </p>
                                            </div>
                                            <div class="col-12 form-group">
                                                <textarea placeholder="Write a Message" class="form-control"></textarea>
                                                <i class="text-title far fa-pencil-alt"></i>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <input type="text" placeholder="Your Name" class="form-control">
                                                <i class="text-title far fa-user"></i>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <input type="text" placeholder="Your Email" class="form-control">
                                                <i class="text-title far fa-envelope"></i>
                                            </div>
                                            <div class="col-12 form-group">
                                                <input id="reviewcheck" name="reviewcheck" type="checkbox">
                                                <label for="reviewcheck">Save my name, email, and website in this browser for the next time I comment.<span class="checkmark"></span></label>
                                            </div>
                                            <div class="col-12 form-group mb-0">
                                                <button class="th-btn">Post Review <i class="far fa-arrow-right ms-1"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-lg-4">
                <aside class="sidebar-area">
                    <div class="widget widget_info px-2">
                        <span>{{ $course->course_name }}</span>
                        <span class="h4 course-price">@if($course->course_discount>0) <strike>{{ $course->course_price }}</strike> {{ $course->course_discount_price }} {{ $course->course_price_currency }} @else {{ $course->course_price }} {{ $course->course_price_currency }} @endif<span class="tag">{{ $course->course_discount_type=='Flat'?__('admin_local.Flat'):'' }} {{$course->course_discount}} {{ $course->course_discount_type=='Flat'?$course->course_price_currency:'%' }} {{ __('admin_local.Discount') }}</span></span>
                        @if($flag!=1)
                        <a href="{{ route('frontend.course.addCart',$course->course_name_slug) }}" class="th-btn py-10">{{ __('admin_local.Add To Cart') }}</a>
                        <a href="cart.html" class="th-btn style4 py-10">{{ __("admin_local.Buy Now") }}</a>
                        @endif
                        <h3 class="widget_title">{{ __('admin_local.Course Information') }}</h3>
                        <div class="info-list">
                            <ul>
                                @if ($course->course_type=='Live')
                                @php
                                    $inctructor = \App\Models\Admin\Course\CourseInstructor::with('instructor')->where([['course_id',$course->id]])->orderBy('id','DESC')->first();
                                    $batches = \App\Models\Admin\Course\CourseBatch::where([['batch_status',1],['batch_delete',0],['course_id',$course->id]])->get();
                                @endphp
                                    <li>
                                        <i class="fa-light fa-user"></i>
                                        <strong>{{ __('admin_local.Batches') }}: </strong>
                                        <span>{{ count($batches) }}</span>
                                    </li>
                                    <li>
                                        <i class="fa-light fa-user"></i>
                                        <strong>{{ __('admin_local.Students') }}: </strong>
                                        <span>{{ $course->enrolled_count??0 }}</span>
                                    </li>
                                    <li>
                                        <i class="fa-light fa-tag"></i>
                                        <strong>{{ __('admin_local.Course level') }}: </strong>
                                        <span>{{ $course->course_level }}</span>
                                    </li>
                                @else
                                @php
                                    $instructor = \App\Models\Admin\Course\CourseInstructor::with('instructor')->where([['course_id',$course->id]])->orderBy('id','DESC')->first();
                                    $videos = \App\Models\Admin\Course\CourseVideo::where([['video_status',1],['video_delete',0],['course_id',$course->id]])->get();
                                @endphp
                                <li>
                                    <i class="fa-light fa-user"></i>
                                    <strong>{{ __('admin_local.Instructor') }}: </strong>
                                    <span>{{ $instructor->instructor->name }}</span>
                                </li>
                                <li>
                                    <i class="fa-light fa-file"></i>
                                    <strong>{{ __('admin_local.Videos') }}: </strong>
                                    <span>{{ count($videos) }}</span>
                                </li>
                                <li>
                                    <i class="fa-light fa-clock"></i>
                                    <strong>{{ __('admin_local.Enrolled') }}: </strong>
                                    <span>{{ $course->enrolled_count??0 }}</span>
                                </li>
                                <li>
                                    <i class="fa-light fa-tag"></i>
                                    <strong>{{ __('admin_local.Course level') }}: </strong>
                                    <span>{{ $course->course_level }}</span>
                                </li>
                                {{-- <li>
                                    <i class="fa-light fa-globe"></i>
                                    <strong>Language: </strong>
                                    <span>English</span>
                                </li>
                                <li>
                                    <i class="fa-light fa-puzzle-piece"></i>
                                    <strong>Quizzes: </strong>
                                    <span>04</span>
                                </li> --}}
                                @endif

                            </ul>
                        </div>
                        {{-- <a href="https://www.linkedin.com/" class="th-btn style6 mt-35 mb-0"><i class="far fa-share-nodes me-2"></i>Share This Course</a> --}}
                    </div>
                </aside>
                <aside>
                    <div class="container">
                        <div class="title-area text-center px-0 py-0 mx-0">
                            <span class="sub-title"><i class="fal fa-book me-2 my-0 py-0"></i> {{ __('admin_local.Related Courses') }}</span>
                            {{-- <h5 class="sec-title my-0 py-0">{{ __('admin_local.Courses You May Like') }}</h5> --}}
                        </div>
                        <div class="mx-0 row slider-shadow th-carousel course-slider-1" data-slide-show="1" data-ml-slide-show="1" data-lg-slide-show="1" data-md-slide-show="1" data-sm-slide-show="1" data-arrows="true">
                            @php
                                $courses = \App\Models\Admin\Course\Course::where([['course_status',1],['course_delete',0],['category_id',$course->category_id],['id','!=',$course->id]])->orderBy('id','DESC')->get();
                            @endphp
                            @foreach ($courses as $c=>$course)
                            @php
                                $course_images = $course->course_images?explode(',',$course->course_images):asset('public/bipebd/assets/img/course/course_1_1.png');
                            @endphp
                            <div class="col-md-6 col-xl-4">
                                <div class="course-box style2">
                                    <a href="{{ route('frontend.courses.single',$course->course_name_slug) }}" style="color:black">
                                        <div class="course-img" style="height: 250px;">
                                            <img src="{{ asset($course->course_images?$course_images[0]:$course_images) }}" alt="img">
                                            @if ($course->course_discount>0)
                                            <span class="tag py-1"><i class="fas fa-clock"></i>{{ $course->course_discount_type=='Flat'?__('admin_local.Flat'):'' }} {{$course->course_discount}} {{ $course->course_discount_type=='Flat'?$course->course_price_currency:'%' }} {{ __('admin_local.Discount') }}</span>
                                            @else

                                            @endif
                                        </div>
                                        <div class="course-content text-center px-4" >
                                            <h4 class="course-title text-center my-0" style="font-size: 18px;">{{ $course->course_name }}</h4>
                                            @if ($course->course_discount>0)
                                            <span style="font-size:14px">
                                                <strike class="text-danger">{{ $course->course_price }} {{ $course->course_price_currency }}</strike> {{ $course->course_discount_price }} {{ $course->course_price_currency }}
                                            </span>

                                            @else
                                            <span style="font-size:14px">
                                                {{ $course->course_price }} {{ $course->course_price_currency }}
                                            </span>

                                            @endif
                                            <div class="course-author">
                                                <a class="btn btn-primary mx-auto mt-0 p-1 px-5 py-5" style="font-size: 15px;text-align: center">{{ __('admin_local.Enroll Now') }}</a>
                                            </div>
                                            <div class="course-author" style="border-top: 1px dashed grey">

                                                @if ($course->course_type=='Live')
                                                @php
                                                    $inctructor = \App\Models\Admin\Course\CourseInstructor::with('instructor')->where([['course_id',$course->id]])->orderBy('id','DESC')->first();
                                                @endphp
                                                <div class="author-info">
                                                    <img src="@if($inctructor->instructor->image) {{ asset($inctructor->instructor->image) }} @else {{ asset('public/bipebd/assets/img/course/author.png') }} @endif" alt="author">
                                                    <a href="#" class="author-name" style="font-size:14px">{{ $inctructor->instructor->name }}</a>
                                                </div>
                                                <div class="offer-tag bg-danger text-white px-4" style="border-radius: 6px;font-size:10px;">{{ __('admin_local.Live') }}</div>
                                                @else
                                                @php
                                                    $inctructor = \App\Models\Admin\Course\CourseInstructor::with('instructor')->where([['course_id',$course->id]])->orderBy('id','DESC')->first();
                                                @endphp
                                                <div class="author-info">
                                                    <img src="@if($inctructor->instructor->image) {{ asset($inctructor->instructor->image) }} @else {{ asset('public/bipebd/assets/img/course/author.png') }} @endif" alt="author">
                                                    <a href="#" class="author-name" style="font-size:14px">{{ $inctructor->instructor->name }}</a>

                                                </div>
                                                <div class="offer-tag bg-success text-white px-4" style="border-radius: 6px;font-size:10px;">{{ __('admin_local.Pre-recorded') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </a>

                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </aside>

            </div>
        </div>
    </div>
</section>
@endsection
@push('js')
<script src="{{ asset('public/bipebd/edual/js/phosphor-icon.js') }}"></script>
{{-- <script src="{{ asset('public/bipebd/edual/js/main.js') }}"></script> --}}


@endpush
@section('custom_js')
<script src="{{ asset('public/bipebd/custom/js/course_details.js') }}"></script>
@endsection
