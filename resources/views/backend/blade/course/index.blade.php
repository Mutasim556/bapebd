@extends('backend.shared.layouts.admin')
@push('title')
    {{ __('admin_local.Courses') }}
@endpush
@push('css')
    <link rel="stylesheet" href="{{ asset(env('ASSET_DIRECTORY').'/'.'admin/assets/css/custom.css') }}">
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
    </style>
@endpush
@section('content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6">
                    <h3>{{ __('admin_local.Course List') }}</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="javascript:void(0)">{{ __('admin_local.Courses') }}</a>
                        </li>
                        <li class="breadcrumb-item active">{{ __('admin_local.View Courses') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    

    {{-- Add User Modal End --}}

    {{-- Add User Modal Start --}}

    <div class="modal fade" id="view-course-modal" tabindex="-1" aria-labelledby="bs-example-modal-lg"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center" style="border-bottom:1px dashed gray">
                    <h4 class="modal-title" id="myLargeModalLabel">
                        {{ __('admin_local.View Other Details') }}
                    </h4>
                    <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <input type="hidden" id="selected_video_course_id" value="">
                <div class="modal-body" id="modal_body_1" style="display:none">
                    <h4 class="text-center">{{ __('admin_local.Course Batches') }}</h4>
                    <div class="table-responsive theme-scrollbar">
                        @if (hasPermission(['course-batch-create']))
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <a class="btn btn-success" type="button" onclick="$('#add-live-modal #course_id').val($('#selected_video_course_id').val())" data-bs-toggle="modal" data-bs-target="#add-live-modal" >+ {{ __('admin_local.Create Batch') }}</a>
                                </div>
                            </div>
                        @endif
                        <table id="batch_details_append" class="display table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>{{ __('admin_local.Batch Name') }}</th>
                                    <th>{{ __('admin_local.Batch Code') }}</th>
                                    <th>{{ __('admin_local.Batch Instructor') }}</th>
                                    <th>{{ __('admin_local.Batch Start Date') }}</th>
                                    <th>{{ __('admin_local.Batch End Date') }}</th>
                                    <th>{{ __('admin_local.Batch Time') }}</th>
                                    <th>{{ __('admin_local.Enroll Limit') }}</th>
                                    <th>{{ __('admin_local.Enrolled Count') }}</th>
                                    <th>{{ __('admin_local.Live In') }}</th>
                                    <th>{{ __('admin_local.Link/Address') }}</th>
                                    <th>{{ __('admin_local.Batch Status') }}</th>
                                    <th>{{ __('admin_local.Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                    <div class="row mt-2">
                        <div class="form-group col-lg-12">

                            <button class="btn btn-danger text-white font-weight-medium waves-effect text-start"
                                data-bs-dismiss="modal" style="float: right" type="button">{{ __('admin_local.Close') }}</button>
                            {{-- <button class="btn btn-primary mx-2" style="float: right"
                                type="submit">{{ __('admin_local.Submit') }}</button> --}}
                        </div>

                    </div>
                </div>
                <div class="modal-body" id="modal_body_2" style="display:none">
                    <h4 class="text-center">{{ __('admin_local.Course Videos') }}</h4>
                    <div class="table-responsive theme-scrollbar">
                        
                        @if (hasPermission(['course-video-create']))
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <a class="btn btn-success" type="button" onclick="$('#add-recorded-modal #course_id').val($('#selected_video_course_id').val())" data-bs-toggle="modal" data-bs-target="#add-recorded-modal" >+ {{ __('admin_local.Add Course Video') }}</a>
                                </div>
                            </div>
                        @endif
                        <table id="batch_details_append2" class="display table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>{{ __('admin_local.Video No') }}</th>
                                    <th>{{ __('admin_local.Video Group') }}</th>
                                    <th>{{ __('admin_local.Video Title') }}</th>
                                    <th>{{ __('admin_local.Video File') }}</th>
                                    <th>{{ __('admin_local.Video Link') }}</th>
                                    <th>{{ __('admin_local.Duration') }}</th>
                                    <th>{{ __('admin_local.Type') }}</th>
                                    <th>{{ __('admin_local.Video Status') }}</th>
                                    <th>{{ __('admin_local.Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                    <div class="row mt-2">
                        <div class="form-group col-lg-12">

                            <button class="btn btn-danger text-white font-weight-medium waves-effect text-start"
                                data-bs-dismiss="modal" style="float: right" type="button">{{ __('admin_local.Close') }}</button>
                            {{-- <button class="btn btn-primary mx-2" style="float: right"
                                type="submit">{{ __('admin_local.Submit') }}</button> --}}
                        </div>

                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    {{-- Add User Modal End --}}
{{-- Add User Modal Start --}}

        <div class="modal fade" id="edit-recorded-modal" tabindex="-1" aria-labelledby="bs-example-modal-lg"
        aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header d-flex bg-info align-items-center" style="border-bottom:1px dashed gray">
                        <h4 class="modal-title" id="myLargeModalLabel">
                            {{ __('admin_local.Edit Video') }}
                        </h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <p class="px-3 text-danger"><i>{{ __('admin_local.The field labels marked with * are required input fields.') }}</i>
                    </p>
                    <div class="modal-body" style="margin-top: -20px">
                        <form method="POST" action="" id="edit_video_form" enctype="multipart/form-data">
                            @csrf
                           <div class="row">
                            <input type="hidden" class="form-control" name="video_id" id="video_id" value="">
                                <div class="form-group col-md-3">
                                    <label for="">{{ __('admin_local.Video No') }} *</label>
                                    <input type="number" class="form-control" name="video_no" id="video_no">
                                    <span class="text-danger err-mgs" id="video_no_err"></span>
                                </div>
                                <div class="form-group col-md-9">
                                    <label for="">{{ __('admin_local.Video Group') }} *</label>
                                    <input type="text" class="form-control" name="video_group" id="video_group">
                                    <span class="text-danger err-mgs" id="video_group_err"></span>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="">{{ __('admin_local.Video Title') }} *</label>
                                    <input type="text" class="form-control" name="video_title" id="video_title">
                                    <span class="text-danger err-mgs" id="video_title_err"></span>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="">{{ __('admin_local.Video File') }} *</label>
                                    <input type="file" class="form-control" name="video_file" id="video_file">
                                    <span class="text-danger err-mgs" id="video_file_err"></span>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="">{{ __('admin_local.Video Link') }} *</label>
                                    <input type="text" class="form-control" name="video_link" id="video_link">
                                    <span class="text-danger err-mgs" id="video_link_err"></span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="">{{ __('admin_local.Video Duration') }} *</label>
                                    <input type="text" class="form-control" name="video_duration" id="video_duration">
                                    <span class="text-danger err-mgs" id="video_duration_err"></span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="">{{ __('admin_local.Video Type') }} *</label>
                                    <select class="form-control" name="video_type" id="video_type">
                                        <option value="">{{ __('admin_local.Select Please') }}</option>
                                        <option value="Paid">{{ __('admin_local.Paid') }}</option>
                                        <option value="Free">{{ __('admin_local.Free') }}</option>
                                    </select>
                                    <span class="text-danger err-mgs" id="video_type_err"></span>
                                </div>
                           </div>
                           <div class="row mt-2">
                                <div class="form-group col-lg-12">
                                    <button class="btn btn-danger text-white font-weight-medium waves-effect text-start"
                                        data-bs-dismiss="modal" style="float: right" type="button">{{ __('admin_local.Close') }}</button>
                                    <button class="btn btn-primary mx-2" style="float: right"
                                        type="submit">{{ __('admin_local.Submit') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
                <!-- /.modal-content -->
            </div>
        <!-- /.modal-dialog -->
        </div>

        <div class="modal fade" id="add-recorded-modal" tabindex="-1" aria-labelledby="bs-example-modal-lg"
        aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header d-flex bg-primary align-items-center" style="border-bottom:1px dashed gray">
                        <h4 class="modal-title" id="myLargeModalLabel">
                            {{ __('admin_local.Add Video') }}
                        </h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <p class="px-3 text-danger"><i>{{ __('admin_local.The field labels marked with * are required input fields.') }}</i>
                    </p>
                    <div class="modal-body" style="margin-top: -20px">
                        <form method="POST" action="" id="add_video_form" enctype="multipart/form-data">
                            @csrf
                           <div class="row">
                                <input type="hidden" class="form-control" name="course_id" id="course_id" value="">
                                <div class="form-group col-md-3">
                                    <label for="">{{ __('admin_local.Video No') }} *</label>
                                    <input type="number" class="form-control" name="video_no" id="video_no">
                                    <span class="text-danger err-mgs" id="video_no_err"></span>
                                </div>
                                <div class="form-group col-md-9">
                                    <label for="">{{ __('admin_local.Video Group') }} *</label>
                                    <input type="text" class="form-control" name="video_group" id="video_group">
                                    <span class="text-danger err-mgs" id="video_group_err"></span>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="">{{ __('admin_local.Video Title') }} *</label>
                                    <input type="text" class="form-control" name="video_title" id="video_title">
                                    <span class="text-danger err-mgs" id="video_title_err"></span>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="">{{ __('admin_local.Video File') }} </label>
                                    <input type="file" class="form-control" name="video_file" id="video_file">
                                    <span class="text-danger err-mgs" id="video_file_err"></span>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="">{{ __('admin_local.Video Link') }} *</label>
                                    <input type="text" class="form-control" name="video_link" id="video_link">
                                    <span class="text-danger err-mgs" id="video_link_err"></span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="">{{ __('admin_local.Video Duration') }} *</label>
                                    <input type="text" class="form-control" name="video_duration" id="video_duration">
                                    <span class="text-danger err-mgs" id="video_duration_err"></span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="">{{ __('admin_local.Video Type') }} *</label>
                                    <select class="form-control" name="video_type" id="video_type">
                                        <option value="">{{ __('admin_local.Select Please') }}</option>
                                        <option value="Paid">{{ __('admin_local.Paid') }}</option>
                                        <option value="Free">{{ __('admin_local.Free') }}</option>
                                    </select>
                                    <span class="text-danger err-mgs" id="video_type_err"></span>
                                </div>
                           </div>
                           <div class="row mt-2">
                                <div class="form-group col-lg-12">
                                    <button class="btn btn-danger text-white font-weight-medium waves-effect text-start"
                                        data-bs-dismiss="modal" style="float: right" type="button">{{ __('admin_local.Close') }}</button>
                                    <button class="btn btn-primary mx-2" style="float: right"
                                        type="submit">{{ __('admin_local.Submit') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
                <!-- /.modal-content -->
            </div>
        <!-- /.modal-dialog -->
        </div>

        <div class="modal fade" id="edit-live-modal" tabindex="-1" aria-labelledby="bs-example-modal-lg"
        aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header d-flex align-items-center bg-info" style="border-bottom:1px dashed gray">
                        <h4 class="modal-title" id="myLargeModalLabel">
                            {{ __('admin_local.Edit Batch') }}
                        </h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <p class="px-3 text-danger"><i>{{ __('admin_local.The field labels marked with * are required input fields.') }}</i>
                    </p>
                    <div class="modal-body" style="margin-top: -20px">
                        <form method="POST" action="" id="edit_batch_form" enctype="multipart/form-data">
                            @csrf
                           <div class="row">
                            <input type="hidden" class="form-control" name="batch_id" id="batch_id" value="">
                                <div class="form-group col-md-3">
                                    <label for="">{{ __('admin_local.Batch Name') }} *</label>
                                    <input type="text" class="form-control" name="batch_name" id="batch_name">
                                    <span class="text-danger err-mgs" id="batch_name_err"></span>
                                </div>
                                <div class="form-group col-md-9">
                                    <label for="">{{ __('admin_local.Batch Code') }} *</label>
                                    <input type="text" class="form-control" name="batch_code" id="batch_code">
                                    <span class="text-danger err-mgs" id="batch_code_err"></span>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="">{{ __('admin_local.Batch Istructor') }} *</label>
                                    <select class="col-sm-12" name="batch_instructor"
                                    id="batch_instructor">
                                    <option value="">{{ __('admin_local.Select Please') }}</option>
                                    @foreach ($instructors as $instructor)
                                        <option value="{{ $instructor->id }}">{{ $instructor->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger err-mgs" id="batch_instructor_err"></span>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="">{{ __('admin_local.Batch Start Date') }} *</label>
                                    <input type="date" class="form-control" name="batch_start_date" id="batch_start_date">
                                    <span class="text-danger err-mgs" id="batch_start_date_err"></span>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="">{{ __('admin_local.Batch End Date') }} *</label>
                                    <input type="date" class="form-control" name="batch_end_date" id="batch_end_date">
                                    <span class="text-danger err-mgs" id="batch_end_date_err"></span>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="">{{ __('admin_local.Batch Time') }} *</label>
                                    <input type="time" class="form-control" name="batch_time" id="batch_time">
                                    <span class="text-danger err-mgs" id="batch_time_err"></span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="">{{ __('admin_local.Enroll Limit') }} *</label>
                                    <input type="number" class="form-control" name="enroll_limit" id="enroll_limit">
                                    <span class="text-danger err-mgs" id="enroll_limit_err"></span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="">{{ __('admin_local.Live In') }} *</label>
                                    <select class="form-control" name="live_in" id="live_in">
                                        <option value="">{{ __('admin_local.Select Please') }}</option>
                                        <option value="Google Meet">{{ __("admin_local.Google Meet") }}</option>
                                        <option value="Zoom">{{ __("admin_local.Zoom") }}</option>
                                        <option value="Physical Class">{{ __("admin_local.Physical Class") }}</option>
                                    </select>
                                    <span class="text-danger err-mgs" id="live_in_err"></span>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="">{{ __('admin_local.Link/Address') }} *</label>
                                    <input type="text" class="form-control" name="link_or_address" id="link_or_address">
                                    <span class="text-danger err-mgs" id="link_or_address_err"></span>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="">{{ __('admin_local.Batch Day') }} *</label>
                                    <select class="form-control" name="batch_day[]" id="batch_day" multiple>
                                        <option value="" disabled>{{ __('admin_local.Select Please') }}</option>
                                        <option value="Staturday">{{ __('admin_local.Staturday') }}</option>
                                        <option value="Sunday">{{ __('admin_local.Sunday') }}</option>
                                        <option value="Monday">{{ __('admin_local.Monday') }}</option>
                                        <option value="Tuesday">{{ __('admin_local.Tuesday') }}</option>
                                        <option value="Wednesday">{{ __('admin_local.Wednesday') }}</option>
                                        <option value="Thursday">{{ __('admin_local.Thursday') }}</option>
                                        <option value="Friday">{{ __('admin_local.Friday') }}</option>
                                    </select>
                                    <span class="text-danger err-mgs" id="batch_day_err"></span>
                                </div>
                           </div>
                           <div class="row mt-2">
                                <div class="form-group col-lg-12">
                                    <button class="btn btn-danger text-white font-weight-medium waves-effect text-start"
                                        data-bs-dismiss="modal" style="float: right" type="button">{{ __('admin_local.Close') }}</button>
                                    <button class="btn btn-primary mx-2" style="float: right"
                                        type="submit">{{ __('admin_local.Submit') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
                <!-- /.modal-content -->
            </div>
        <!-- /.modal-dialog -->
        </div>

        <div class="modal fade" id="add-live-modal" tabindex="-1" aria-labelledby="bs-example-modal-lg"
        aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header d-flex align-items-center bg-primary" style="border-bottom:1px dashed gray">
                        <h4 class="modal-title" id="myLargeModalLabel">
                            {{ __('admin_local.Add Batch') }}
                        </h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <p class="px-3 text-danger"><i>{{ __('admin_local.The field labels marked with * are required input fields.') }}</i>
                    </p>
                    <div class="modal-body" style="margin-top: -20px">
                        <form method="POST" action="" id="add_batch_form" enctype="multipart/form-data">
                            @csrf
                           <div class="row">
                            <input type="hidden" class="form-control" name="course_id" id="course_id" value="">
                                <div class="form-group col-md-3">
                                    <label for="">{{ __('admin_local.Batch Name') }} *</label>
                                    <input type="text" class="form-control" name="batch_name" id="batch_name">
                                    <span class="text-danger err-mgs" id="batch_name_err"></span>
                                </div>
                                <div class="form-group col-md-9">
                                    <label for="">{{ __('admin_local.Batch Code') }} *</label>
                                    <input type="text" class="form-control" name="batch_code" id="batch_code">
                                    <span class="text-danger err-mgs" id="batch_code_err"></span>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="">{{ __('admin_local.Batch Istructor') }} *</label>
                                    <select class="col-sm-12" name="batch_instructor"
                                    id="batch_instructor">
                                    <option value="">{{ __('admin_local.Select Please') }}</option>
                                    @foreach ($instructors as $instructor)
                                        <option value="{{ $instructor->id }}">{{ $instructor->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger err-mgs" id="batch_instructor_err"></span>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="">{{ __('admin_local.Batch Start Date') }} *</label>
                                    <input type="date" class="form-control" name="batch_start_date" id="batch_start_date">
                                    <span class="text-danger err-mgs" id="batch_start_date_err"></span>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="">{{ __('admin_local.Batch End Date') }} *</label>
                                    <input type="date" class="form-control" name="batch_end_date" id="batch_end_date">
                                    <span class="text-danger err-mgs" id="batch_end_date_err"></span>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="">{{ __('admin_local.Batch Time') }} *</label>
                                    <input type="time" class="form-control" name="batch_time" id="batch_time">
                                    <span class="text-danger err-mgs" id="batch_time_err"></span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="">{{ __('admin_local.Enroll Limit') }} </label>
                                    <input type="number" class="form-control" name="enroll_limit" id="enroll_limit">
                                    <span class="text-danger err-mgs" id="enroll_limit_err"></span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="">{{ __('admin_local.Live In') }} *</label>
                                    <select class="form-control" name="live_in" id="live_in">
                                        <option value="">{{ __('admin_local.Select Please') }}</option>
                                        <option value="Google Meet">{{ __("admin_local.Google Meet") }}</option>
                                        <option value="Zoom">{{ __("admin_local.Zoom") }}</option>
                                        <option value="Physical Class">{{ __("admin_local.Physical Class") }}</option>
                                    </select>
                                    <span class="text-danger err-mgs" id="live_in_err"></span>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="">{{ __('admin_local.Link/Address') }} *</label>
                                    <input type="text" class="form-control" name="link_or_address" id="link_or_address">
                                    <span class="text-danger err-mgs" id="link_or_address_err"></span>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="">{{ __('admin_local.Batch Day') }} *</label>
                                    <select class="form-control" name="batch_day[]" id="batch_day" multiple>
                                        <option value="" selected disabled>{{ __('admin_local.Select Please') }}</option>
                                        <option value="Staturday">{{ __('admin_local.Staturday') }}</option>
                                        <option value="Sunday">{{ __('admin_local.Sunday') }}</option>
                                        <option value="Monday">{{ __('admin_local.Monday') }}</option>
                                        <option value="Tuesday">{{ __('admin_local.Tuesday') }}</option>
                                        <option value="Wednesday">{{ __('admin_local.Wednesday') }}</option>
                                        <option value="Thursday">{{ __('admin_local.Thursday') }}</option>
                                        <option value="Friday">{{ __('admin_local.Friday') }}</option>
                                    </select>
                                    <span class="text-danger err-mgs" id="batch_day_err"></span>
                                </div>
                           </div>
                           <div class="row mt-2">
                                <div class="form-group col-lg-12">
                                    <button class="btn btn-danger text-white font-weight-medium waves-effect text-start"
                                        data-bs-dismiss="modal" style="float: right" type="button">{{ __('admin_local.Close') }}</button>
                                    <button class="btn btn-primary mx-2" style="float: right"
                                        type="submit">{{ __('admin_local.Submit') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
                <!-- /.modal-content -->
            </div>
        <!-- /.modal-dialog -->
        </div>


    <div class="container-fluid">
        <div class="row">
            <!-- Column -->
            <div class="col-lg-12 mx-auto">
                <div class="card">
                    <div class="card-header py-3" style="border-bottom: 2px dashed gray">
                        <h3 class="card-title mb-0 text-center">{{ __('admin_local.Course List') }}</h3>
                    </div>

                    <div class="card-body">
                        @if (hasPermission(['course-store']))
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <a class="btn btn-success" type="btn" href="{{ route('admin.course.create') }}">+ {{ __('admin_local.Add Course') }}</a>
                                </div>
                            </div>
                        @endif

                        <div class="table-responsive theme-scrollbar">
                            <table id="basic-1" class="display table-bordered text-center">
                                <thead>
                                    <tr>
                                        <th>{{ __('admin_local.Course Name') }}</th>
                                        <th>{{ __('admin_local.Course Category') }}</th>
                                        <th>{{ __('admin_local.Course Sub-category') }}</th>
                                        <th>{{ __('admin_local.Course Headline') }}</th>
                                        <th>{{ __('admin_local.No of Video/Class') }}</th>
                                        <th>{{ __('admin_local.Course Duration') }}</th>
                                        <th>{{ __('admin_local.Course Type') }}</th>
                                        <th>{{ __('admin_local.Course Price') }}</th>
                                        <th>{{ __('admin_local.Course Discount') }}</th>
                                        <th>{{ __('admin_local.Discount Price') }}</th>
                                        <th>{{ __('admin_local.Total Enroll') }}</th>
                                        <th>{{ __('admin_local.Coupon Apply Status') }}</th>
                                        <th>{{ __('admin_local.Multiple Coupon Apply Status') }}</th>
                                        <th>{{ __('admin_local.Course Status') }}</th>
                                        <th>{{ __('admin_local.Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($courses as $course)
                                        <tr id="trid-{{ $course->id }}" data-id="{{ $course->id }}" >
                                            <td onclick="getCoursedetails({{ $course->id }})" data-bs-toggle="modal" data-bs-target="#view-course-modal" style="cursor: pointer;">{{ $course->course_name }}</td>
                                            <td onclick="getCoursedetails({{ $course->id }})" data-bs-toggle="modal" data-bs-target="#view-course-modal" style="cursor: pointer;">{{ $course->category->category_name }}</td>
                                            <td onclick="getCoursedetails({{ $course->id }})" data-bs-toggle="modal" data-bs-target="#view-course-modal" style="cursor: pointer;">{{ $course->subCategory->sub_category_name }}</td>
                                            <td onclick="getCoursedetails({{ $course->id }})" data-bs-toggle="modal" data-bs-target="#view-course-modal" style="cursor: pointer;">{{ $course->course_headline }}</td>
                                            <td onclick="getCoursedetails({{ $course->id }})" data-bs-toggle="modal" data-bs-target="#view-course-modal" style="cursor: pointer;">{{ $course->no_of_videos }}</td>
                                            <td onclick="getCoursedetails({{ $course->id }})" data-bs-toggle="modal" data-bs-target="#view-course-modal" style="cursor: pointer;">{{ $course->course_duration." ".$course->course_duration_type }}{{ $course->course_duration>1?'s':'' }}</td>
                                            <td onclick="getCoursedetails({{ $course->id }})" data-bs-toggle="modal" data-bs-target="#view-course-modal" style="cursor: pointer;">{{ $course->course_type }}</td>
                                            <td onclick="getCoursedetails({{ $course->id }})" data-bs-toggle="modal" data-bs-target="#view-course-modal" style="cursor: pointer;">{{ $course->course_price." ".$course->course_price_currency }}</td>
                                            <td onclick="getCoursedetails({{ $course->id }})" data-bs-toggle="modal" data-bs-target="#view-course-modal" style="cursor: pointer;">{{ $course->course_discount}}{{ $course->course_discount_type=='Flat'?' /-':' %' }}</td>
                                            <td onclick="getCoursedetails({{ $course->id }})" data-bs-toggle="modal" data-bs-target="#view-course-modal" style="cursor: pointer;">{{ $course->course_discount_price." ".$course->course_price_currency }}</td>
                                            <td onclick="getCoursedetails({{ $course->id }})" data-bs-toggle="modal" data-bs-target="#view-course-modal" style="cursor: pointer;">{{ $course->enrolled_count }}</td>
                                            <td onclick="getCoursedetails({{ $course->id }})" data-bs-toggle="modal" data-bs-target="#view-course-modal" style="cursor: pointer;">{!! $course->course_cupon_status==1?'<span class="badge badge-success">'.__('admin_local.Yes').'</span >':'<span class="badge badge-danger">'.__('admin_local.No').'</span>' !!}</td>
                                            <td onclick="getCoursedetails({{ $course->id }})" data-bs-toggle="modal" data-bs-target="#view-course-modal" style="cursor: pointer;">{!! $course->course_multiple_cupon_status==1?'<span class="badge badge-success">'.__('admin_local.Yes').'</span >':'<span class="badge badge-danger">'.__('admin_local.No').'</span>' !!}</td>
                                            <td class="text-center">
                                                @if (hasPermission(['course-update']))
                                                    <span class="mx-2">{{ $course->course_status == 0 ? __('admin_local.Inactive') : __('admin_local.Active') }}</span><input
                                                        data-status="{{ $course->course_status == 0 ? 1 : 0 }}"
                                                        id="status_change" type="checkbox" data-toggle="switchery"
                                                        data-color="green" data-secondary-color="red" data-size="small"
                                                        {{ $course->course_status == 1 ? 'checked' : '' }} />
                                                @else
                                                    <span class="badge badge-danger">{{ __('admin_local.No Permission') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if (hasPermission(['course-update','course-delete']))
                                                <div class="dropdown">
                                                    <button
                                                        class="btn btn-info text-white px-2 py-1 dropbtn">{{ __('admin_local.Action') }}
                                                        <i class="fa fa-angle-down"></i></button>
                                                    <div class="dropdown-content">
                                                        @if (hasPermission(['course-update']))
                                                        <a style="cursor: pointer;" href="{{ route('admin.course.edit',$course->id) }}"><i class=" fa fa-edit mx-1"></i>{{ __('admin_local.Edit') }}</a>
                                                        @endif
                                                        {{-- @if (hasPermission(['course-cuppon-apply']))
                                                        <a data-bs-toggle="modal" style="cursor: pointer;"
                                                            data-bs-target="#edit-course-course-modal" class="text-primary"
                                                            id="edit_button"><i class=" fa fa-tags mx-1"></i>{{ __('admin_local.Apply Cuppon') }}</a>
                                                        @endif --}}
                                                        @if (hasPermission(['course-delete']))
                                                        <a class="text-danger" id="delete_button"
                                                            style="cursor: pointer;"><i class="fa fa-trash mx-1"></i>
                                                            {{ __('admin_local.Delete') }}</a>
                                                        @endif
                                                    </div>
                                                </div>
                                                @else
                                                <span class="badge badge-danger">{{ __('admin_local.No Permission') }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @csrf
                        </div>
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
    <script src="{{ asset(env('ASSET_DIRECTORY').'/'.'admin/assets/js/datatable/datatable-extension/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset(env('ASSET_DIRECTORY').'/'.'admin/assets/js/datatable/datatable-extension/jszip.min.js') }}"></script>
    <script src="{{ asset(env('ASSET_DIRECTORY').'/'.'admin/assets/js/datatable/datatable-extension/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset(env('ASSET_DIRECTORY').'/'.'admin/assets/js/datatable/datatable-extension/pdfmake.min.js') }}"></script>
    <script src="{{ asset(env('ASSET_DIRECTORY').'/'.'admin/assets/js/datatable/datatable-extension/vfs_fonts.js') }}"></script>
    <script src="{{ asset(env('ASSET_DIRECTORY').'/'.'admin/assets/js/datatable/datatable-extension/dataTables.autoFill.min.js') }}"></script>
    <script src="{{ asset(env('ASSET_DIRECTORY').'/'.'admin/assets/js/datatable/datatable-extension/dataTables.select.min.js') }}"></script>
    <script src="{{ asset(env('ASSET_DIRECTORY').'/'.'admin/assets/js/datatable/datatable-extension/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset(env('ASSET_DIRECTORY').'/'.'admin/assets/js/datatable/datatable-extension/buttons.html5.min.js') }}"></script>
    <script src="{{ asset(env('ASSET_DIRECTORY').'/'.'admin/assets/js/datatable/datatable-extension/buttons.print.min.js') }}"></script>
    <script src="{{ asset(env('ASSET_DIRECTORY').'/'.'admin/assets/js/datatable/datatable-extension/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset(env('ASSET_DIRECTORY').'/'.'admin/assets/js/datatable/datatable-extension/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset(env('ASSET_DIRECTORY').'/'.'admin/assets/js/datatable/datatable-extension/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset(env('ASSET_DIRECTORY').'/'.'admin/assets/js/datatable/datatable-extension/dataTables.keyTable.min.js') }}"></script>
    <script src="{{ asset(env('ASSET_DIRECTORY').'/'.'admin/assets/js/datatable/datatable-extension/dataTables.colReorder.min.js') }}"></script>
    <script src="{{ asset(env('ASSET_DIRECTORY').'/'.'admin/assets/js/datatable/datatable-extension/dataTables.fixedHeader.min.js') }}"></script>
    <script src="{{ asset(env('ASSET_DIRECTORY').'/'.'admin/assets/js/datatable/datatable-extension/dataTables.rowReorder.min.js') }}"></script>
    <script src="{{ asset(env('ASSET_DIRECTORY').'/'.'admin/assets/js/datatable/datatable-extension/dataTables.scroller.min.js') }}"></script>
    {{-- <script src="{{ asset(env('ASSET_DIRECTORY').'/'.'admin/assets/js/modal-animated.js') }}"></script> --}}
    <script src="{{ asset(env('ASSET_DIRECTORY').'/'.'admin/assets/js/owlcarousel/owl.carousel.js') }}"></script>
    {{-- <script src="{{ asset(env('ASSET_DIRECTORY').'/'.'admin/assets/js/owlcarousel/owl-custom.j') }}s"></script> --}}
    <script src="{{ asset(env('ASSET_DIRECTORY').'/'.'admin/plugins/switchery/switchery.min.js') }}"></script>
    <script src="{{ asset(env('ASSET_DIRECTORY').'/'.'admin/assets/js/select2/select2.full.min.js') }}"></script>
    {{-- <script src="{{ asset(env('ASSET_DIRECTORY').'/'.'inventory/assets/js/select2/select2-custom.js') }}"></script> --}}
    
    <script>
       
        $('[data-toggle="switchery"]').each(function(idx, obj) {
            new Switchery($(this)[0], $(this).data());
        });
        $('.js-example-basic-single').select2({
            dropdownParent: $('#add-brand-modal')
        });
        $('.js-example-basic-single1').select2({
            dropdownParent: $('#edit-brand-modal')
        });
        $('#batch_instructor').select2({
            dropdownParent: $('#edit-live-modal')
        });
        $('#add_batch_form #batch_instructor').select2({
            dropdownParent: $('#add-live-modal')
        });
        $(document).on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        });
        var oTable = $("#basic-1").DataTable({
            "language": {
                "decimal": "",
                "emptyTable": "{{ __('admin_local.No course available in table') }}",
                "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                "infoEmpty": "Showing 0 to 0 of 0 entries",
                "infoFiltered": "(filtered from _MAX_ total entries)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Show _MENU_ entries",
                "loadingRecords": "Loading...",
                "processing": "",
                "search": "{{ __('admin_local.Search') }}:",
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
            },
            dom: 'Blfrtip',
            select: true,
            dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            buttons: [
                {
                    "extend": 'excel',
                    "text": '<i class="fa fa-file-excel-o" style="font-size:18px;"></i>',
                    title : '',
                    'className': 'btn btn-success btn-square py-1 px-3',
                        exportOptions: {
                        columns: [0, 1, 2, 5]
                    }
                },{
                    "extend": 'pdf',
                    "text": '<i class="fa fa-file-pdf-o" style="font-size:18px;"></i>',
                    'className': 'btn btn-danger btn-square py-1 px-3'
                },{
                    "extend": 'print',
                    "text": '<i class="fa fa-print" style="font-size:18px;"></i>',
                    'className': 'btn btn-info btn-square py-1 px-3'
                }
            ],
            columnDefs: [
                {
                    width: 20, 
                    targets: 0
                }, {
                    width: 80,
                    targets: 13
                }, {
                    width: 80,
                    targets: 14
                }
            ],
        });

        


        var form_url = "{{ route('admin.course.store') }}";
        var submit_btn_after = `{{ __('admin_local.Submitting') }}`;
        var submit_btn_before = `{{ __('admin_local.Submit') }}`;
        var no_permission_mgs = `{{ __('admin_local.No Permission') }}`;
        var click_here = `{{ __('admin_local.Click Here') }}`;


        var delete_swal_title = `{{ __('admin_local.Are you sure?') }}`;
        var delete_swal_text =
            `{{ __('admin_local.Once deleted, you will not be able to recover this data') }}`;
        var delete_swal_cancel_text = `{{ __('admin_local.Delete request canceld successfully') }}`;
        var no_file = `{{ __('admin_local.No file') }}`;
        var base_url = `{{ baseUrl() }}`;
        var translate_url = `{{ route('admin.translateString') }}`;
    </script>
     <script src="{{ asset(env('ASSET_DIRECTORY') . '/' . 'admin/custom/course/course_list.js') }}"></script>
    {{-- <script src="{{ asset(env('ASSET_DIRECTORY').'/'.'inventory/custom/user/user_list.js') }}"></script> --}}
@endpush
