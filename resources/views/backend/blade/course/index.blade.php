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

    {{-- Add User Modal Start --}}

    <div class="modal fade" id="add-course-course-modal" tabindex="-1" aria-labelledby="bs-example-modal-lg"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center" style="border-bottom:1px dashed gray">
                    <h4 class="modal-title" id="myLargeModalLabel">
                        {{ __('admin_local.Add Course course') }}
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <p class="px-3 text-danger"><i>{{ __('admin_local.The field labels marked with * are required input fields.') }}</i>
                </p>
                <div class="modal-body" style="margin-top: -20px">
                    <form method="POSt" action="" id="add_course_form" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            
                            
                            <div class="col-lg-6 mt-2">
                                <label for="course_name"><strong>{{ __('admin_local.course Name') }} ({{ __('admin_local.Default') }}) 
                                        *</strong></label>
                                <input type="text" class="form-control" name="course_name"
                                    id="course_name">
                                <span class="text-danger err-mgs"></span>
                            </div>
                            <div class="col-lg-6 mt-2">
                                <input type="checkbox" name="translate_autometic" id="translate_autometic" > &nbsp;
                                <label for="course_name"><strong>{{ __('admin_local.Translate Autometic') }}</strong></label>
                            </div>
                            @foreach (getLangs() as $lang)
                            <div class="col-lg-6 mt-2">
                                <label for="course_name"><strong>{{ __('admin_local.course Name') }} ( {{ $lang->name }} ) 
                                    *</strong></label>
                                <input type="text" class="form-control" name="course_name_{{ $lang->lang }}"
                                    id="course_name_{{ $lang->lang }}">
                                <span class="text-danger err-mgs"></span>
                            </div>
                            @endforeach
                            <div class="col-lg-6 mt-2">
                                <label for="course_image"><strong>{{ __('admin_local.course Image') }}
                                    </strong></label>
                                <input type="file" class="form-control" name="course_image"
                                    id="course_image" accept="image/png, image/gif, image/jpeg">
                                <span class="text-danger err-mgs"></span>
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
                <div class="modal-body" style="margin-top: -20px">
                    
                </div>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    {{-- Add User Modal End --}}



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
                                        <th>{{ __('admin_local.Cuppon Apply Status') }}</th>
                                        <th>{{ __('admin_local.Multiple Cuppon Apply Status') }}</th>
                                        <th>{{ __('admin_local.Course Status') }}</th>
                                        <th>{{ __('admin_local.Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($courses as $course)
                                        <tr id="trid-{{ $course->id }}" onclick="getCoursedetails({{ $course->id }})" data-id="{{ $course->id }}" data-bs-toggle="modal" data-bs-target="#view-course-modal" style="cursor: pointer;">
                                            <td>{{ $course->course_name }}</td>
                                            <td>{{ $course->category->category_name }}</td>
                                            <td>{{ $course->subCategory->sub_category_name }}</td>
                                            <td>{{ $course->course_headline }}</td>
                                            <td>{{ $course->no_of_videos }}</td>
                                            <td>{{ $course->course_duration." ".$course->course_duration_type }}{{ $course->course_duration>1?'s':'' }}</td>
                                            <td>{{ $course->course_type }}</td>
                                            <td>{{ $course->course_price." ".$course->course_price_currency }}</td>
                                            <td>{{ $course->course_discount}}{{ $course->course_discount_type=='Flat'?' /-':' %' }}</td>
                                            <td>{{ $course->course_discount_price." ".$course->course_price_currency }}</td>
                                            <td>{{ $course->enrolled_count }}</td>
                                            <td>{!! $course->course_cupon_status==1?'<span class="badge badge-success">'.__('admin_local.Yes').'</span >':'<span class="badge badge-danger">'.__('admin_local.No').'</span>' !!}</td>
                                            <td>{!! $course->course_multiple_cupon_status==1?'<span class="badge badge-success">'.__('admin_local.Yes').'</span >':'<span class="badge badge-danger">'.__('admin_local.No').'</span>' !!}</td>
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
                                                        <a data-bs-toggle="modal" style="cursor: pointer;"
                                                            data-bs-target="#edit-course-course-modal" class="text-primary"
                                                            id="edit_button"><i class=" fa fa-edit mx-1"></i>{{ __('admin_local.Edit') }}</a>
                                                        @endif
                                                        @if (hasPermission(['course-cuppon-apply']))
                                                        <a data-bs-toggle="modal" style="cursor: pointer;"
                                                            data-bs-target="#edit-course-course-modal" class="text-primary"
                                                            id="edit_button"><i class=" fa fa-tags mx-1"></i>{{ __('admin_local.Apply Cuppon') }}</a>
                                                        @endif
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


        var delete_swal_title = `{{ __('admin_local.Are you sure?') }}`;
        var delete_swal_text =
            `{{ __('admin_local.Once deleted, you will not be able to recover this size data') }}`;
        var delete_swal_cancel_text = `{{ __('admin_local.Delete request canceld successfully') }}`;
        var no_file = `{{ __('admin_local.No file') }}`;
        var base_url = `{{ baseUrl() }}`;
        var translate_url = `{{ route('admin.translateString') }}`;
    </script>
     <script src="{{ asset(env('ASSET_DIRECTORY') . '/' . 'admin/custom/course/course_list.js') }}"></script>
    {{-- <script src="{{ asset(env('ASSET_DIRECTORY').'/'.'inventory/custom/user/user_list.js') }}"></script> --}}
@endpush
