@extends('backend.shared.layouts.admin')
@push('title')
    {{ __('admin_local.User Messages') }}
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
    <div class="modal fade" id="edit-user-message-modal" tabindex="-1" aria-labelledby="bs-example-modal-lg"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center" style="border-bottom:1px dashed gray">
                    <h4 class="modal-title" id="myLargeModalLabel">
                        {{ __('admin_local.Reply Message') }}
                    </h4>
                    <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <p class="px-3 text-danger"><i>{{ __('admin_local.The field labels marked with * are required input fields.') }}</i>
                </p>
                <div class="modal-body" style="margin-top: -20px">
                    <form id="reply_message_form" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="message_id" name="message_id" value="">
                        <div class="row">
                            <div class="col-lg-12 mt-2">
                                <label for="reply_type"><strong>{{ __('admin_local.Reply Type') }} *</strong></label>
                                <select class="form-control" name="reply_type" id="reply_type" >
                                    <option value="Email">{{ __('admin_local.Email') }}</option>
                                    <option value="Message">{{ __('admin_local.Message') }}</option>
                                </select>
                                <span class="text-danger err-mgs"></span>
                            </div>
                            <div class="col-lg-12 mt-2" id="mail_subject_div">
                                <label for="mail_subject"><strong>{{ __('admin_local.Mail Subject') }} *</strong></label>
                                <input type="text" class="form-control" name="mail_subject"
                                    id="mail_subject">
                                <span class="text-danger err-mgs"></span>
                            </div>
                            <div class="col-lg-12 mt-2">
                                <label for="message"><strong>{{ __('admin_local.Message') }}</strong></label>
                                <textarea class="form-control" id="message" readonly></textarea>
                                <span class="text-danger err-mgs"></span>
                            </div>
                            <div class="col-lg-12 mt-2">
                                <label for="reply_message"><strong>{{ __('admin_local.Reply Message') }} *</strong></label>
                                <textarea class="form-control" id="reply_message" name="reply_message"></textarea>
                                <span class="text-danger err-mgs"></span>
                            </div>
                        </div>

                        <div class="row mt-4 mb-2">
                            <div class="form-group col-lg-12">
                                <button class="btn btn-danger text-white font-weight-medium waves-effect text-start"
                                    data-bs-dismiss="modal" style="float: right"
                                    type="button">{{ __('admin_local.Close') }}</button>
                                <button class="btn btn-primary mx-2" style="float: right"
                                    type="submit" id="submit_btn">{{ __('admin_local.Submit') }}</button>
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
                        <h3 class="card-title mb-0 text-center">{{ __('admin_local.User Messages') }}</h3>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('admin.getUserMessages') }}" method="GET">
                            {{-- @csrf --}}
                            <div class="row bg-primary rounded p-4 mb-3">
                                <div class="col-md-5">
                                    <div class="row">
                                        <label for="" class="col-md-4 text-right" style="text-align: right;">{{ __('admin_local.Start Date') }}</label>
                                        <div class="col-md-8">
                                            <input type="date" class="form-control" name="start_date" value="{{ isset(request()->start_date)?request()->start_date:date('Y-m-d') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="row">
                                        <label for="" class="col-md-4" style="text-align: right;">{{ __('admin_local.End Date') }}</label>
                                        <div class="col-md-8">
                                            <input type="date" class="form-control" name="end_date" value="{{ isset(request()->end_date)?request()->end_date:date('Y-m-d') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-info" type="submit">{{ __('admin_local.Search') }}</button>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive theme-scrollbar">
                            <table id="basic-1" class="display table-bordered">
                                <thead>
                                    <tr>
                                        <th>{{ __('admin_local.Name') }}</th>
                                        <th>{{ __('admin_local.Phone') }}</th>
                                        <th>{{ __('admin_local.Email') }}</th>
                                        <th>{{ __('admin_local.Subject') }}</th>
                                        <th>{{ __('admin_local.Message') }}</th>
                                        <th>{{ __('admin_local.Reply Status') }}</th>
                                        <th>{{ __('admin_local.Replied By') }}</th>
                                        <th>{{ __('admin_local.Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($messages as $message)
                                        <tr data-id="{{ $message->id }}" id="trid-{{ $message->id }}">
                                            <td>{{ $message->name }}</td>
                                            <td>{{ $message->phone }}</td>
                                            <td>{{ $message->email }}</td>
                                            <td>{{ $message->subjectDetails->category_name }}</td>
                                            <td>{{ $message->message }}</td>
                                            <td>{{ $message->reply_status==0?__('admin_local.Not replied'):__('admin_local.Replied') }}</td>
                                            <td>{{ $message->replied_by?$message->repliedBy->name:'N/A' }}</td>
                                            <td>
                                                @if (hasPermission(['user-message-reply','user-message-delete']))
                                                <div class="dropdown">
                                                    <button class="btn btn-info text-white px-2 py-1 dropbtn" style="font-size: 12px;">{{ __('admin_local.Action') }}
                                                        <i class="fa fa-angle-down"></i></button>
                                                    <div class="dropdown-content" >
                                                        @if (hasPermission(['user-message-reply']))
                                                        <a data-bs-toggle="modal" style="cursor: pointer;"
                                                            data-bs-target="#edit-user-message-modal" class="text-primary"
                                                            id="edit_button"><i class=" fa fa-edit mx-1"></i>{{ __('admin_local.Reply') }}</a>
                                                        @endif
                                                        @if (hasPermission(['user-message-delete']))
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
            dropdownParent: $('#add-slider-modal')
        });
        $('.js-example-basic-single1').select2({
            dropdownParent: $('#edit-slider-modal')
        });
        $(document).on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        });
        var oTable = $("#basic-1").DataTable({
            "language": {
                "decimal": "",
                "emptyTable": "{{ __('admin_local.No data available in table') }}",
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

        var form_url = "{{ route('admin.settings.homepage.main_slider_store') }}";
        var submit_btn_after = `{{ __('admin_local.Submitting') }}`;
        var submit_btn_before = `{{ __('admin_local.Submit') }}`;
        var no_permission_mgs = `{{ __('admin_local.No Permission') }}`;
        var base_url = '{{ URL::to("/") }}';
        var asset_url = '{{ URL::to("/")."/".env("ASSET_DIRECTORY")."/" }}';


        var delete_swal_title = `{{ __('admin_local.Are you sure?') }}`;
        var delete_swal_text =
            `{{ __('admin_local.Once deleted, you will not be able to recover this data') }}`;
        var delete_swal_cancel_text = `{{ __('admin_local.Delete request canceld successfully') }}`;
        var no_file = `{{ __('admin_local.No file') }}`;
    </script>
    <script src="{{ asset(env('ASSET_DIRECTORY').'/'.'admin/custom/others/messages.js') }}"></script>
    {{-- <script src="{{ asset(env('ASSET_DIRECTORY').'/'.'inventory/custom/user/user_list.js') }}"></script> --}}
@endpush
