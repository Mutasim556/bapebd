@extends('backend.shared.layouts.admin')
@push('title')
    {{ __('admin_local.Course Comment') }}
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


    {{-- Add User Modal Start --}}

    <div class="modal fade" id="add-comments-modal" tabindex="-1" aria-labelledby="bs-example-modal-lg"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center" style="border-bottom:1px dashed gray">
                    <h4 class="modal-title" id="myLargeModalLabel">
                        {{ __('admin_local.Add Comment') }}
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <p class="px-3 text-danger"><i>{{ __('admin_local.The field labels marked with * are required input fields.') }}</i>
                </p>
                <div class="modal-body" style="margin-top: -20px">
                    <form method="POST" action="" id="add_comment_form" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 mt-2">
                                <label for="student_name"><strong>{{ __('admin_local.Student Name') }} ({{ __('admin_local.Default') }})
                                        *</strong></label>
                                <input type="text" class="form-control" name="student_name"
                                    id="student_name">
                                <span class="text-danger err-mgs"></span>
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="student_department"><strong>{{ __('admin_local.Student Department') }} *</strong></label>
                                <input type="text" class="form-control" name="student_department" id="student_department">
                                <span class="text-danger err-mgs"></span>
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="student_rating"><strong>{{ __('admin_local.Student Rating') }} *</strong></label>
                                <input type="number" min="1" max="5" class="form-control" name="student_rating" id="student_rating">
                                <span class="text-danger err-mgs"></span>
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="student_image"><strong>{{ __('admin_local.Student Image') }}
                                    </strong></label>
                                <input type="file" class="form-control" name="student_image"
                                    id="student_image" accept="image/png, image/gif, image/jpeg , image/jpg">
                                <span class="text-danger err-mgs"></span>
                            </div>
                            <div class="col-lg-12 mt-2">
                                <label for="comment"><strong>{{ __('admin_local.Comemnts') }} ({{__('admin_local.Default')}}) *</strong></label>
                                <textarea class="form-control" name="comment" id="comment"></textarea>
                                <span class="text-danger err-mgs"></span>
                            </div>

                            <div class="col-lg-6 mt-2">
                                <input type="checkbox" name="translate_autometic" id="translate_autometic" > &nbsp;
                                <label for="category_name"><strong>{{ __('admin_local.Translate Autometic') }}</strong></label>
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="category_name"><strong  id="append_loader"></strong></label>
                            </div>
                            @foreach (getLangs() as $lang)
                            <div class="col-lg-12 mt-2">
                                <label for="comment"><strong>{{ __('admin_local.Comments') }} ( {{ $lang->name }} )
                                    *</strong></label>
                                <textarea class="form-control" name="comment_{{ $lang->lang }}"
                                    id="comment_{{ $lang->lang }}"></textarea>
                                <span class="text-danger err-mgs"></span>
                            </div>
                            @endforeach

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

    <div class="modal fade" id="edit-comment-modal" tabindex="-1" aria-labelledby="bs-example-modal-lg"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center" style="border-bottom:1px dashed gray">
                    <h4 class="modal-title" id="myLargeModalLabel">
                        {{ __('admin_local.Edit Comments') }}
                    </h4>
                    <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <p class="px-3 text-danger"><i>{{ __('admin_local.The field labels marked with * are required input fields.') }}</i>
                </p>
                <div class="modal-body" style="margin-top: -20px">
                    <form id="edit_comment_form" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="comment_id" name="comment_id" value="">
                        <div class="row">
                            <div class="col-lg-6 mt-2">
                                <label for="student_name"><strong>{{ __('admin_local.Student Name') }} ({{ __('admin_local.Default') }})
                                        *</strong></label>
                                <input type="text" class="form-control" name="student_name"
                                    id="student_name">
                                <span class="text-danger err-mgs"></span>
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="student_department"><strong>{{ __('admin_local.Student Department') }} *</strong></label>
                                <input type="text" class="form-control" name="student_department" id="student_department">
                                <span class="text-danger err-mgs"></span>
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="student_rating"><strong>{{ __('admin_local.Student Rating') }} *</strong></label>
                                <input type="number" max="5" min="1" class="form-control" name="student_rating" id="student_rating">
                                <span class="text-danger err-mgs"></span>
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="student_image"><strong>{{ __('admin_local.Student Image') }}
                                    </strong></label>
                                <input type="file" class="form-control" name="student_image"
                                    id="student_image" accept="image/png, image/gif, image/jpeg , image/jpg">
                                <span class="text-danger err-mgs"></span>
                            </div>
                            <div class="col-lg-12 mt-2">
                                <label for="comment"><strong>{{ __('admin_local.Comemnts') }} ({{__('admin_local.Default')}}) *</strong></label>
                                <textarea class="form-control" name="comment" id="comment"></textarea>
                                <span class="text-danger err-mgs"></span>
                            </div>

                            <div class="col-lg-6 mt-2">
                                <input type="checkbox" name="translate_autometic" id="translate_autometic" > &nbsp;
                                <label for="category_name"><strong>{{ __('admin_local.Translate Autometic') }}</strong></label>
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="category_name"><strong  id="append_loader"></strong></label>
                            </div>
                            @foreach (getLangs() as $lang)
                            <div class="col-lg-12 mt-2">
                                <label for="comment"><strong>{{ __('admin_local.Comments') }} ( {{ $lang->name }} )
                                    *</strong></label>
                                <textarea class="form-control" name="comment_{{ $lang->lang }}"
                                    id="comment_{{ $lang->lang }}"></textarea>
                                <span class="text-danger err-mgs"></span>
                            </div>
                            @endforeach

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

    {{-- Add User Modal End --}}



    <div class="container-fluid">
        <div class="row">
            <!-- Column -->
            <div class="col-lg-12 mx-auto">
                <div class="card">
                    <div class="card-header py-3" style="border-bottom: 2px dashed gray">
                        <h3 class="card-title mb-0 text-center">{{ __('admin_local.Comment List') }}</h3>
                    </div>

                    <div class="card-body">
                        @if (hasPermission(['comments-store']))
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <button class="btn btn-success" type="btn" data-bs-toggle="modal"
                                        data-bs-target="#add-comments-modal">+ {{ __('admin_local.Add Comments') }}</button>
                                </div>
                            </div>
                        @endif

                        <div class="table-responsive theme-scrollbar">
                            <table id="basic-1" class="display table-bordered">
                                <thead>
                                    <tr>
                                        <th>{{ __('admin_local.Student Name') }}</th>
                                        <th>{{ __('admin_local.Student Department') }}</th>
                                        <th>{{ __('admin_local.Student Image') }}</th>
                                        <th>{{ __('admin_local.Student Rating') }}</th>
                                        <th>{{ __('admin_local.Comment') }}</th>
                                        <th>{{ __('admin_local.Status') }}</th>
                                        <th>{{ __('admin_local.Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($comments as $comment)
                                        <tr id="trid-{{ $comment->id }}"
                                            data-id="{{ $comment->id }}">
                                            <td>{{ $comment->student_name }}</td>
                                            <td>{{ $comment->student_department }}</td>
                                            <td>
                                                @if ($comment->student_image)
                                                    <img src="{{ asset('public/'.$comment->student_image) }}"
                                                        alt="" style="height:">
                                                @else
                                                    {{ __('admin_local.No file') }}
                                                @endif
                                            </td>
                                            <td>{{ $comment->student_rating }}</td>
                                            <td>{{ $comment->comment }}</td>
                                            <td class="text-center">
                                                @if (hasPermission(['comments-update']))
                                                    <span
                                                        class="mx-2">{{ $comment->status == 0 ? 'Inactive' : 'Active' }}</span><input
                                                        data-status="{{ $comment->status == 0 ? 1 : 0 }}"
                                                        id="status_change" type="checkbox" data-toggle="switchery"
                                                        data-color="green" data-secondary-color="red" data-size="small"
                                                        {{ $comment->status == 1 ? 'checked' : '' }} />
                                                @else
                                                    <span class="badge badge-danger">{{ __('admin_local.No Permission') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if (hasPermission(['comments-update','comments-delete']))
                                                <div class="dropdown">
                                                    <button
                                                        class="btn btn-info text-white px-2 py-1 dropbtn">{{ __('admin_local.Action') }}
                                                        <i class="fa fa-angle-down"></i></button>
                                                    <div class="dropdown-content">
                                                        @if (hasPermission(['comments-update']))
                                                        <a data-bs-toggle="modal" style="cursor: pointer;"
                                                            data-bs-target="#edit-comment-modal" class="text-primary"
                                                            id="edit_button"><i class=" fa fa-edit mx-1"></i>{{ __('admin_local.Edit') }}</a>
                                                        @endif
                                                        @if (hasPermission(['comments-delete']))
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
        $('.js-example-basic-single1').select2({
            dropdownParent: $('#edit-brand-modal')
        });
        $(document).on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        });
        var oTable = $("#basic-1").DataTable({
            "language": {
                "decimal": "",
                "emptyTable": "{{ __('admin_local.No comments available in table') }}",
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

        var form_url = "{{ route('admin.settings.comments.store') }}";
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
    <script src="{{ asset(env('ASSET_DIRECTORY').'/'.'admin/custom/settings/comments.js') }}"></script>
    {{-- <script src="{{ asset(env('ASSET_DIRECTORY').'/'.'inventory/custom/user/user_list.js') }}"></script> --}}
@endpush
