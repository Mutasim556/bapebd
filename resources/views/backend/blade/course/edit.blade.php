@extends('backend.shared.layouts.admin')
@push('title')
    {{ __('admin_local.Edit Course') }}
@endpush
@push('css')
    <link rel="stylesheet" href="{{ asset(env('ASSET_DIRECTORY') . '/' . 'admin/assets/css/custom.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset(env('ASSET_DIRECTORY') . '/' . 'admin/assets/css/vendors/dropzone.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset(env('ASSET_DIRECTORY') . '/' . 'admin/plugins/taginputs/bootstrap-tagsinput.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset(env('ASSET_DIRECTORY') . '/' . 'admin/assets/css/vendors/date-picker.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset(env('ASSET_DIRECTORY') . '/' . 'adminassets/css/vendors/select2.css') }}">
@endpush
@push('page_css')
    <style>
        .loader-box {
            height: auto;
            padding: 10px 0px;
        }

        .loader-box .loader-35:after {
            height: 20px;
            width: 10px;
        }

        .loader-box .loader-35:before {
            width: 20px;
            height: 10px;
        }

        .cke_contents {
            border: 2px dashed #5c61f2 !important;
            border-radius: 0px 0px 10px 10px
        }

        .cke_top {
            border: 2px dashed #5c61f2 !important;
            border-bottom: 0px !important;
            border-radius: 10px 10px 0px 0px
        }

        .invalid-selec2 {
            border-color: red !important;
        }
    </style>
