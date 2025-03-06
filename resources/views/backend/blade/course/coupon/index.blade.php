@extends('backend.shared.layouts.admin')
@push('title')
    {{ __('admin_local.Course Coupon') }}
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
                    <h3>{{ __('admin_local.Course Coupon List') }}</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="javascript:void(0)">{{ __('admin_local.Courses') }}</a>
                        </li>
                        <li class="breadcrumb-item active">{{ __('admin_local.Course Coupon List') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    {{-- Add User Modal Start --}}

    <div class="modal fade" id="add-course-coupon-modal" tabindex="-1" aria-labelledby="bs-example-modal-lg"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center" style="border-bottom:1px dashed gray">
                    <h4 class="modal-title" id="myLargeModalLabel">
                        {{ __('admin_local.Add Course Coupon') }}
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <p class="px-3 text-danger"><i>{{ __('admin_local.The field labels marked with * are required input fields.') }}</i>
                </p>
                <div class="modal-body" style="margin-top: -20px">
                    <form method="POST" action="" id="add_coupon_form" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <label for="">{{ __('admin_local.Coupon Code') }}</label>
                                <input type="text" class="form-control" name="coupon_code" id="coupon_code" oninput="$(this).val($(this).val().toUpperCase())">
                                <span class="text-danger err-mgs" id="coupon_code_err"></span>
                            </div>
                            <div class="col-md-4">
                                <label for="">{{ __('admin_local.Discount') }}</label>
                                <input type="text" class="form-control" name="coupon_discount" id="coupon_discount">
                                <span class="text-danger err-mgs" id="coupon_discount_err"></span>
                            </div>
                            <div class="col-md-4">
                                <label for="">{{ __('admin_local.Discount Type') }}</label>
                                <select class="form-control" name="coupon_discount_type" id="coupon_discount_type">
                                    <option value="">{{ __('admin_local.Select Please') }}</option>
                                    <option value="Flat">{{ __('admin_local.Flat') }}</option>
                                    <option value="Percent">{{ __('admin_local.Percent') }}</option>
                                </select>
                                <span class="text-danger err-mgs" id="coupon_discount_type_err"></span>
                            </div>
                            <div class="col-md-4 mt-2">
                                <label for="">{{ __('admin_local.Start Date') }}</label>
                                <input type="date" class="form-control" name="start_date" id="start_date">
                                <span class="text-danger err-mgs" id="start_date_err"></span>
                            </div>
                            <div class="col-md-4 mt-2">
                                <label for="">{{ __('admin_local.End Date') }}</label>
                                <input type="date" class="form-control" name="end_date" id="end_date">
                                <span class="text-danger err-mgs" id="end_date_err"></span>
                            </div>
                            <div class="col-md-4 mt-2">
                                <label for="">{{ __('admin_local.Can Apply') }}</label>
                                <input type="number" class="form-control" name="can_apply" id="can_apply" min="1">
                                <span class="text-danger err-mgs" id="can_apply_err"></span>
                            </div>
                            <div class="col-md-6 mt-2">
                                <input type="checkbox" value="1" name="has_minimum_price" id="has_minimum_price" onchange="$(this).is(':checked')?$('#minimum_price_div').show(300):$('#minimum_price_div').hide(300,function(){$('#minimum_price',this).val('')})">
                                <label for="">&nbsp; {{ __('admin_local.Has minimum price for apply?') }}</label>
                            </div>
                            <div class="col-md-6 mt-2" id="minimum_price_div" style="display: none;">
                                <label for="">{{ __('admin_local.Minimum Price') }}</label>
                                <input type="text" class="form-control" name="minimum_price" id="minimum_price" >
                                <span class="text-danger err-mgs" id="minimum_price_err"></span>
                            </div>
                            <div class="col-md-6 mt-2">
                                <input type="checkbox" value="1" name="has_maximum_discount" id="has_maximum_discount" onchange="$(this).is(':checked')?$('#maximum_discount_div').show(300):$('#maximum_discount_div').hide(300,function(){$('#maximum_discount',this).val('')})">
                                <label for="">&nbsp; {{ __('admin_local.Has maximum discount?') }}</label>
                            </div>
                            <div class="col-md-6 mt-2" id="maximum_discount_div" style="display: none;">
                                <label for="">{{ __('admin_local.Maximum Discount') }}</label>
                                <input type="text" class="form-control" name="maximum_discount" id="maximum_discount" >
                                <span class="text-danger err-mgs" id="maximum_discount_err"></span>
                            </div>
                            <div class="col-md-12 mt-2">
                                <label for="">{{ __('admin_local.Coupon Details') }}</label>
                                <textarea class="form-control" name="coupon_details" id="coupon_details" cols="10" rows="2"></textarea>
                            </div>
                            <div class="col-md-12 mt-2">
                                <label for="">{{ __('admin_local.Applicable Course') }} <i style="font-size: 16px;cursor:pointer"
                                    class="fa fa-exclamation-circle" data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    title="{{ __('admin_local.If it is applicable for selected course then select . If it is applicable for all courses,you do not need to select') }}"></i></label>
                                <select class="form-control" name="course[]" id="course" multiple>
                                    <option value="" disabled>{{ __('admin_local.Select Please') }}</option>
                                    {{-- <option value="All">{{ __('admin_local.All') }}</option> --}}
                                    @foreach ($courses as $course)
                                        <option value="{{ $course->id }}">{{ $course->course_name }} ( {{ $course->subCategory->sub_category_name }} )</option>
                                    @endforeach
                                </select>
                                <span class="text-danger err-mgs" id="course_err"></span>
                            </div>
                            <div class="col-md-12 mt-2">
                                <label for="">{{ __('admin_local.Discount Apply Type') }}</label>
                                <select class="form-control" name="discount_apply_type" id="discount_apply_type">
                                    <option value="">{{ __('admin_local.Select Please') }}</option>
                                    <option value="discount_on_regular_price">{{ __('admin_local.Discount on regular price') }}</option>
                                    <option value="discount_on_discounted_price">{{ __('admin_local.Discount on discounted price') }}</option>
                                    <option value="discount_on_both">{{ __('admin_local.Discount on both') }}</option>
                                </select>
                                <span class="text-danger err-mgs" id="discount_apply_type_err"></span>
                            </div>
                        </div>

                        <div class="row mt-4 mb-2">
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

    {{-- Add User Modal End --}}

    {{-- Add User Modal Start --}}

    <div class="modal fade" id="edit-course-coupon-modal" tabindex="-1" aria-labelledby="bs-example-modal-lg"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center" style="border-bottom:1px dashed gray">
                    <h4 class="modal-title" id="myLargeModalLabel">
                        {{ __('admin_local.Edit Course coupon') }}
                    </h4>
                    <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <p class="px-3 text-danger"><i>{{ __('admin_local.The field labels marked with * are required input fields.') }}</i>
                </p>
                <div class="modal-body" style="margin-top: -20px">
                    <form method="POST" action="" id="edit_coupon_form" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="coupon_id" id="coupon_id" value="">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="">{{ __('admin_local.Coupon Code') }}</label>
                                <input type="text" class="form-control" name="coupon_code" id="coupon_code" oninput="$(this).val($(this).val().toUpperCase())">
                                <span class="text-danger err-mgs" id="coupon_code_err"></span>
                            </div>
                            <div class="col-md-4">
                                <label for="">{{ __('admin_local.Discount') }}</label>
                                <input type="text" class="form-control" name="coupon_discount" id="coupon_discount">
                                <span class="text-danger err-mgs" id="coupon_discount_err"></span>
                            </div>
                            <div class="col-md-4">
                                <label for="">{{ __('admin_local.Discount Type') }}</label>
                                <select class="form-control" name="coupon_discount_type" id="coupon_discount_type">
                                    <option value="">{{ __('admin_local.Select Please') }}</option>
                                    <option value="Flat">{{ __('admin_local.Flat') }}</option>
                                    <option value="Percent">{{ __('admin_local.Percent') }}</option>
                                </select>
                                <span class="text-danger err-mgs" id="coupon_discount_type_err"></span>
                            </div>
                            <div class="col-md-4 mt-2">
                                <label for="">{{ __('admin_local.Start Date') }}</label>
                                <input type="date" class="form-control" name="start_date" id="start_date">
                                <span class="text-danger err-mgs" id="start_date_err"></span>
                            </div>
                            <div class="col-md-4 mt-2">
                                <label for="">{{ __('admin_local.End Date') }}</label>
                                <input type="date" class="form-control" name="end_date" id="end_date">
                                <span class="text-danger err-mgs" id="end_date_err"></span>
                            </div>
                            <div class="col-md-4 mt-2">
                                <label for="">{{ __('admin_local.Can Apply') }}</label>
                                <input type="number" class="form-control" name="can_apply" id="can_apply" min="1">
                                <span class="text-danger err-mgs" id="can_apply_err"></span>
                            </div>
                            <div class="col-md-6 mt-2">
                                <input type="checkbox" value="1" name="has_minimum_price" id="has_minimum_price" onchange="$(this).is(':checked')?$('#minimum_price_div').show(300):$('#minimum_price_div').hide(300,function(){$('#minimum_price',this).val('')})">
                                <label for="">&nbsp; {{ __('admin_local.Has minimum price for apply?') }}</label>
                            </div>
                            <div class="col-md-6 mt-2" id="minimum_price_div" style="display: none;">
                                <label for="">{{ __('admin_local.Minimum Price') }}</label>
                                <input type="text" class="form-control" name="minimum_price" id="minimum_price" >
                                <span class="text-danger err-mgs" id="minimum_price_err"></span>
                            </div>
                            <div class="col-md-6 mt-2">
                                <input type="checkbox" value="1" name="has_maximum_discount" id="has_maximum_discount" onchange="$(this).is(':checked')?$('#maximum_discount_div').show(300):$('#maximum_discount_div').hide(300,function(){$('#maximum_discount',this).val('')})">
                                <label for="">&nbsp; {{ __('admin_local.Has maximum discount?') }}</label>
                            </div>
                            <div class="col-md-6 mt-2" id="maximum_discount_div" style="display: none;">
                                <label for="">{{ __('admin_local.Maximum Discount') }}</label>
                                <input type="text" class="form-control" name="maximum_discount" id="maximum_discount" >
                                <span class="text-danger err-mgs" id="maximum_discount_err"></span>
                            </div>
                            <div class="col-md-12 mt-2">
                                <label for="">{{ __('admin_local.Coupon Details') }}</label>
                                <textarea class="form-control" name="coupon_details" id="coupon_details" cols="10" rows="2"></textarea>
                            </div>
                            <div class="col-md-12 mt-2">
                                <label for="">{{ __('admin_local.Applicable Course') }} <i style="font-size: 16px;cursor:pointer"
                                    class="fa fa-exclamation-circle" data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    title="{{ __('admin_local.If it is applicable for selected course then select . If it is applicable for all courses,you do not need to select') }}"></i></label>
                                <select class="form-control" name="course[]" id="course" multiple="multiple">
                                    <option value="" disabled>{{ __('admin_local.Select Please') }}</option>
                                    {{-- <option value="All">{{ __('admin_local.All') }}</option> --}}
                                    @foreach ($courses as $course)
                                        <option value="{{ $course->id }}">{{ $course->course_name }} ( {{ $course->subCategory->sub_category_name }} )</option>
                                    @endforeach
                                </select>
                                <span class="text-danger err-mgs" id="course_err"></span>
                            </div>
                            <div class="col-md-12 mt-2">
                                <label for="">{{ __('admin_local.Discount Apply Type') }}</label>
                                <select class="form-control" name="discount_apply_type" id="discount_apply_type">
                                    <option value="">{{ __('admin_local.Select Please') }}</option>
                                    <option value="discount_on_regular_price">{{ __('admin_local.Discount on regular price') }}</option>
                                    <option value="discount_on_discounted_price">{{ __('admin_local.Discount on discounted price') }}</option>
                                    <option value="discount_on_both">{{ __('admin_local.Discount on both') }}</option>
                                </select>
                                <span class="text-danger err-mgs" id="discount_apply_type_err"></span>
                            </div>
                        </div>

                        <div class="row mt-4 mb-2">
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

    {{-- Add User Modal End --}}
    <div class="modal fade" id="view-course-coupon-modal" tabindex="-1" aria-labelledby="bs-example-modal-lg"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center" style="border-bottom:1px dashed gray">
                    <h4 class="modal-title" id="myLargeModalLabel">
                        {{ __('admin_local.Coupon Details') }}
                    </h4>
                    <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <p class="px-3 text-danger"><i>{{ __('admin_local.The field labels marked with * are required input fields.') }}</i>
                </p>
                <div class="modal-body" style="margin-top: -20px">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr class="border-bottom-primary bg-dark">
                                <th class="text-white">{{ __('admin_local.Coupon Code') }}</th>
                                <th class="text-white">{{ __('admin_local.Course') }}</th>
                                <th class="text-white">{{ __('admin_local.Coupon Discount') }}</th>
                                <th class="text-white">{{ __('admin_local.Discount Type') }}</th>
                                <th class="text-white">{{ __('admin_local.Course Price') }}</th>
                                <th class="text-white">{{ __('admin_local.Course Discount Price') }}</th>
                                <th class="text-white">{{ __('admin_local.Coupon Applied Price') }}</th>
                            </tr>
                        </thead>
                        <tbody id="coupon_details_table">

                        </tbody>
                    </table>
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
                        <h3 class="card-title mb-0 text-center">{{ __('admin_local.Course coupon List') }}</h3>
                    </div>

                    <div class="card-body">
                        @if (hasPermission(['course-coupon-store']))
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <button class="btn btn-success" type="btn" data-bs-toggle="modal"
                                        data-bs-target="#add-course-coupon-modal">+ {{ __('admin_local.Add coupon') }}</button>
                                </div>
                            </div>
                        @endif

                        <div class="table-responsive theme-scrollbar">
                            <table id="basic-1" class="display table-bordered">
                                <thead>
                                    <tr>
                                        <th>{{ __('admin_local.ID') }}</th>
                                        <th>{{ __('admin_local.Coupon Code') }}</th>
                                        <th>{{ __('admin_local.Coupon Discount') }}</th>
                                        <th>{{ __('admin_local.Discount Type') }}</th>
                                        <th>{{ __('admin_local.Coupon Details') }}</th>
                                        <th>{{ __('admin_local.Applied Courses') }}</th>
                                        <th>{{ __('admin_local.Applied On') }}</th>
                                        <th>{{ __('admin_local.Minimum Amount') }}</th>
                                        <th>{{ __('admin_local.Maximum Discount Amount') }}</th>
                                        <th>{{ __('admin_local.Can Apply') }}</th>
                                        <th>{{ __('admin_local.Start_Date') }}</th>
                                        <th>{{ __('admin_local.End_Date') }}</th>
                                        <th>{{ __('admin_local.Validity') }}</th>
                                        <th>{{ __('admin_local.Coupon Status') }}</th>
                                        <th>{{ __('admin_local.Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($coupons as $coupon)
                                        <tr id="trid-{{ $coupon->id }}"
                                            data-id="{{ $coupon->id }}">
                                            <td>{{ $coupon->id }}</td>
                                            <td>{{ $coupon->coupon }}</td>
                                            <td>{{ $coupon->coupon_discount }}</td>
                                            <td>{{ $coupon->coupon_discount_type }}</td>
                                            <td>{{ $coupon->coupon_details }}</td>
                                            <td>
                                                @if ($coupon->applicable_for==1)
                                                <button type="button" id="coupon_details_view" data-bs-toggle="modal" style="cursor: pointer;"
                                                data-bs-target="#view-course-coupon-modal" class="btn btn-sm btn-info px-1 py-1">{{ __('admin_local.Click Here') }}</button>
                                                @else
                                                <button type="button" class="btn btn-sm btn-success px-1 py-1">{{ __('admin_local.All') }}</button>
                                                @endif
                                                
                                            </td>
                                            <td>{{$coupon->apply_type }}</td>
                                            <td>{{ $coupon->has_minimum_price_for_apply==1?$coupon->minimum_price_for_apply:__('admin_local.N/A') }}</td>
                                            <td>{{ $coupon->has_maximum_discount==1?$coupon->maximum_discount:__('admin_local.N/A') }}</td>
                                            <td>{{ $coupon->can_apply>=1?$coupon->can_apply." ".__('admin_local.Times'):__('admin_local.N/A') }}</td>
                                            <td>{{ $coupon->coupon_start_date }}</td>
                                            <td>{{ $coupon->coupon_end_date }}</td>
                                            <td>
                                                @if (date('Y-m-d',strtotime($coupon->coupon_end_date))>date('Y-m-d'))
                                                    <span class="badge badge-success">{{ __('admin_local.Valid') }}</span>
                                                @else
                                                    <span class="badge badge-danger">{{ __('admin_local.Invalid') }}</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if (hasPermission(['course-coupon-update']))
                                                    <span
                                                        class="mx-2">{{ $coupon->coupon_status == 0 ? 'Inactive' : 'Active' }}</span><input
                                                        data-status="{{ $coupon->coupon_status == 0 ? 1 : 0 }}"
                                                        id="status_change" type="checkbox" data-toggle="switchery"
                                                        data-color="green" data-secondary-color="red" data-size="small"
                                                        {{ $coupon->coupon_status == 1 ? 'checked' : '' }} />
                                                @else
                                                    <span class="badge badge-danger">{{ __('admin_local.No Permission') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if (hasPermission(['course-coupon-update','course-coupon-delete']))
                                                <div class="dropdown">
                                                    <button
                                                        class="btn btn-info text-white px-2 py-1 dropbtn">{{ __('admin_local.Action') }}
                                                        <i class="fa fa-angle-down"></i></button>
                                                    <div class="dropdown-content">
                                                        @if (hasPermission(['course-coupon-update']))
                                                        <a data-bs-toggle="modal" style="cursor: pointer;"
                                                            data-bs-target="#edit-course-coupon-modal" class="text-primary"
                                                            id="edit_button"><i class=" fa fa-edit mx-1"></i>{{ __('admin_local.Edit') }}</a>
                                                        @endif
                                                        @if (hasPermission(['course-coupon-delete']))
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
        $('#add_coupon_form #course').select2({
            multiple:true,
            dropdownParent: $('#add-course-coupon-modal')
        });

        $('#edit_coupon_form #course').select2({
            multiple:true,
            dropdownParent: $('#edit-course-coupon-modal')
        });
        $(document).on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        });
        var oTable = $("#basic-1").DataTable({
            "language": {
                "decimal": "",
                "emptyTable": "{{ __('admin_local.No coupon available in table') }}",
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
            },
            // columnDefs: [{ width: '20%', targets: 1 }]
        });

        var form_url = "{{ route('admin.course.coupon.store') }}";
        var submit_btn_after = `{{ __('admin_local.Submitting') }}`;
        var submit_btn_before = `{{ __('admin_local.Submit') }}`;
        var no_permission_mgs = `{{ __('admin_local.No Permission') }}`;


        var delete_swal_title = `{{ __('admin_local.Are you sure?') }}`;
        var delete_swal_text =
            `{{ __('admin_local.Once deleted, you will not be able to recover this coupon data') }}`;
        var delete_swal_cancel_text = `{{ __('admin_local.Delete request canceld successfully') }}`;
        var no_file = `{{ __('admin_local.No file') }}`;
        var base_url = `{{ baseUrl() }}`;
        var translate_url = `{{ route('admin.translateString') }}`;
    </script>
    <script src="{{ asset(env('ASSET_DIRECTORY').'/'.'admin/custom/course/coupon.js') }}"></script>
    {{-- <script src="{{ asset(env('ASSET_DIRECTORY').'/'.'inventory/custom/user/user_list.js') }}"></script> --}}
@endpush
