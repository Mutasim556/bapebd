@extends('frontend.shared.layouts.app')
@push('title')
    {{ __('admin_local.All Courses') }}
@endpush
@section('content')
<style>
    input[type="checkbox"] {
            width: 20px;
            height: 20px;
            appearance: none;
            -webkit-appearance: none;
            background-color: #e0e0e0;
            border: 1px solid #ccc;
            border-radius: 3px;
            cursor: pointer;
            position: relative;
        }

        input[type="checkbox"]:checked {
            background-color: #4CAF50;
            border: 1px solid #4CAF50;
        }

        input[type="checkbox"]:checked::after {
            content: "";
            position: absolute;
            left: 5px;
            top: 1px;
            width: 6px;
            height: 12px;
            border-width: 0 3px 3px 0;
            transform: rotate(45deg);
        }
</style>
<section class="space-top space-extra2-bottom">
    <div class="container">
        <div class="row pb-5">
            <div class="col-xl-9 col-lg-8 order-lg-2">
                <div class="container mb-4 @if($url_slug['categories']=='') d-none @endif">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-lg-8">
                            <div class="title-area text-lg-start text-center py-0 my-0">
                                <span class="sub-title"><i class="fal fa-book me-2"></i> Our Course Categories</span>
                            </div>
                        </div>
                    </div>
                    <div class="row gy-4">
                        @if ($url_slug['categories']!='')
                            @foreach ($url_slug['categories'] as $acategory)
                            <div class="col-lg-6 col-xl-6 col-md-6">
                                <div class="category-list">
                                    <div class="category-list_icon">
                                        <img src="@if($acategory->category_image) {{ asset($acategory->category_image) }} @else {{ asset('public/bipebd/assets/img/icon/category_2_1.svg') }} @endif " alt="icon">
                                    </div>
                                    <div class="category-list_content">
                                        <h3 class="category-list_title"><a href="{{ route('frontend.courses.getAllCourses',['category',$acategory->category_slug]) }}">{{ $acategory->category_name }}</a></h3>
                                        <span class="category-list_text">{{ count($acategory->courses) }} {{ __('admin_local.Courses') }}</span>
                                        <a href="course.html" class="icon-btn"><i class="fas fa-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @endif
                        
                    </div>
                </div>
                <div class="th-sort-bar course-sort-bar">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-md">
                            <p class="woocommerce-result-count">{{ __("admin_local.Showing") }} {{ count($courses) }} {{ __('admin_local.Results') }}</p>
                        </div>

                        <div class="col-md-auto">
                            <div class="nav" role=tablist>
                                <a class="active" href="#" id="tab-shop-list" data-bs-toggle="tab" data-bs-target="#tab-list" role="tab" aria-controls="tab-grid" aria-selected="false"><i class="fa-solid fa-grid-2 me-2"></i>Grid</a>
                                <a href="#" id="tab-shop-grid" data-bs-toggle="tab" data-bs-target="#tab-grid" role="tab" aria-controls="tab-grid" aria-selected="true"><i class="fa-solid fa-list me-2"></i>List</a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade" id="tab-grid" role="tabpanel" aria-labelledby="tab-shop-grid">
                        <div class="row gy-30">
                            @foreach ($courses as $course)
                            @php
                                $course_images = $course->course_images?explode(',',$course->course_images):asset('public/bipebd/assets/img/course/course_1_1.png');
                            @endphp
                            <div class="col-12">
                                <div class="course-grid">
                                    <div class="course-img">
                                        <img src="{{ asset($course->course_images?$course_images[0]:$course_images) }}" alt="img">
                                        @if ($course->course_discount>0)
                                            <span class="tag mt-0"><i class="fas fa-clock"></i>{{ $course->course_discount_type=='Flat'?__('admin_local.Flat'):'' }} {{$course->course_discount}} {{ $course->course_discount_type=='Flat'?$course->course_price_currency:'%' }} {{ __('admin_local.Discount') }}</span>
                                        @else
                                            
                                        @endif
                                    </div>
                                    <div class="course-content" style="width: 100%">
                                        <div class="d-flex justify-content-between">
                                            @if ($course->course_type=='Live')
                                            @php
                                                $inctructor = \App\Models\Admin\Course\CourseInstructor::with('instructor')->where([['course_id',$course->id]])->orderBy('id','DESC')->first();
                                                $batches = \App\Models\Admin\Course\CourseBatch::where([['batch_status',1],['batch_delete',0],['course_id',$course->id]])->get();
                                            @endphp
                                            <div class="offer-tag bg-danger text-white px-2" style="border-radius: 6px;font-size:10px;">{{ __('admin_local.Live') }}</div>
                                            @else
                                            @php
                                                $inctructor = \App\Models\Admin\Course\CourseInstructor::with('instructor')->where([['course_id',$course->id]])->orderBy('id','DESC')->first();
                                                $videos = \App\Models\Admin\Course\CourseVideo::where([['video_status',1],['video_delete',0]])->get();
                                            @endphp
                                            <div class="offer-tag bg-success text-white px-2" style="border-radius: 6px;font-size:10px;">{{ __('admin_local.Pre-recorded') }}</div>
                                            @endif
                                        </div>

                                        <h3 class="course-title"><a href="{{ route('frontend.courses.single',$course->course_name_slug) }}">{{ $course->course_name }}</a></h3>
                                       
                                        @if ($course->course_discount>0)
                                        <span></span>
                                        <div class="course-meta mb-0">
                                            <span class="text-success mx-auto" style="font-size: 15px;text-align: center"><Strong>{{ __('admin_local.Price') }}</Strong> : <strike class="text-danger">{{ $course->course_price }} {{ $course->course_price_currency }}</strike> {{ $course->course_discount_price }} {{ $course->course_price_currency }}</span>
                                            {{-- <span class="text-success" style="font-size: 13px"><Strong>{{ __('admin_local.Descounted Price') }}</Strong> : {{ $course->course_discount_price }} {{ $course->course_price_currency }}</span> --}}
                                            
                                        </div>
                                        
                                        @else
                                            <span class="text-success mx-auto" style="font-size: 15px;text-align: center"><Strong>{{ __('admin_local.Price') }}</Strong> : {{ $course->course_price }} {{ $course->course_price_currency }}</span>
                                        @endif
                                        <div class="course-meta py-1 my-0" style="float: right;">
                                            <a class="btn btn-primary mt-0 p-1 px-2 mx-3" style="font-size: 15px;text-align: center;float:left">{{ __('admin_local.Enroll Now') }}</a>
                                            <a class="btn btn-info mt-0 p-1 px-2" style="font-size: 15px;text-align: center;float:left">{{ __('admin_local.Add Cart') }}</a>
                                        </div>
                                        <br><br>
                                        @if ($course->course_type=='Live')
                                        <div class="course-meta text-primary ">
                                            <span><i class="fal fa-file"></i>{{ __('admin_local.Batches') }} : {{ count($batches) }}</span>
                                            <span><i class="fal fa-user"></i>{{ __('admin_local.Students') }} : {{ $course->enrolled_count }}</span>
                                            <span><i class="fal fa-chart-simple"></i>{{ $course->course_level }}</span>
                                        </div>
                                        @else
                                        <div class="course-meta">
                                            <span><i class="fal fa-file"></i>{{ __('admin_local.Videos') }} : {{ count($videos) }}</span>
                                            <span><i class="fal fa-user"></i>{{ __('admin_local.Enrolled') }} : {{ $course->enrolled_count }}</span>
                                            <span><i class="fal fa-chart-simple"></i>{{ $course->course_level }}</span>
                                        </div>
                                        @endif
                                        
                                        <div class="course-author">
                                            @if ($course->course_type=='Live')
                                            <div class="author-info">
                                                <img src="@if($inctructor->instructor->image) {{ asset($inctructor->instructor->image) }} @else {{ asset('public/bipebd/assets/img/course/author.png') }} @endif" alt="author">
                                                <a href="{{ route('frontend.courses.single',$course->course_name_slug) }}" class="author-name">{{ $inctructor->instructor->name }}</a>
                                            </div>
                                            @else
                                            <div class="author-info">
                                                <img src="@if($inctructor->instructor->image) {{ asset($inctructor->instructor->image) }} @else {{ asset('public/bipebd/assets/img/course/author.png') }} @endif" alt="author">
                                                <a href="course.html" class="author-name">{{ $inctructor->instructor->name }}</a>
                                            </div>
                                            @endif
                                            <a href="course-details.html" class="link-btn">View Details<i class="fas fa-arrow-right ms-2"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="tab-pane fade active show" id="tab-list" role="tabpanel" aria-labelledby="tab-shop-list">
                        <div class="row gy-30">
                            @foreach ($courses as $course)
                            @php
                                $course_images = $course->course_images?explode(',',$course->course_images):asset('public/bipebd/assets/img/course/course_1_1.png');
                            @endphp
                            <div class="col-md-6 col-xl-4">
                                <div class="course-box style2">
                                    <div class="course-img">
                                        <img src="{{ asset($course->course_images?$course_images[0]:$course_images) }}" alt="img">
                                        @if ($course->course_discount>0)
                                            <span class="tag mt-0"><i class="fas fa-clock"></i>{{ $course->course_discount_type=='Flat'?__('admin_local.Flat'):'' }} {{$course->course_discount}} {{ $course->course_discount_type=='Flat'?$course->course_price_currency:'%' }} {{ __('admin_local.Discount') }}</span>
                                        @else
                                            
                                        @endif
                                    </div>
                                    <div class="course-content px-2">
                                        <div class="course-rating" style="height: 40px;text-align:center;width:100%">
                                            <h3 class="course-title mx-auto px-0 mx-0" style="text-align:center;"><a href="{{ route('frontend.courses.single',$course->course_name_slug) }}" style="font-size: 16px;text-align:center;">{{ $course->course_name }}</a></h3>
                                        </div>
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
                                            <a class="btn btn-primary mx-auto mt-0 p-1 px-2" style="font-size: 15px;text-align: center">{{ __('admin_local.Enroll Now') }}</a>
                                            <button data-course_slug="{{ $course->course_name_slug }}" id="add_cart" class="btn btn-info mx-auto mt-0 p-1 px-2" style="font-size: 15px;text-align: center">{{ __('admin_local.Add Cart') }}</button>
                                        </div>
                                        @if ($course->course_type=='Live')
                                        @php
                                            $inctructor = \App\Models\Admin\Course\CourseInstructor::with('instructor')->where([['course_id',$course->id]])->orderBy('id','DESC')->first();
                                            $batches = \App\Models\Admin\Course\CourseBatch::where([['batch_status',1],['batch_delete',0]])->get();
                                        @endphp
                                            <div class="course-meta text-primary">
                                                <span><i class="fal fa-file"></i>{{ __('admin_local.Batches') }} : {{ count($batches) }}</span>
                                                <span><i class="fal fa-user"></i>{{ __('admin_local.Students') }} : {{ $course->enrolled_count }}</span>
                                                <span><i class="fal fa-chart-simple"></i>{{ $course->course_level }}</span>
                                            </div>
                                            <div class="course-author">
                                                <div class="author-info">
                                                    <img src="@if($inctructor->instructor->image) {{ asset($inctructor->instructor->image) }} @else {{ asset('public/bipebd/assets/img/course/author.png') }} @endif" alt="author">
                                                    <a href="course.html" class="author-name" style="font-size:14px;">{{ $inctructor->instructor->name }}</a>
                                                </div>
                                                <div class="offer-tag bg-danger text-white px-2" style="border-radius: 6px;font-size:10px;">{{ __('admin_local.Live') }}</div>
                                            </div>
                                        @else
                                        @php
                                            $inctructor = \App\Models\Admin\Course\CourseInstructor::with('instructor')->where([['course_id',$course->id]])->orderBy('id','DESC')->first();
                                            $videos = \App\Models\Admin\Course\CourseVideo::where([['video_status',1],['video_delete',0]])->get();
                                        @endphp
                                            <div class="course-meta">
                                                <span><i class="fal fa-file"></i>{{ __('admin_local.Videos') }} : {{ count($videos) }}</span>
                                                <span><i class="fal fa-user"></i>{{ __('admin_local.Enrolled') }} : {{ $course->enrolled_count }}</span>
                                                <span><i class="fal fa-chart-simple"></i>{{ $course->course_level }}</span>
                                            </div>
                                            <div class="course-author px-0">
                                                <div class="author-info">
                                                    <img src="@if($inctructor->instructor->image) {{ asset($inctructor->instructor->image) }} @else {{ asset('public/bipebd/assets/img/course/author.png') }} @endif" alt="author">
                                                    <a href="course.html" class="author-name" style="font-size:14px;">{{ $inctructor->instructor->name }}</a>
                                                </div>
                                                <div class="offer-tag bg-success text-white px-2" style="border-radius: 6px;font-size:10px;">{{ __('admin_local.Pre-recorded') }}</div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                    </div>
                </div>
                {{-- <div class="th-pagination text-center pt-50">
                    <ul>
                        <li><a href="blog.html">01</a></li>
                        <li><a href="blog.html">02</a></li>
                        <li><a href="blog.html">03</a></li>
                        <li><a href="blog.html"><i class="far fa-arrow-right"></i></a></li>
                    </ul>
                </div> --}}
            </div>
            <div class="col-xl-3 col-lg-4 order-lg-1">
                <aside class="sidebar-area sidebar-shop">
                    <div class="widget widget_categories style2  ">
                        <h3 class="widget_title">{{ __('admin_local.Categories') }}</h3>
                        <ul>
                            @php
                                $course_categories = \App\Models\Admin\Course\CourseCategory::where([['category_status',1],['category_delete',0]])->get();
                            @endphp
                            @foreach ($course_categories as $key_cat=>$course_category)
                                @php
                                    $course_sub_categories = \App\Models\Admin\Course\CourseSubcategory::where([['sub_category_status',1],['sub_category_delete',0],['category_id',$course_category->id]])->get();
                                @endphp

                            @if ($course_sub_categories)
                            <li><input id="category_check{{ $key_cat }}" onclick="window.location.replace('{{ route('frontend.courses.getAllCourses',['category',$course_category->category_slug]) }}')" name="category_check" type="checkbox" {{ $url_slug['category_slug']==$course_category->category_slug?'checked':'' }} style="color:red !important;background:red !important;">
                                <label for="category_check{{ $key_cat }}">{{ $course_category->category_name }}<span class="checkmark"></span></label>
                                <ul class="sub-cat">
                                    @foreach ($course_sub_categories as $key_scat=>$course_sub_category)
                                    <li><input id="designcheck{{ $key_cat.$key_scat }}" name="designcheck" type="checkbox" {{ $url_slug['sub_category_slug']==$course_sub_category->sub_category_slug?'checked':'' }} onclick="window.location.replace('{{ route('frontend.courses.getAllCourses',['sub-category',$course_sub_category->sub_category_slug]) }}')">
                                        <label for="designcheck{{ $key_cat.$key_scat }}">{{ $course_sub_category->sub_category_name }}<span class="checkmark"></span>
                                    </li>
                                    @endforeach
                                </ul>
                            </li>
                            @else
                            <li><input id="category_check" name="beginnercheck" type="checkbox" {{ $category_slug==$course_category->category_slug?'checked':'' }}>
                                <label for="category_check">{{ $course_category->category_name }}<span class="checkmark"></span></label>
                            </li>
                            @endif
                            @endforeach
                        </ul>
                    </div>
                    <div class="widget widget_price_filter style2  ">
                        <h4 class="widget_title">{{ __("admin_local.Course Type") }}</h4>
                        <ul>
                            
                            <li><input id="freecheck" name="freecheck" type="checkbox" {{ $url_slug['type']=='live'?'checked':'' }} onclick="window.location.replace('{{ route('frontend.courses.getAllCourses',['live']) }}')">
                                <label for="freecheck">{{ __('admin_local.LIVE') }}<span class="checkmark"></span></label>
                            </li>
                            
                            <li><input id="paidcheck" name="paidcheck" type="checkbox" {{ $url_slug['type']=='pre-recorded'?'checked':'' }} onclick="window.location.replace('{{ route('frontend.courses.getAllCourses',['pre-recorded']) }}')" >
                                <label for="paidcheck">{{ __('admin_local.PRE-RECORDED') }}<span class="checkmark"></span></label>
                            </li>
                        </ul>
                    </div>
                    
                    {{-- <div class="widget widget_instructor style2  ">
                        <h4 class="widget_title">Our Instructor</h4>
                        <ul>
                            @foreach ($instructors as $instructor)
                            <li><input id="instructor1{{ $instructor->id }}" name="instructor1{{ $instructor->id }}" type="checkbox" {{ $url_slug['instructor']==$instructor->id?'checked':'' }}>
                                <label for="instructor1{{ $instructor->id }}">{{ $instructor->name }}<span class="checkmark"></span></label>
                            </li>
                            @endforeach
                        </ul>
                    </div> --}}
                </aside>
            </div>
        </div>
    </div>
</section>
@endsection
@section('custom_js')
    <script>
        $(document).on('click','#add_cart',function(){
            let slug = $(this).data('course_slug');
            $.ajax({
                type: "get",
                url: "{{ url('course/add-to-cart') }}"+"/"+slug,
                dataType: 'JSON',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    window.location.reload();
                },
                error : function(err){
                    if(err.status=401){
                        window.location.replace("{{ route('user.login','login') }}");
                    }
                }
            })
        })
    </script>
@endsection