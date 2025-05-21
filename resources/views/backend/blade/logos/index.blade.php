@extends('backend.shared.layouts.admin')
@push('title')
    {{ __('admin_local.Course Category') }}
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
    <div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Control Panel</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Control Panel</a></li>
                            <li class="breadcrumb-item active">Logo</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="div-header mt-3">
                        <h4 class="card-title text-center">Application Content Manger</h4>
                        <h4 class="card-title text-right mr-3"></h4>
                    </div>
                    <div class="card-body">
                        <form action="" id="web_content_form" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="from-group col-md-4 mt-2">
                                    <label for="" class="labelcolor">Content For</label>
                                    <select name="content_for" id="content_for" class="form-control">
                                        <option value="" selected disabled>Please Select</option>
                                        <option value="admin">Admin</option>
                                        <option value="bipebd">BipeBd</option>
                                    </select>
                                </div>
                                <div class="from-group col-md-4 mt-2">
                                    <label for="" class="labelcolor">Select Position</label>
                                    <select name="position" id="position" class="form-control">
                                        <option value="" selected disabled>Please Select Content For First</option>
                                    </select>
                                </div>
                                <div class="from-group col-md-4 mt-2">
                                    <label for="" class="labelcolor">Select Type</label>
                                    <select name="type" id="type" class="form-control">
                                        <option value="" selected disabled>Please Select Position First</option>
                                        
                                    </select>
                                </div>
                                <div class="from-group col-md-12 mt-2" id="upload_type">
                                    
                                </div>
                                <div class="from-group col-md-12 mt-3">
                                    <button class="btn btn-success float-right" id="web_content_buuton" type="submit" >ADD INFORMATION</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card pb-4">
                    <div class="div-header mt-3">
                        <h4 class="card-title text-center">Application Content View</h4>
                        <h4 class="card-title text-right mr-3"></h4>
                    </div>
                    <div class="car-body px-4 mb-4">
                        <form action="" id="content_search_form"  method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-3 mt-3">
                                    <label for="">For</label>
                                    <select name="content_for_serach" class="form-control" id="content_for_serach" data-toggle="select2">
                                        <option value="">Please Select</option>
                                        <option value="admin">Admin</option>
                                        <option value="spark">Spark It</option>
                                    </select>
                                </div>
                                <div class="col-md-3 mt-3">
                                    <label for="">Position</label>
                                    <select name="position_serach" class="form-control" id="position_serach" data-toggle="select2">
                                        <option value="">Please Select</option>
                                    </select>
                                </div>
                                <div class="col-md-3 mt-3">
                                    <label for="">Type</label>
                                    <select name="type_serach" class="form-control" id="type_serach" data-toggle="select2">
                                        <option value="">Please Select</option>
                                    </select>
                                </div>
                                <div class="col-md-3 mt-3">
                                    <button type="submit" class="btn btn-info form-control" id="content_search_button" style="margin-top:28px; ">Search</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="car-body px-4 mt-4" id="search_result" style="display: none;">
                        <div class="table-responsive">
                            <table class="table table-bordered" >
                                <thead>
                                    <tr class="bg-primary text-center text-white">
                                        <th>For</th>
                                        <th>Position</th>
                                        <th>Type</th>
                                        <th>Content</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="table_data">
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>
@endsection
@push('js')
    <script src="{{ asset(env('ASSET_DIRECTORY').'/'.'admin/assets/js/sweet-alert/sweetalert.min.js') }}"></script>
    <script src="{{ asset(env('ASSET_DIRECTORY').'/'.'admin/assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset(env('ASSET_DIRECTORY').'/'.'admin/plugins/switchery/switchery.min.js') }}"></script>
    <script src="{{ asset(env('ASSET_DIRECTORY').'/'.'admin/assets/js/select2/select2.full.min.js') }}"></script>
    {{-- <script src="{{ asset(env('ASSET_DIRECTORY').'/'.'inventory/assets/js/select2/select2-custom.js') }}"></script> --}}
    <script src="{{ asset(env('ASSET_DIRECTORY').'/'.'admin/custom/logo/logo.js') }}"></script>
    <script>
        $('[data-toggle="select2"]').select2();
     </script>
    <script>
        $('#web_content_form').submit(function(e){
            e.preventDefault();
            $.ajax({
                type : 'POST',
                url : "{{ route('admin.upload_logo') }}"", 
                data: new FormData(this),
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success : function(data){
                    Swal.fire({
                        type: 'success',
                        title: '',
                        text: 'Web content uploaded success',
                        showConfirmButton: false,
                        timer:1500,
                    }).then(()=>{
                        $('#web_content_form').trigger('reset');
                    })
                },
                error : function(err){
                    Swal.fire({
                        type: 'error',
                        title: '',
                        text: err.responseJSON.message,
                        showConfirmButton: true,
                    })
                }
            })
        })
        $('#content_search_form').submit(function(e){
            e.preventDefault();
            $('#content_search_button').addClass('disabled');
            $('#content_search_button').html('Searching &nbsp; <i class="mdi mdi-rotate-right mdi-spin"></i>');
            $.ajax({
                type : 'POST',
                url : '{{ route("admin.search_logo") }}',
                data: new FormData(this),
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success : function(data){
                    $('#content_search_button').removeClass('disabled');
                    $('#content_search_button').html('Search');
                    document.getElementById('search_result').style.display='block';
                    $('#table_data').empty();
                    $.each(data,function(key,value){
                        if(value.logo_type=='image'){
                            url = 'http://localhost/dream/admin/'+value.logo_image;
                            content = '<img src="'+url+'">'
                            size = '<strong>Size : </strong>'+value.logo_image_size+' KB';
                            dimention = value.logo_image_dimention;
                        }else{
                            content = value.logo_image;
                            size='';
                            dimention='';
                        }
                        if(value.logo_status=='Active'){   
                            sts = 'checked'
                        }else{
                            sts = '';
                        }
                        $('#table_data').append('<tr><td>'+value.logo_for+'</td><td>'+value.logo_position+'</td><td>'+value.logo_type+'<br>'+size+'<br>'+dimention+'</td><td class="text-center">'+content+'</td><td class="text-center">'+value.logo_status+' &nbsp;&nbsp; <input '+sts+' id="change_status" type="checkbox" data-status="'+value.logo_id+'" data-toggle="switchery" data-secondary-color="#df3554" data-color="#18AD0C" data-size="small" /></td><td class="text-center"><button class="btn btn-danger btn-sm" id="delete_button" data-delete="'+value.logo_id+'">Delete</button></td></tr>');
                    });
                    $('[data-toggle="switchery"]').each(function (idx, obj) {
                        new Switchery($(this)[0], $(this).data());
                    });
                },
                error : function(err){
                    $('#content_search_button').removeClass('disabled');
                    $('#content_search_button').html('Search');
                    document.getElementById('search_result').style.display='none';
                    $('#table_data').empty();
                    Swal.fire({
                        type: 'error',
                        title: '',
                        text: err.responseJSON.message,
                        showConfirmButton: true,
                    })
                }
            });
        });

        $(document).on("change","#change_status",function(){
            var id = $(this).data('status');
            $.ajax({
                type : 'GET',
                url : 'logo-status-change/'+id,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                dataType: 'JSON',
                success : function(data){
                    Swal.fire({
                        type: 'success',
                        title: '',
                        text: 'Content status changed successfully',
                        showConfirmButton: true,
                    }).then(()=>{
                        $('#content_search_button').click();
                    })
                },
                error : function(err){
                    Swal.fire({
                        type: 'error',
                        title: '',
                        text: err.responseJSON.message,
                        showConfirmButton: true,
                    }).then(()=>{
                        $('#content_search_button').click();
                    })
                }
            })
        });

        $(document).on("click","#delete_button",function(){
            var id = $(this).data('delete');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                confirmButtonClass: 'btn btn-success mt-2',
                cancelButtonClass: 'btn btn-danger ml-2 mt-2',
                buttonsStyling: false
            }).then(function (result) {
                if (result.value) {
                    $.ajax({
                        type : 'GET',
                        url : 'delete-logo/'+id,
                        dataType: 'JSON',
                        success : function(data){
                            Swal.fire({
                                type: 'success',
                                title: '',
                                text: 'Content deleted successfully',
                                showConfirmButton: true,
                            }).then(()=>{
                                $('#content_search_button').click();
                            })
                        },
                        error : function(err){
                            Swal.fire({
                                type: 'error',
                                title: '',
                                text: err.responseJSON.message,
                                showConfirmButton: true,
                            }).then(()=>{
                                $('#content_search_button').click();
                            })
                        }
                    })
                }else if (
                    // Read more about handling dismissals
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    Swal.fire({
                    title: 'Cancelled',
                    text: 'Delete request cancelled',
                    type: 'error'
                    })
                }
            })
            
        });
    </script>
@endpush
