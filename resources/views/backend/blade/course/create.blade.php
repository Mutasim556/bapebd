@extends('backend.shared.layouts.admin')
@push('title')
    {{ __('admin_local.Add Course') }}
@endpush
@push('css')
<link rel="stylesheet" href="{{ asset(env('ASSET_DIRECTORY').'/'.'admin/assets/css/custom.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset(env('ASSET_DIRECTORY').'/'.'admin/assets/css/vendors/dropzone.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset(env('ASSET_DIRECTORY').'/'.'admin/plugins/taginputs/bootstrap-tagsinput.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset(env('ASSET_DIRECTORY').'/'.'admin/assets/css/vendors/date-picker.css') }}">
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
    .invalid-selec2{
        border-color: red !important;
    }
</style>
@endpush
@section('content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6">
                    <h3>{{ __('admin_local.Add Course') }}</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="javascript:void(0)">{{ __('admin_local.Courses') }}</a>
                        </li>
                        <li class="breadcrumb-item active">{{ __('admin_local.Add Course') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container-fluid">
        <div class="row">
            <!-- Column -->
            <div class="col-lg-10 mx-auto">
                <div class="card">
                    <div class="card-header py-3" style="border-bottom: 2px dashed gray">
                        <h3 class="card-title mb-0 text-center">{{ __('admin_local.Add Course') }}</h3>
                    </div>
                    <p class="px-3 text-danger">
                        <i>{{ __('admin_local.The field labels marked with * are required input fields.') }}</i>
                    </p>
                    <div class="card-body">
                        <form action="" id="add_course_form">
                            <div class="row">
                                <div class="col-sm-12 col-xl-12">
                                    <ul class="nav nav-pills nav-primary my-0" id="pills-successtab" role="tablist">
                                        @php
                                            $lang =  \App\Models\Admin\Language::where([['status',1],['delete',0],['default',1]])->first();
                                        @endphp
                                      <li class="nav-item"><a class="nav-link active" id="pills-defaultLang-tab" data-bs-toggle="pill" href="#pills-defaultLang" role="tab" aria-controls="pills-defaultLang" aria-selected="true">{{ $lang->name }} ( {{ __('admin_local.Default') }} )</a></li>
                                      @foreach (getLangs() as $lang)
                                      <li class="nav-item"><a class="nav-link" id="pills-{{ $lang->name }}-tab" data-bs-toggle="pill" href="#pills-{{ $lang->name }}" role="tab" aria-controls="pills-{{ $lang->name }}" aria-selected="true">{{ $lang->name }}</a></li>
                                      @endforeach
                                    </ul>
                                    <div class="tab-content mt-3" id="pills-successtabContent">
                                      <div class="tab-pane fade show active" id="pills-defaultLang" role="tabpanel" aria-labelledby="pills-defaultLang-tab">
                                        <div class="form-group">
                                            <label for="">{{ __('admin_local.Course Name') }} ( {{ __('admin_local.Default') }} ) *</label>
                                            <input type="text" class="form-control" name="course_name" id="course_name">
                                        </div>
                                        <div class="form-group">
                                            <label for="">{{ __('admin_local.Course Headline') }} ( {{ __('admin_local.Default') }} ) *</label>
                                            <input type="text" class="form-control" name="course_headline" id="course_headline">
                                        </div>
                                        <div class="form-group">
                                            <label for="">{{ __('admin_local.Course Details') }} ( {{ __('admin_local.Default') }} ) *</label>
                                            <textarea class="form-control ckeditorappend" name="course_details" id="course_details"></textarea>
                                        </div>
                                      </div>
                                      @foreach (getLangs() as $lang)
                                      <div class="tab-pane fade" id="pills-{{ $lang->name }}" role="tabpanel" aria-labelledby="pills-{{ $lang->name }}-tab">
                                        <div class="form-group">
                                            <label for="">{{ __('admin_local.Course Name') }} ( {{ $lang->name }} )</label>
                                            <input type="text" class="form-control" name="course_name_{{ $lang->lang }}" id="course_name_{{ $lang->lang }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="">{{ __('admin_local.Course Headline') }} ( {{ $lang->name }} )</label>
                                            <input type="text" class="form-control" name="course_headline_{{ $lang->lang }}" id="course_headline_{{ $lang->lang }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="">{{ __('admin_local.Course Details') }} ( {{ $lang->name }} ) </label>
                                            <textarea class="form-control ckeditorappend" name="course_details_{{ $lang->lang }}" id="course_details_{{ $lang->lang }}"></textarea>
                                        </div>
                                      </div>
                                      @endforeach
                                  </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 mt-2">
                                    <label for="category"><strong>{{ __('admin_local.Select Course Type') }}
                                    </strong></label>
                                    <select class="js-example-basic-single form-control" name="course_type"
                                        id="course_type">
                                        <option value="">{{ __('admin_local.Select Please') }}</option>
                                        <option value="Pre-recorded">{{ __('admin_local.Pre-recorded') }}</option>
                                        <option value="Live">{{ __('admin_local.Live') }}</option>
                                    </select>
                                    <span class="text-danger err-mgs" id="course_type_err"></span>
                                </div>
                                <div class="col-lg-4 mt-2">
                                    <label for="category"><strong>{{ __('admin_local.No of Videos') }}
                                    </strong></label>
                                    <input type="number" class="form-control" name="no_of_videos" id="no_of_videos">
                                    <span class="text-danger err-mgs" id="no_of_videos_err"></span>
                                </div>
                                <div class="col-lg-4 mt-2">
                                    <label for="category"><strong>{{ __('admin_local.Course Duration') }}
                                    </strong></label>
                                    <input type="text" class="form-control" name="course_duration" id="course_duration">
                                    <span class="text-danger err-mgs" id="course_duration_err"></span>
                                </div>
                                <div class="col-lg-4 mt-2">
                                    <label for="category"><strong>{{ __('admin_local.Course Duration Type') }}
                                    </strong></label>
                                    <select class="js-example-basic-single form-control" name="course_duration_type"
                                        id="course_duration_type">
                                        <option value="Minute">{{ __('admin_local.Minute') }}</option>
                                        <option value="Hour">{{ __('admin_local.Hour') }}</option>
                                        <option value="Day">{{ __('admin_local.Day') }}</option>
                                        <option value="Month">{{ __('admin_local.Month') }}</option>
                                        <option value="Year">{{ __('admin_local.Year') }}</option>
                                    </select>
                                    <span class="text-danger err-mgs" id="course_duration_type_err"></span>
                                </div>
                                <div class="col-lg-4 mt-2">
                                    <label for="category"><strong>{{ __('admin_local.Course Price') }}
                                    </strong></label>
                                    <input type="text" class="form-control" name="course_price" id="course_price">
                                    <span class="text-danger err-mgs" id="course_price_err"></span>
                                </div>
                                <div class="col-lg-4 mt-2">
                                    <label for="category"><strong>{{ __('admin_local.Course Price Type') }}
                                    </strong></label>
                                    <select class="js-example-basic-single form-control" name="course_price_type"
                                        id="course_price_type">
                                        <option value="BDT">{{ __('admin_local.BDT') }}</option>
                                        <option value="USD">{{ __('admin_local.USD') }}</option>
                                    </select>
                                    <span class="text-danger err-mgs" id="course_price_type_err"></span>
                                </div>
                                <div class="col-lg-4 mt-2">
                                    <label for="category"><strong>{{ __('admin_local.Course Discount') }}
                                    </strong></label>
                                    <input type="text" class="form-control" name="course_discount" id="course_discount">
                                    <span class="text-danger err-mgs" id="course_discount_err"></span>
                                </div>
                                <div class="col-lg-4 mt-2">
                                    <label for="category"><strong>{{ __('admin_local.Course Discount Type') }}
                                    </strong></label>
                                    <select class="js-example-basic-single form-control" name="course_discount_type"
                                        id="course_discount_type">
                                        <option value="Flat">{{ __('admin_local.Flat') }}</option>
                                        <option value="Percent">{{ __('admin_local.Percent') }}</option>
                                    </select>
                                    <span class="text-danger err-mgs" id="course_discount_type_err"></span>
                                </div>
                                <div class="col-lg-4 mt-2">
                                    <label for="category"><strong>{{ __('admin_local.Course Discount Price') }}
                                    </strong></label>
                                    <input type="text" class="form-control" name="course_discount_price" id="course_discount_price" readonly>
                                    <span class="text-danger err-mgs" id="course_discount_price_err"></span>
                                </div>
                                
                                <div class="col-lg-4 mt-2">
                                    <input type="checkbox" name="course_cupon_status" id="course_cupon_status"> 
                                    <label for="category"><strong> {{ __('admin_local.Can use cupon ?') }}</strong></label>
                                </div>
                                <div class="col-lg-5 mt-2">
                                    <input type="checkbox" name="multiple_cupon_status" id="multiple_cupon_status"> 
                                    <label for="category"><strong> {{ __('admin_local.Can use multiple cupon ?') }}</strong></label>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="product_image"><strong>{{ __('admin_local.Course Image / Images') }} </strong> <i
                                            style="font-size: 16px;cursor:pointer"
                                            class="fa fa-exclamation-circle" data-bs-toggle="tooltip"
                                            data-bs-placement="top"
                                            title="{{ __('admin_local.You can upload multiple image. Only .jpeg, .jpg, .png, .gif file can be uploaded. First image will be base image.') }}"></i>
                                    </label>
                                    <div id="dropzoneDragArea" class="dropzone dropzone-info">
                                        <div class="dz-message needsclick"><i class="icon-cloud-up"></i>
                                            <h6>{{ __('admin_local.Drop files here or click to upload') }}.</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="live_field_append" style="display: none;">
                                <div class="col-lg-3 mt-2">
                                    <label for="category"><strong>{{ __('admin_local.Batch Name') }}</strong></label>
                                    <input type="text" class="form-control" name="batch_name" id="batch_name">
                                    <span class="text-danger err-mgs" id="batch_name_err"></span>
                                </div>
                                <div class="col-lg-3 mt-2">
                                    <label for="category"><strong>{{ __('admin_local.Batch Code') }}</strong></label>
                                    <input type="text" class="form-control" name="batch_code" name="batch_code">
                                    <span class="text-danger err-mgs" id="batch_code_err"></span>
                                </div>
                                <div class="col-lg-3 mt-2">
                                    <label for="category"><strong>{{ __('admin_local.Batch Start date') }}</strong></label>
                                    <input type="date" class="form-control" name="batch_start_date" name="batch_start_date">
                                    <span class="text-danger err-mgs" id="batch_start_date_err"></span>
                                </div>
                                <div class="col-lg-3 mt-2">
                                    <label for="category"><strong>{{ __('admin_local.Batch End date') }}</strong></label>
                                    <input type="date" class="form-control" name="batch_end_date" name="batch_end_date">
                                    <span class="text-danger err-mgs" id="batch_end_date_err"></span>
                                </div>
                                <div class="col-lg-3 mt-2">
                                    <label for="category"><strong>{{ __('admin_local.Batch Time') }}</strong></label>
                                    <input type="time" class="form-control" name="batch_time" name="batch_time">
                                    <span class="text-danger err-mgs" id="batch_time_err"></span>
                                </div>
                                <div class="col-lg-6 mt-2">
                                    <label for="category"><strong>{{ __('admin_local.Batch Instructor') }}
                                    </strong></label>
                                    <select class="js-example-placeholder-multiple form-control" name="batch_instructor[]"
                                        id="batch_instructor" multiple>
                                        <option value="">{{ __('admin_local.Select Please') }}</option>
                                        @foreach ($instructors as $instructor)
                                        <option value="{{ $instructor->id }}">{{  $instructor->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger err-mgs" id="batch_instructor_err"></span>
                                </div>
                                <div class="col-lg-3 mt-4">
                                    <input type="checkbox" name="has_enroll_limit" id="has_enroll_limit" onchange="$(this).is(':checked')?$('#enroll_limit_append').show(300):$('#enroll_limit_append').hide(300)"> 
                                    <label for="category"><strong> {{ __('admin_local.Has Enroll Limit ?') }}
                                    </strong></label>
                                </div>
                                <div class="col-lg-3 mt-2" id="enroll_limit_append" style="display:none">
                                    <label for="category"><strong>{{ __('admin_local.Enroll Limit') }}
                                    </strong></label>
                                    <input type="number" min="1" class="form-control" name="enroll_limit" id="enroll_limit" >
                                    <span class="text-danger err-mgs" id="enroll_limit_err"></span>
                                </div>
                            </div>
                            <div class="row" id="pre_recorded_field_append">
                                <div class="col-lg-6 mt-2">
                                    <label for="category"><strong>{{ __('admin_local.Video Group') }}
                                    </strong></label>
                                    <input type="text" class="form-control video_group" name="video_group[]" id="video_group">
                                    <span class="text-danger err-mgs" id="video_group_err"></span>
                                </div>
                                <div class="col-lg-6 mt-2">
                                    <label for="category"><strong>{{ __('admin_local.Video Link') }}
                                    </strong></label>
                                    <input type="text" class="form-control video_link" name="video_link[]" id="video_link">
                                    <span class="text-danger err-mgs" id="video_link_err"></span>
                                </div>
                                <div class="col-lg-6 mt-2">
                                    <label for="category"><strong>{{ __('admin_local.Video Title') }}
                                    </strong></label>
                                    <input type="text" class="form-control video_title" name="video_title[]" id="video_title">
                                    <span class="text-danger err-mgs" id="video_title_err"></span>
                                </div>
                                <div class="col-lg-3 mt-2">
                                    <label for="category"><strong>{{ __('admin_local.Video Duration') }}
                                    </strong></label>
                                    <input type="text" class="form-control video_duration" name="video_duration[]" id="video_duration">
                                    <span class="text-danger err-mgs" id="video_duration_err"></span>
                                </div>
                                <div class="col-lg-3" style="margin-top: 40px">
                                    <button type="button" id="ad_more_video" class="btn btn-primary form-control">+ {{ __('admin_local.Add New') }}</button>
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
    <script src="{{ asset(env('ASSET_DIRECTORY').'/'.'admin/assets/js/sweet-alert/sweetalert.min.js') }}"></script>
    <script src="{{ asset(env('ASSET_DIRECTORY').'/'.'admin/assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset(env('ASSET_DIRECTORY').'/'.'admin/plugins/switchery/switchery.min.js') }}"></script>
    <script src="{{ asset(env('ASSET_DIRECTORY').'/'.'admin/assets/js/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset(env('ASSET_DIRECTORY').'/'.'admin/assets/js/dropzone/dropzone.js') }}"></script>
    <script src="{{ asset(env('ASSET_DIRECTORY').'/'.'admin/assets/js/editor/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset(env('ASSET_DIRECTORY').'/'.'admin/assets/js/editor/ckeditor/adapters/jquery.js') }}"></script>
    <script src="{{ asset(env('ASSET_DIRECTORY').'/'.'admin/assets/js/editor/ckeditor/styles.js') }}"></script>
    <script src="{{ asset(env('ASSET_DIRECTORY').'/'.'admin/assets/js/editor/ckeditor/ckeditor.custom.js') }}"></script>
    <script src="{{ asset(env('ASSET_DIRECTORY').'/'.'admin/plugins/taginputs/bootstrap-tagsinput.js') }}"></script>
    <script src="{{ asset(env('ASSET_DIRECTORY').'/'.'admin/assets/js/datepicker/date-picker/datepicker.js') }}"></script>
    <script src="{{ asset(env('ASSET_DIRECTORY').'/'.'admin/assets/js/datepicker/date-picker/datepicker.en.js') }}"></script>
    <script src="{{ asset(env('ASSET_DIRECTORY').'/'.'admin/assets/js/datepicker/date-picker/datepicker.custom.js') }}"></script>
    <script src="{{ asset(env('ASSET_DIRECTORY').'/'.'admin/assets/js/typeahead/handlebars.js') }}"></script>
    <script src="{{ asset(env('ASSET_DIRECTORY').'/'.'admin/assets/js/typeahead/typeahead.bundle.js') }}"></script>
    {{-- <script src="{{ asset(env('ASSET_DIRECTORY').'/'.'inventory/assets/js/select2/select2-custom.js') }}"></script> --}}

    @foreach (getLangs() as $lang)
        <script>
            CKEDITOR.replace('course_details_'+'{{ $lang->lang }}', {
            on: {
                contentDom: function( evt ) {
                    // Allow custom context menu only with table elemnts.
                    evt.editor.editable().on( 'contextmenu', function( contextEvent ) {
                        var path = evt.editor.elementPath();

                        if ( !path.contains( 'table' ) ) {
                            contextEvent.cancel();
                        }
                    }, null, null, 5 );
                }
            }
        });
        </script>
    @endforeach
    
    <script>
        CKEDITOR.replace('course_details', {
            on: {
                contentDom: function( evt ) {
                    // Allow custom context menu only with table elemnts.
                    evt.editor.editable().on( 'contextmenu', function( contextEvent ) {
                        var path = evt.editor.elementPath();

                        if ( !path.contains( 'table' ) ) {
                            contextEvent.cancel();
                        }
                    }, null, null, 5 );
                }
            }
        });
        $(document).ready(function(){
            $('.js-example-basic-single').each(function(){
                $(this).select2();
            })
            $(".js-example-placeholder-multiple").select2({
                placeholder: "{{ __('admin_local.Select Please') }}"
            });
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

        var form_url = "{{ route('admin.course.store') }}";
        var submit_btn_after = `{{ __('admin_local.Submitting') }}`;
        var submit_btn_before = `{{ __('admin_local.Submit') }}`;
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
    </script>
    <script src="{{ asset(env('ASSET_DIRECTORY').'/'.'admin/custom/course/course.js') }}"></script>
    {{-- <script src="{{ asset(env('ASSET_DIRECTORY').'/'.'inventory/custom/user/user_list.js') }}"></script> --}}
@endpush
