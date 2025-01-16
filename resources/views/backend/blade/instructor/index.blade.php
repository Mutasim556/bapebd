@extends('backend.shared.layouts.admin')
@push('title')
    {{ __('admin_local.Instructor List') }}
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
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6">
                    <h3>{{ __('admin_local.Instructor List') }}</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="javascript:void(0)">{{ __('admin_local.Instructor') }}</a>
                        </li>
                        <li class="breadcrumb-item active">{{ __('admin_local.Instructor List') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    {{-- Add instructor Modal Start --}}

    <div class="modal fade" id="add-instructor-modal" tabindex="-1" aria-labelledby="bs-example-modal-lg" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center" style="border-bottom:1px dashed gray">
                    <h4 class="modal-title" id="myLargeModalLabel">
                        {{ __('admin_local.Add Instructor') }}
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <p class="px-3 text-danger"><i>{{ __('admin_local.The field labels marked with * are required input fields.') }}</i>
                </p>
                <div class="modal-body" style="margin-top: -20px">
                    <form action="" id="add_instructor_form">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 mt-2">
                                <label for="instructor_name"><strong>{{ __('admin_local.Full Name') }} *</strong></label>
                                <input type="text" class="form-control" name="instructor_name" id="instructor_name">
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="instructorname"><strong>{{ __('admin_local.Username') }} *</strong></label>
                                <input type="text" class="form-control" name="instructorname" id="instructorname">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 mt-2">
                                <label for="instructor_password"><strong>{{ __('admin_local.Password') }} *</strong></label>
                                <input type="password" class="form-control" name="instructor_password" id="instructor_password">
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="instructor_role"><strong>{{ __('admin_local.Role') }} *</strong></label>
                                <select class="form-control" name="instructor_role" id="instructor_role" disabled>
                                    {{-- <option value="" selected disabled>{{ __("admin_local.Select Please") }}</option> --}}
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}" {{ userRoleName()!='Super Admin'&&$role->name==='Super Admin'?'disabled':''}}>{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 mt-2">
                                <label for="instructor_email"><strong>{{ __('admin_local.Email') }} *</strong></label>
                                <input type="email" class="form-control" name="instructor_email" id="instructor_email">
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="instructor_phone"><strong>{{ __('admin_local.Phone') }} *</strong></label>
                                <input type="text" class="form-control" name="instructor_phone" id="instructor_phone">
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

    {{-- Add instructor Modal End --}}

    {{-- Edit instructor Modal Start --}}

    <div class="modal fade" id="edit-instructor-modal" tabindex="-1" aria-labelledby="bs-example-modal-lg" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center" style="border-bottom:1px dashed gray">
                    <h4 class="modal-title" id="myLargeModalLabel">
                        {{ __('admin_local.Edit Instructor') }}
                    </h4>
                    <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <p class="px-3 text-danger"><i>{{ __('admin_local.The field labels marked with * are required input fields.') }}</i>
                </p>
                <div class="modal-body" style="margin-top: -20px">
                    <form action="" id="edit_instructor_form">
                        @csrf
                        <input type="hidden" id="instructor_id" name="instructor_id" value="">
                        <div class="row">
                            <div class="col-lg-6 mt-2">
                                <label for="instructor_name"><strong>{{ __('admin_local.Full Name') }} *</strong></label>
                                <input type="text" class="form-control" name="instructor_name" id="instructor_name">
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="instructorname"><strong>{{ __('admin_local.Username') }} *</strong></label>
                                <input type="text" class="form-control" name="instructorname" id="instructorname">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 mt-2">
                                <label for="instructor_password"><strong>{{ __('admin_local.Password') }} *</strong></label>
                                <input type="password" class="form-control" name="instructor_password" id="instructor_password">
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="instructor_role"><strong>{{ __('admin_local.Role') }} *</strong></label>
                                <select class="form-control" name="instructor_role" id="instructor_role" disabled>
                                    {{-- <option value="" selected disabled>{{ __("admin_local.Select Please") }}</option> --}}
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}" {{ userRoleName()!='Super Admin'&&$role->name==='Super Admin'?'disabled':''}}>{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 mt-2">
                                <label for="instructor_email"><strong>{{ __('admin_local.Email') }} *</strong></label>
                                <input type="email" class="form-control" name="instructor_email" id="instructor_email">
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="instructor_phone"><strong>{{ __('admin_local.Phone') }} *</strong></label>
                                <input type="text" class="form-control" name="instructor_phone" id="instructor_phone">
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

    {{-- Edit instructor Modal End --}}



    <div class="container-fluid">
        <div class="row">
            <!-- Column -->
            <div class="col-lg-11 mx-auto">
                <div class="card">
                    <div class="card-header py-3" style="border-bottom: 2px dashed gray">
                        <h3 class="card-title mb-0 text-center">{{ __('admin_local.instructor List') }}</h3>
                    </div>

                    <div class="card-body">
                        @if (hasPermission(['instructor-create']))
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <button class="btn btn-success" type="btn" data-bs-toggle="modal"
                                        data-bs-target="#add-instructor-modal">+ {{ __('admin_local.Add Instructor') }}</button>
                                </div>
                            </div>
                        @endif
                        <div class="table-responsive theme-scrollbar">
                            <table id="basic-1" class="display table-bordered">
                                <thead>
                                    <tr>
                                        <th>{{ __('admin_local.Full Name') }}</th>
                                        <th>{{ __('admin_local.Email') }}</th>
                                        <th>{{ __('admin_local.Phone') }}</th>
                                        <th>{{ __('admin_local.User Name') }}</th>
                                        <th>{{ __('admin_local.Role') }}</th>
                                        <th>{{ __('admin_local.Status') }}</th>
                                        <th>{{ __('admin_local.Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($instructors as $instructor)
                                        <tr id="tr-{{ $instructor->id }}" data-id="{{ $instructor->id }}">
                                            <td>{{ $instructor->name }}</td>
                                            <td>{{ $instructor->email }}</td>
                                            <td>{{ $instructor->phone }}</td>
                                            <td>{{ $instructor->username }}</td>
                                            <td>
                                                {{ $instructor->getRoleNames()->first() }}
                                            </td>
                                            <td class="text-center">
                                                @if ($instructor->getRoleNames()->first()==='Super Admin')
                                                    <span class="badge badge-warning">{{ __('admin_local.Not Changeable') }}</span>
                                                @else
                                                    @if (hasPermission(['instructor-update']))
                                                        <span class="mx-2">{{ $instructor->status==1?'Active':'Inactive' }}</span><input
                                                        data-status="{{ $instructor->status == 1 ? 0 : 1 }}"
                                                        id="status_change" type="checkbox" data-toggle="switchery"
                                                        data-color="green" data-secondary-color="red" data-size="small"
                                                        {{ $instructor->status == 1 ? 'checked' : '' }} {{ $instructor->id==Auth::guard('admin')->user()->id?'disabled':'' }}/>
                                                    @else
                                                        <span class="badge badge-danger">{{ __('admin_local.No Permission') }}</span>
                                                    @endif
                                                    
                                                @endif
                                               
                                            </td>
                                            <td>
                                                @if (hasPermission(['instructor-update','instructor-delete']))
                                                @if ($instructor->id===Auth::guard('admin')->user()->id)
                                                    <span class="badge badge-danger">{{ __('admin_local.No Permission') }}</span>
                                                @elseif ($instructor->getRoleNames()->first()==='Super Admin')
                                                    <span class="badge badge-warning">{{ __('admin_local.Not Changeable') }}</span>
                                                @else
                                                    <div class="dropdown ">
                                                        <button
                                                            class="btn btn-info text-white px-2 py-1 dropbtn">{{ __('admin_local.Action') }}
                                                            <i class="fa fa-angle-down"></i></button>
                                                        <div class="dropdown-content">
                                                            @if (hasPermission(['instructor-update']))
                                                                <a data-bs-toggle="modal" style="cursor: pointer;"
                                                                    data-bs-target="#edit-instructor-modal" class="text-primary"
                                                                    id="edit_button"><i class=" fa fa-edit mx-1"></i>{{ __('admin_local.Edit') }}</a>
                                                            @endif
                                                            @if (hasPermission(['instructor-delete']))
                                                                <a class="text-danger" id="delete_button"
                                                                style="cursor: pointer;"><i class="fa fa-trash mx-1"></i>
                                                                {{ __('admin_local.Delete') }}</a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endif
                                                
                                                @else
                                                    @if ($instructor->getRoleNames()->first()==='Super Admin')
                                                    <span class="badge badge-warning">{{ __('admin_local.Not Changeable') }}</span>
                                                    @else
                                                    <span class="badge badge-danger">{{ __('admin_local.No Permission') }}</span>
                                                    @endif
                                                    
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

    <script>
        $('[data-toggle="switchery"]').each(function(idx, obj) {
            new Switchery($(this)[0], $(this).data());
        });
        var oTable = $("#basic-1").DataTable({
            columnDefs: [{ width: 60, targets: 6 }],
        });

        var form_url = "{{ route('admin.instructor.store') }}";
    </script>
    <script src="{{ asset('public/admin/custom/instructor/create_instructor.js') }}"></script>
    <script src="{{ asset('public/admin/custom/instructor/instructor_list.js') }}"></script> 
@endpush
