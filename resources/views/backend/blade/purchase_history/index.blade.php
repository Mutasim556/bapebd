@extends('backend.shared.layouts.admin')
@push('title')
    {{ __('admin_local.Purchase History') }}
@endpush
@push('css')
    <link rel="stylesheet" href="{{ asset('public/admin/assets/css/custom.css') }}">
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
    
    {{-- Add role Modal Start --}}

    <div class="modal fade" id="add-role-modal" tabindex="-1" aria-labelledby="bs-example-modal-lg" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center" style="border-bottom:1px dashed gray">
                    <h4 class="modal-title" id="myLargeModalLabel">
                        {{ __('admin_local.Create Role') }}
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <p class="px-3 text-danger"><i>{{ __('admin_local.The field labels marked with * are required input fields.') }}</i>
                </p>
                <div class="modal-body" style="margin-top: -20px">
                    <form action="" id="add_role_form">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12 mt-2">
                                <label for="role_name"><strong>{{ __('admin_local.Role Name') }} *</strong></label>
                                <input type="text" class="form-control" name="role_name" id="role_name">
                                <span class="text-danger err-mgs"></span>
                            </div>
                            
                        </div>

                        <div class="row mt-4 mb-2">
                            <div class="form-group col-lg-12">

                                <button class="btn btn-danger text-white font-weight-medium waves-effect text-start"
                                    data-bs-dismiss="modal" style="float: right"
                                    type="button">{{ __('admin_local.Close') }}</button>
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

    {{-- Add role Modal End --}}

    {{-- Add role Modal Start --}}

    <div class="modal fade" id="view-courses-modal" tabindex="-1" aria-labelledby="bs-example-modal-lg" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center" style="border-bottom:1px dashed gray">
                    <h4 class="modal-title" id="myLargeModalLabel">
                        {{ __('admin_local.Edit Role') }}
                    </h4>
                    <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <p class="px-3 text-danger"><i>{{ __('admin_local.The field labels marked with * are required input fields.') }}</i>
                </p>
                <div class="modal-body" style="margin-top: -20px">
                    <div class="row">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="bg-info">{{ __('admin_local.Course ID') }}</th>
                                    <th class="bg-info">{{ __('admin_local.Course Name') }}</th>
                                    <th class="bg-info">{{ __('admin_local.Batch NO') }}</th>
                                    <th class="bg-info">{{ __('admin_local.Course Type') }}</th>
                                </tr>
                            </thead>
                            <tbody id="append_purchased_courses">
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="row mt-4 mb-2">
                        <div class="form-group col-lg-12">
                            <button class="btn btn-danger text-white font-weight-medium waves-effect text-start"
                                data-bs-dismiss="modal" style="float: right"
                                type="button">{{ __('admin_local.Close') }}</button>
                        </div>

                    </div>
                </div>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    {{-- Add role Modal End --}}

    {{-- Add permission to specific user Modal start--}}

    <div class="modal fade" id="gift-course-modal" tabindex="-1" aria-labelledby="bs-example-modal-lg" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center" style="border-bottom:1px dashed gray">
                    <h4 class="modal-title" id="myLargeModalLabel">
                        {{ __('admin_local.Gift a course') }}
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <p class="px-3 text-danger"><i>{{ __('admin_local.The field labels marked with * are required input fields.') }}</i>
                </p>
                <div class="modal-body" style="margin-top: -20px">
                    <form action="" id="gift_course_form">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 mt-2">
                                <label for=""><strong>{{ __('admin_local.Select User') }} *</strong></label>
                                <select class="form-control js-example-basic-single3" name="user_id" id="user_id" required>
                                    <option value="">{{ __('admin_local.Select Please') }}</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name." - ".$user->phone.' - '.$user->email }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger err-mgs"></span>
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for=""><strong>{{ __('admin_local.Select Course') }} *</strong></label>
                                <select class="form-control js-example-basic-single3" name="course_id" id="course_id" required>
                                    <option value="">{{ __('admin_local.Select Please') }}</option>
                                    @foreach ($courses as $course)
                                        <option value="{{ $course->id }}">{{ $course->course_name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger err-mgs"></span>
                            </div>

                            <div class="col-lg-6 mt-2 d-none" id="batch_div">
                                <label for=""><strong>{{ __('admin_local.Select Batch') }} *</strong></label>
                                <select class="form-control js-example-basic-single3" name="course_batch" id="course_batch" >
                                    
                                </select>
                                <span class="text-danger err-mgs"></span>
                            </div>
                        </div>

                        <div class="row mt-4 mb-2">
                            <div class="form-group col-lg-12">

                                <button class="btn btn-danger text-white font-weight-medium waves-effect text-start"
                                    data-bs-dismiss="modal" style="float: right"
                                    type="button">{{ __('admin_local.Close') }}</button>
                                <button class="btn btn-primary mx-2" style="float: right"
                                    type="submit">{{ __('admin_local.Gift') }}</button>
                            </div>

                        </div>
                    </form>
                </div>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    {{-- permission to specific user Modal End --}}



    <div class="container-fluid">
        <div class="row">
            <!-- Column -->
            <div class="col-lg-12 mx-auto">
                <div class="card">
                    <div class="card-header py-3" style="border-bottom: 2px dashed gray">
                        <h3 class="card-title mb-0 text-center">{{ __('admin_local.Purchase History') }}</h3>
                    </div>

                    <div class="card-body">
                        <form method="GET" action="{{ route('admin.purchase-history.index') }}" id="search_formw" >
                            @csrf
                            <div class="row pt-3 pb-2 mb-4" style="background-color:aquamarine;border-radius:10px;">
                                <div class="col-md-3">
                                    <div class="row">
                                        <div class="col-md-4 text-right px-0 py-2" style="text-align:right">
                                            <label for="">{{ __('admin_local.Start Date') }}</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="date" class="form-control" value="{{ request()->start_date??date('Y-m-d') }}" name="start_date" id="start_date">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="row">
                                        <div class="col-md-4 text-right px-0 py-2" style="text-align:right">
                                            <label for="" class="text-right">{{ __('admin_local.End Date') }}</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="date" class="form-control" value="{{  request()->end_date??date('Y-m-d') }}" name="end_date" id="end_date">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-5 text-right px-0 py-2" style="text-align:right">
                                            <label for="" class="float-right">{{ __('admin_local.Payment Status') }}</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select name="payment_status" id="payment_status" class="form-control">
                                                <option value="0" {{  request()->payment_status&&request()->payment_status==0?'selected':''}} {{ request()->payment_status?'':'selected' }}>{{ __('admin_local.Unpaid') }}</option>
                                                <option value="1" {{ request()->payment_status&&request()->payment_status==1?'selected':'' }}>{{ __('admin_local.Paid') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                    <div class="col-md-2">
                                    <label for=""></label>
                                    <button type="submit" class="btn btn-info" id="search_btn">{{ __('admin_local.Search') }}</button>
                                </div>
                            </div>
                        </form>
                        
                        <div class="row mb-3 mt-2">
                            @if (hasPermission(['specific-permission-create']))
                            <div class="col-md-9 offset-md-3">
                                <button class="btn btn-outline-success" style="float:right" type="btn" data-bs-toggle="modal"
                                    data-bs-target="#gift-course-modal">+  {{ __('admin_local.Gift A Course')}}</button>
                            </div>
                            @endif
                        </div> 
                        
                        <div class="table-responsive theme-scrollbar" id="append_data_table">
                            <table id="basic-1" class="display table-bordered">
                                <thead>
                                    <tr>
                                        <th>{{ __('admin_local.ID') }}</th>
                                        <th>{{ __('admin_local.Phone') }}</th>
                                        <th>{{ __('admin_local.Total Amount') }}</th>
                                        <th>{{ __('admin_local.Discount Amount') }}</th>
                                        <th>{{ __('admin_local.Subtotal') }}</th>
                                        <th>{{ __('admin_local.Payment Method') }}</th>
                                        <th>{{ __('admin_local.Payment Option') }}</th>
                                        <th>{{ __('admin_local.Transaction ID') }}</th>
                                        <th>{{ __('admin_local.Payment Status') }}</th>
                                        <th>{{ __('admin_local.Date') }}</th>
                                        <th>{{ __('admin_local.Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($purchases as $purchase)
                                        <tr data-id="{{ $purchase->id }}">
                                            <td>{{ $purchase->id }}</td>
                                            <td>{{ $purchase->phone??__('admin_local.Empty') }}</td>
                                            <td>{{ $purchase->total_amount }}</td>
                                            <td>{{ $purchase->discount_amount }}</td>
                                            <td>{{ $purchase->subtotal }}</td>
                                            <td>{{ $purchase->payment_method }}</td>
                                            <td>{{ $purchase->payment_option }}</td>
                                            <td>{{ $purchase->transaction_id }}</td>
                                            <td>{{ date('Y-m-d',strtotime($purchase->created_at)) }}</td>
                                            <td class="text-center">
                                                @if (hasPermission(['purchase-history-update']))
                                                    <span
                                                        class="mx-2">{{ $purchase->payment_status == 0 ? 'Unpaid' : 'Paid' }}</span><input
                                                        data-status="{{ $purchase->payment_status == 0 ? 1 : 0 }}"
                                                        id="status_change" type="checkbox" data-toggle="switchery"
                                                        data-color="green" data-secondary-color="red" data-size="small"
                                                        {{ $purchase->payment_status == 1 ? 'checked' : '' }} />
                                                @else
                                                    <span class="badge badge-danger">{{ __('admin_local.No Permission') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                 @if (hasPermission(['purchase-history-update','purchase-history-delete']))
                                                <div class="dropdown">
                                                    <button
                                                        class="btn btn-info text-white px-2 py-1 dropbtn">{{ __('admin_local.Action') }}
                                                        <i class="fa fa-angle-down"></i></button>
                                                    <div class="dropdown-content">
                                                        @if (hasPermission(['purchase-history-update']))
                                                        <a data-bs-toggle="modal" style="cursor: pointer;"
                                                            data-bs-target="#view-courses-modal" class="text-primary"
                                                            id="view_course"><i class=" fa fa-edit mx-1"></i>{{ __('admin_local.Edit') }}</a>
                                                        @endif
                                                        @if (hasPermission(['course-category-delete']))
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
    <script src="{{ asset('public/admin/assets/js/sweet-alert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('public/admin/assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('public/admin/plugins/switchery/switchery.min.js') }}"></script>
    <script src="{{ asset('public/admin/assets/js/select2/select2.full.min.js') }}"></script>
    <script>
        $('[data-toggle="switchery"]').each(function(idx, obj) {
            new Switchery($(this)[0], $(this).data());
        });
        $('.js-example-basic-single').select2({
            dropdownParent: $('#add-role-modal')
        });
        $('.js-example-basic-single1').select2({
            dropdownParent: $('#edit-role-modal')
        });
        $('.js-example-basic-single3').select2({
            dropdownParent: $('#gift_course_form')
        });
        $(document).on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        });
        var oTable = $("#basic-1").DataTable({
            columnDefs: [{ width: 20, targets: 0 },{ width: 80, targets: 1 },{ width: 60, targets: 3 }],
             order: [[0, 'desc'],[8, 'desc']]
        });

        var no_permission = `<span class="badge badge-danger">{{ __('admin_local.No Permission') }}</span>`;
        var submit_btn_after = `{{ __('admin_local.Searching') }}`;
        var submit_btn_before = `{{ __('admin_local.Search') }}`;
        var form_url = `{{ route('admin.purchase-history.store') }}`;
        var csrf  = `@csrf`
    </script>
    <script src="{{ asset('public/admin/custom/purchase_history/purchase_history.js') }}"></script>
@endpush