@endpush
@section('content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6">
                    <h3>{{ __('admin_local.Edit Course') }}</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="javascript:void(0)">{{ __('admin_local.Courses') }}</a>
                        </li>
                        <li class="breadcrumb-item active">{{ __('admin_local.View Course') }}</li>
                        <li class="breadcrumb-item active">{{ __('admin_local.Edit Course') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <!-- Column -->
            <div class="col-lg-12 mx-auto">
                <div class="card">
                    <div class="card-header py-3" style="border-bottom: 2px dashed gray">
                        <h3 class="card-title mb-0 text-center">{{ __('admin_local.Edit Course') }}</h3>
                    </div>
                    <p class="px-3 text-danger">
                        <i>{{ __('admin_local.The field labels marked with * are required input fields.') }}</i>
                    </p>
                    <div class="card-body">
                        <input type="hidden" id="csrf_token" value="{{ csrf_token() }}">
                        <form action="" id="edit_course_form" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="course_id" id="course_id" value="{{ $course->id }}">
                            <div class="row">
                                <div class="col-sm-12 col-xl-12">
                                    <ul class="nav nav-pills nav-primary my-0" id="pills-successtab" role="tablist">
                                        @php
                                            $lang = \App\Models\Admin\Language::where([
                                                ['status', 1],
                                                ['delete', 0],
                                                ['default', 1],
                                            ])->first();
                                        @endphp
                                        <li class="nav-item"><a class="nav-link active" id="pills-defaultLang-tab"
                                                data-bs-toggle="pill" href="#pills-defaultLang" role="tab"
                                                aria-controls="pills-defaultLang" aria-selected="true">{{ $lang->name }}
                                                ( {{ __('admin_local.Default') }} )</a></li>
                                        @foreach (getLangs() as $lang)
                                            <li class="nav-item"><a class="nav-link" id="pills-{{ $lang->name }}-tab"
                                                    data-bs-toggle="pill" href="#pills-{{ $lang->name }}" role="tab"
                                                    aria-controls="pills-{{ $lang->name }}"
                                                    aria-selected="true">{{ $lang->name }}</a></li>
                                        @endforeach
                                    </ul>
                                    <div class="tab-content mt-3" id="pills-successtabContent">
                                        <div class="tab-pane fade show active" id="pills-defaultLang" role="tabpanel"
                                            aria-labelledby="pills-defaultLang-tab">
                                            <div class="form-group">
                                                <label for="">{{ __('admin_local.Course Name') }} (
                                                    {{ __('admin_local.Default') }} ) *</label>
                                                <input type="text" class="form-control" name="course_name"
                                                    id="course_name" value="{{ $course->course_name }}">
                                                <span class="text-danger err-mgs" id="course_name_err"></span>
                                            </div>
                                            <div class="form-group">
                                                <label for="">{{ __('admin_local.Course Headline') }} (
                                                    {{ __('admin_local.Default') }} ) *</label>
                                                <input type="text" class="form-control" name="course_headline"
                                                    id="course_headline" value="{{ $course->course_headline }}">
                                                <span class="text-danger err-mgs" id="course_headline_err"></span>
                                            </div>
                                            <div class="form-group">
                                                <label for="">{{ __('admin_local.Course Details') }} (
                                                    {{ __('admin_local.Default') }} ) *</label>
                                                <textarea class="form-control ckeditorappend" name="course_details" id="course_details">{{ $course->course_details }}</textarea>
                                                <span class="text-danger err-mgs" id="course_details_err"></span>
                                            </div>
                                        </div>
                                        <script>
                                            var langCode = [];
                                        </script>
                                        @foreach (getLangs() as $lang)
                                            <script>
                                                langCode.push("{{ $lang->lang }}");
                                            </script>
                                            @php
                                                // dd($course->translations);
                                                $translate = [];
                                                if(count($course->translations)>0){
                                                    
                                                    foreach ($course->translations as $key => $translation) {
                                                        if($translation->locale==$lang->lang && $translation->key=='course_name'){
                                                            $translate[$lang->lang]['course_name'] = $translation->value;
                                                        }
                                                        if($translation->locale==$lang->lang && $translation->key=='course_headline'){
                                                            $translate[$lang->lang]['course_headline'] = $translation->value;
                                                        }
                                                        if($translation->locale==$lang->lang && $translation->key=='course_details'){
                                                            $translate[$lang->lang]['course_details'] = $translation->value;
                                                        }
                                                    }
                                                    
                                                }

                                            @endphp
                                            <div class="tab-pane fade" id="pills-{{ $lang->name }}" role="tabpanel"
                                                aria-labelledby="pills-{{ $lang->name }}-tab">
                                                <div class="form-group">
                                                    <label for="">{{ __('admin_local.Course Name') }} (
                                                        {{ $lang->name }} )</label>
                                                    <input type="text" class="form-control"
                                                        name="course_name_{{ $lang->lang }}"
                                                        id="course_name_{{ $lang->lang }}" value="{{ isset($translate[$lang->lang]['course_name'])?$translate[$lang->lang]['course_name']:'' }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">{{ __('admin_local.Course Headline') }} (
                                                        {{ $lang->name }} )</label>
                                                    <input type="text" class="form-control"
                                                        name="course_headline_{{ $lang->lang }}"
                                                        id="course_headline_{{ $lang->lang }}" value="{{ isset($translate[$lang->lang]['course_headline'])?$translate[$lang->lang]['course_headline']:'' }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">{{ __('admin_local.Course Details') }} (
                                                        {{ $lang->name }} ) </label>
                                                    <textarea class="form-control ckeditorappend" name="course_details_{{ $lang->lang }}"
                                                        id="course_details_{{ $lang->lang }}">{{ isset($translate[$lang->lang]['course_details'])?$translate[$lang->lang]['course_details']:'' }}</textarea>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 mt-2">
                                    <label for="category"><strong>{{ __('admin_local.Course Name Slug') }} *
                                        </strong></label>
                                    <input type="text" class="form-control" name="course_name_slug" id="course_name_slug" value="{{ $course->course_name_slug }}">
                                    <span class="text-danger err-mgs" id="course_name_slug_err"></span>
                                </div>
                                <div class="col-lg-6 mt-2">
                                    <label for="category"><strong>{{ __('admin_local.Select Category') }} *
                                        </strong></label>
                                    <select class="js-example-basic-single form-control" name="course_category"
                                        id="course_category">
                                        <option value="">{{ __('admin_local.Select Please') }}</option>
                                        @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ $course->category_id==$category->id?'selected':'' }}>{{ $category->category_name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger err-mgs" id="course_category_err"></span>
                                </div>
                                <div class="col-lg-6 mt-2">
                                    <label for="category"><strong>{{ __('admin_local.Select Sub-category') }} *
                                        </strong></label>
                                    <select class="js-example-basic-single form-control" name="course_sub_category"
                                        id="course_sub_category">
                                        <option value="">{{ __('admin_local.Select Please') }}</option>
                                        @foreach ($sub_categories as $sub_category)
                                        <option value="{{ $sub_category->id }}" {{ $course->sub_category_id==$sub_category->id?'selected':'' }}>{{ $sub_category->sub_category_name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger err-mgs" id="course_sub_category_err"></span>
                                </div>
                                <div class="col-lg-4 mt-2">
                                    <label for="category"><strong>{{ __('admin_local.Select Course Level') }} *
                                        </strong></label>
                                    <select class="js-example-basic-single form-control" name="course_level"
                                        id="course_level">
                                        <option value="">{{ __('admin_local.Select Please') }}</option>
                                        <option value="Beginner" {{ $course->course_level=='Beginner'?'selected':'' }}>{{ __('admin_local.Beginner') }}</option>
                                        <option value="Intermediate" {{ $course->course_level=='Intermediate'?'selected':'' }}>{{ __('admin_local.Intermediate') }}</option>
                                        <option value="Advanced" {{ $course->course_level=='Advanced'?'selected':'' }}>{{ __('admin_local.Advanced') }}</option>
                                    </select>
                                    <span class="text-danger err-mgs" id="course_level_err"></span>
                                </div>
                                <div class="col-lg-4 mt-2">
                                    <label for="category"><strong>{{ __('admin_local.Select Course Type') }} *
                                        </strong></label>
                                    <select class="js-example-basic-single form-control" name="course_type"
                                        id="course_type" disabled>
                                        <option value="">{{ __('admin_local.Select Please') }}</option>
                                        <option value="Pre-recorded" {{ $course->course_type=='Pre-recorded'?'selected':'' }}>{{ __('admin_local.Pre-recorded') }}</option>
                                        <option value="Live" {{ $course->course_type=='Live'?'selected':'' }}>{{ __('admin_local.Live') }}</option>
                                    </select>
                                    <span class="text-danger err-mgs" id="course_type_err"></span>
                                </div>
                                <div class="col-lg-4 mt-2">
                                    <label for="category"><strong>{{ __('admin_local.No of Videos/Class') }} *
                                        </strong></label>
                                    <input type="number" class="form-control" name="no_of_videos" id="no_of_videos" value="{{ $course->no_of_videos }}">
                                    <span class="text-danger err-mgs" id="no_of_videos_err"></span>
                                </div>
                                <div class="col-lg-4 mt-2">
                                    <label for="category"><strong>{{ __('admin_local.Course Duration') }} *
                                        </strong></label>
                                    <input type="text" class="form-control" name="course_duration"
                                        id="course_duration" value="{{ $course->course_duration }}">
                                    <span class="text-danger err-mgs" id="course_duration_err"></span>
                                </div>
                                <div class="col-lg-4 mt-2">
                                    <label for="category"><strong>{{ __('admin_local.Course Duration Type') }} *
                                        </strong></label>
                                    <select class="js-example-basic-single form-control" name="course_duration_type"
                                        id="course_duration_type">
                                        <option value="Minute"  {{ $course->course_duration_type=='Minute'?'selected':'' }}>{{ __('admin_local.Minute') }}</option>
                                        <option value="Hour" {{ $course->course_duration_type=='Hour'?'selected':'' }}>{{ __('admin_local.Hour') }}</option>
                                        <option value="Day" {{ $course->course_duration_type=='Day'?'selected':'' }}>{{ __('admin_local.Day') }}</option>
                                        <option value="Month" {{ $course->course_duration_type=='Month'?'selected':'' }}>{{ __('admin_local.Month') }}</option>
                                        <option value="Year" {{ $course->course_duration_type=='Year'?'selected':'' }}>{{ __('admin_local.Year') }}</option>
                                    </select>
                                    <span class="text-danger err-mgs" id="course_duration_type_err"></span>
                                </div>
                                <div class="col-lg-4 mt-2">
                                    <label for="category"><strong>{{ __('admin_local.Course Price') }} *
                                        </strong></label>
                                    <input type="text" class="form-control" name="course_price" id="course_price" value="{{ $course->course_price }}">
                                    <span class="text-danger err-mgs" id="course_price_err"></span>
                                </div>
                                <div class="col-lg-4 mt-2">
                                    <label for="category"><strong>{{ __('admin_local.Course Price Type') }} *
                                        </strong></label>
                                    <select class="js-example-basic-single form-control" name="course_price_type"
                                        id="course_price_type">
                                        <option value="BDT" {{ $course->course_price_currency=='BDT'?'selected':'' }}>{{ __('admin_local.BDT') }}</option>
                                        <option value="USD" {{ $course->course_price_currency=='USD'?'selected':'' }}>{{ __('admin_local.USD') }}</option>
                                    </select>
                                    <span class="text-danger err-mgs" id="course_price_type_err"></span>
                                </div>
                                <div class="col-lg-4 mt-2">
                                    <label for="category"><strong>{{ __('admin_local.Course Discount') }} 
                                        </strong></label>
                                    <input type="text" class="form-control" name="course_discount"
                                        id="course_discount" value="{{ $course->course_discount }}">
                                    <span class="text-danger err-mgs" id="course_discount_err"></span>
                                </div>
                                <div class="col-lg-4 mt-2">
                                    <label for="category"><strong>{{ __('admin_local.Course Discount Type') }} 
                                        </strong></label>
                                    <select class="js-example-basic-single form-control" name="course_discount_type"
                                        id="course_discount_type">
                                        <option value="Flat" {{ $course->course_discount_type=='Flat'?'selected':'' }}>{{ __('admin_local.Flat') }}</option>
                                        <option value="Percent" {{ $course->course_discount_type=='Percent'?'selected':'' }}>{{ __('admin_local.Percent') }}</option>
                                    </select>
                                    <span class="text-danger err-mgs" id="course_discount_type_err"></span>
                                </div>
                                <div class="col-lg-4 mt-2">
                                    <label for="category"><strong>{{ __('admin_local.Course Discount Price') }} *
                                        </strong></label>
                                    <input type="text" class="form-control" name="course_discount_price"
                                        id="course_discount_price" value="{{ $course->course_discount_price }}" readonly>
                                    <span class="text-danger err-mgs" id="course_discount_price_err"></span>
                                </div>

                                <div class="col-lg-4 mt-2">
                                    <input type="checkbox" name="course_cupon_status" id="course_cupon_status" {{ $course->course_cupon_status?'checked':'' }}>
                                    <label for="category"><strong>
                                            {{ __('admin_local.Can use coupon ?') }}</strong></label>
                                </div>
                                <div class="col-lg-5 mt-2">
                                    <input type="checkbox" name="course_multiple_cupon_status" id="course_multiple_cupon_status" {{ $course->course_multiple_cupon_status?'checked':'' }}>
                                    <label for="category"><strong>
                                            {{ __('admin_local.Can use multiple coupon ?') }}</strong></label>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="product_image"><strong>{{ __('admin_local.Course Image / Images') }} * 
                                        </strong> <i style="font-size: 16px;cursor:pointer"
                                            class="fa fa-exclamation-circle" data-bs-toggle="tooltip"
                                            data-bs-placement="top"
                                            title="{{ __('admin_local.You can upload multiple image. Only .jpeg, .jpg, .png, .gif file can be uploaded. First image will be base image.') }}"></i>
                                    </label>
                                    <div id="dropzoneDragArea" class="dropzone dropzone-info">
                                        <div class="dz-message needsclick"><i class="icon-cloud-up"></i>
                                            <h6>{{ __('admin_local.Drop files here or click to upload') }}.</h6>
                                        </div>
                                    </div>
                                    <span class="text-danger err-mgs" id="image_err"></span>
                                </div>
                            </div>
                            @if ($course->course_type=='Pre-recorded')
                            <div class="row">
                                <div class="col-lg-6 mt-2">
                                    <label for="category"><strong>{{ __('admin_local.Course Instructor') }} *
                                        </strong></label>
                                    <select class="js-example-basic-single form-control" name="course_instructor"
                                        id="course_instructor" >
                                        <option value="" disabled>{{ __('admin_local.Select Please') }}</option>
                                        @foreach ($instructors as $instructor)
                                            <option value="{{ $instructor->id }}" {{ $course->courseInstructor->instructor_id==$instructor->id?'selected':'' }}>{{ $instructor->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger err-mgs" id="course_instructor_err"></span>
                                </div>
                                <div class="col-lg-6 mt-2">
                                    <label for="category"><strong>{{ __('admin_local.File Link') }}
                                    </strong></label>
                                    <input type="text" class="form-control file_link" name="file_link"
                                    id="file_link" value="{{ $course->courseInstructor->file_link}}">
                                    <span class="text-danger err-mgs" id="file_link_err"></span>
                                </div>
                            </div>
                            @endif
                            
                            <div class="row">
                                <div class="col-md-12 mt-4">
                                    <div class="row">
                                        <div class="col-lg-4 col-sm-4 col-md-4  mx-auto" style="text-align:center">
                                            <button type="submit" class="btn btn-success btn-sm px-3"><strong><i class="fa fa-paper-plane"></i> &nbsp; {{ __('admin_local.Edit Course') }}</strong></button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

        </div>
        <!-- Row -->
    </div>
@endsection
@push('js')
    <script src="{{ asset(env('ASSET_DIRECTORY') . '/' . 'admin/assets/js/sweet-alert/sweetalert.min.js') }}"></script>
    <script src="{{ asset(env('ASSET_DIRECTORY') . '/' . 'admin/assets/js/datatable/datatables/jquery.dataTables.min.js') }}">
    </script>
    <script src="{{ asset(env('ASSET_DIRECTORY') . '/' . 'admin/plugins/switchery/switchery.min.js') }}"></script>
    <script src="{{ asset(env('ASSET_DIRECTORY') . '/' . 'admin/assets/js/dropzone/dropzone.js') }}"></script>
    <script src="{{ asset(env('ASSET_DIRECTORY') . '/' . 'admin/assets/js/editor/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset(env('ASSET_DIRECTORY') . '/' . 'admin/assets/js/editor/ckeditor/adapters/jquery.js') }}"></script>
    <script src="{{ asset(env('ASSET_DIRECTORY') . '/' . 'admin/assets/js/editor/ckeditor/styles.js') }}"></script>
    <script src="{{ asset(env('ASSET_DIRECTORY') . '/' . 'admin/assets/js/editor/ckeditor/ckeditor.custom.js') }}"></script>
    <script src="{{ asset(env('ASSET_DIRECTORY') . '/' . 'admin/plugins/taginputs/bootstrap-tagsinput.js') }}"></script>
    <script src="{{ asset(env('ASSET_DIRECTORY') . '/' . 'admin/assets/js/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset(env('ASSET_DIRECTORY') . '/' . 'admin/assets/js/theme-customizer/customizer.js') }}">  </script>
    @if (Request::is('admin/course/*'))
        <script>
             $(document).ready(function(){
                $('#course-sidebar-title').addClass('active')
                $('#course-sidebar-submenu').show()
                $('#course-sidebar-link').addClass('active')
             })
        </script>
    @endif
    @foreach (getLangs() as $lang)
        <script>
            CKEDITOR.replace('course_details_' + '{{ $lang->lang }}', {
                on: {
                    contentDom: function(evt) {
                        // Allow custom context menu only with table elemnts.
                        evt.editor.editable().on('contextmenu', function(contextEvent) {
                            var path = evt.editor.elementPath();

                            if (!path.contains('table')) {
                                contextEvent.cancel();
                            }
                        }, null, null, 5);
                    }
                }
            });
        </script>
    @endforeach

    <script>
        CKEDITOR.replace('course_details', {
            on: {
                contentDom: function(evt) {
                    // Allow custom context menu only with table elemnts.
                    evt.editor.editable().on('contextmenu', function(contextEvent) {
                        var path = evt.editor.elementPath();

                        if (!path.contains('table')) {
                            contextEvent.cancel();
                        }
                    }, null, null, 5);
                }
            }
        });
        $(document).ready(function() {
            $('.js-example-basic-single').each(function() {
                $(this).select2();
            })
            // $(".js-example-basic-hide-search").select2({
            //     minimumResultsForSearch: Infinity,
            //     closeOnSelect: false
            // });
        })
        $('[data-toggle="switchery"]').each(function(idx, obj) {
            new Switchery($(this)[0], $(this).data());
        });
        $('.js-example-basic-single').select2({
            dropdownParent: $('#add-brand-modal')
        });
        $('.js-example-basic-single1').select2({
            dropdownParent: $('#edit-brand-modal')
        });
        $(document).on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        });
        var count_div = 0;
        $('#ad_more_video').on('click',function(){
            count_div++;
            $('#add_more_video_append').next('div').append(`
                
                <div class="row mb-3">
                    <div class="col-lg-12"><hr class="mt-2" style="background-color:black;height:3px;"></div>
                    <div class="col-lg-4 mt-2">
                        <label for="category"><strong>{{ __('admin_local.Video Group') }} *
                            </strong></label>
                        <input type="text" class="form-control video_group" name="video_group[]"
                            id="video_group">
                        <span class="text-danger err-mgs" id="video_group_${count_div}_err"></span>
                    </div>
                    <div class="col-lg-3 mt-2">
                        <label for="category"><strong>{{ __("admin_local.Video's File") }}
                            </strong></label>
                        <input type="file" class="form-control video_file" name="video_file[]"
                            id="video_file_${count_div}">
                        <span class="text-danger err-mgs" id="video_file_err"></span>
                    </div>
                     <div class="col-lg-2 mt-2">
                        <label for="category"><strong>{{ __('admin_local.Video No.') }} *
                        </strong></label>
                        <input type="number" min="1" class="form-control video_no" name="video_no[]"
                            id="video_no">
                        <span class="text-danger err-mgs" id="video_no_${count_div}_err"></span>
                    </div>
                    <div class="col-lg-3 mt-2">
                        <label for="category"><strong>{{ __('admin_local.Video Link') }} *
                            </strong></label>
                        <input type="text" class="form-control video_link" name="video_link[]"
                            id="video_link">
                        <span class="text-danger err-mgs" id="video_link_${count_div}_err"></span>
                    </div>
                    <div class="col-lg-6 mt-2">
                        <label for="category"><strong>{{ __('admin_local.Video Title') }} *
                            </strong></label>
                        <input type="text" class="form-control video_title" name="video_title[]"
                            id="video_title">
                        <span class="text-danger err-mgs" id="video_title_${count_div}_err"></span>
                    </div>
                    <div class="col-lg-3 mt-2">
                        <label for="category"><strong>{{ __('admin_local.Video Duration') }} *
                            </strong></label>
                        <input type="text" class="form-control video_duration" name="video_duration[]"
                            id="video_duration">
                        <span class="text-danger err-mgs" id="video_duration_${count_div}_err"></span>
                    </div>
                    <div class="col-lg-2 mt-2">
                        <label for="category"><strong>{{ __('admin_local.Video Type') }} *
                            </strong></label>
                        <select class="js-example-basic-single form-control" name="video_type[]"
                            id="video_type">
                            <option value="">{{ __('admin_local.Select Please') }}</option>
                            <option value="Paid" selected>{{ __('admin_local.Paid') }}</option>
                            <option value="Free">{{ __('admin_local.Free') }}</option>
                        </select>
                        <span class="text-danger err-mgs" id="video_type_${count_div}_err"></span>
                    </div>
                    <div class="col-lg-1" style="margin-top:40px;">
                        <button style="float:right" id="delete_video_row" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                    </div>
                </div>
            `);

            $('.js-example-basic-single').each(function() {
                $(this).select2();
            })
        });

        $(document).on('click','#delete_video_row',function(){
            $(this).closest('.row').remove();
        })

        var oTable = $("#basic-1").DataTable({
            "language": {
                "decimal": "",
                "emptyTable": "{{ __('admin_local.admin_local.No size available in table') }}",
                "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                "infoEmpty": "Showing 0 to 0 of 0 entries",
                "infoFiltered": "(filtered from _MAX_ total entries)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Show _MENU_ entries",
                "loadingRecords": "Loading...",
                "processing": "",
                "search": "Search:",
                "zeroRecords": "No matching records found",
                "paginate": {
                    "first": "First",
                    "last": "Last",
                    "next": "Next",
                    "previous": "Previous"
                },
                "aria": {
                    "sortAscending": ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
                }
            }
        });

        var form_url = "{{ route('admin.course.update',$course->id) }}";
        var submit_btn_after = `<strong>{{ __('admin_local.Updating Course') }} &nbsp; <i class="fa fa-rotate-right fa-spin"></i></strong>`;
        var submit_btn_before = `<strong><i class="fa fa-paper-plane"></i> &nbsp; {{ __('admin_local.Update Course') }}</strong>`;
        var no_permission_mgs = `{{ __('admin_local.No Permission') }}`;
        var discount_warning = `{{ __('admin_local.Discount should be less then price') }}`;
        var comfirm_btn = `{{ __('admin_local.Ok') }}`;


        var delete_swal_title = `{{ __('admin_local.Are you sure?') }}`;
        var delete_swal_text =
            `{{ __('admin_local.Once deleted, you will not be able to recover this size data') }}`;
        var delete_swal_cancel_text = `{{ __('admin_local.Delete request canceld successfully') }}`;
        var no_file = `{{ __('admin_local.No file') }}`;
        var base_url = `{{ baseUrl() }}`;
        var translate_url = `{{ route('admin.translateString') }}`;
        var select_please = `{{ __('admin_local.Select Please') }}`;
    </script>
    <script src="{{ asset(env('ASSET_DIRECTORY') . '/' . 'admin/custom/course/course_edit.js') }}"></script>
    {{-- <script src="{{ asset(env('ASSET_DIRECTORY').'/'.'inventory/custom/user/user_list.js') }}"></script> --}}
@endpush
