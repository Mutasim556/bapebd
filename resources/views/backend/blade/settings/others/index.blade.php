@extends('backend.shared.layouts.admin')
@push('title')
    {{ __('admin_local.Other Contents') }}
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
        <div class="row">
            <!-- Column -->
            <div class="col-lg-10 mx-auto">
                <div class="card">
                    <div class="card-header py-3" style="border-bottom: 2px dashed gray">
                        <h3 class="card-title mb-0 text-center">{{ __('admin_local.Counter Section') }}</h3>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('admin.settings.homepage.updateCounter') }}" method="POST" >
                            @csrf
                            <div class="row">
                                <div class="col-md-5 py-2">
                                    <label for="">{{ __('admin_local.Successfully Completed') }}</label>
                                </div>
                                <div class="col-md-5">
                                    <input type="number" min="1" class="form-control" name="successfully_completed" id="successfully_completed" value="{{ $counter->successfully_completed }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 py-2">
                                    <label for="">{{ __('admin_local.Trainer Count') }}</label>
                                </div>
                                <div class="col-md-5">
                                    <input type="number" min="1" class="form-control" name="trainer" id="trainer" value="{{ $counter->trainer }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 py-2">
                                    <label for="">{{ __('admin_local.Certification Count') }}</label>
                                </div>
                                <div class="col-md-5">
                                    <input type="number" min="1" class="form-control" name="certification" id="certification" value="{{ $counter->certification }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 py-2">
                                    <label for="">{{ __('admin_local.Student Count') }}</label>
                                </div>
                                <div class="col-md-5">
                                    <input type="number" min="1" class="form-control" name="student" id="student" value="{{ $counter->student }}">
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6 py-2">

                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary" style="float: right;">{{ __('admin_local.Update') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
        <div class="row">
            <!-- Column -->
            <div class="col-lg-12 mx-auto">
                <div class="card">
                    <div class="card-header py-3" style="border-bottom: 2px dashed gray">
                        <h3 class="card-title mb-0 text-center">{{ __('admin_local.Homapage About Us Section') }}</h3>
                    </div>

                    <div class="card-body">
                        <form enctype="multipart/form-data" action="{{ route('admin.settings.homepage.updateAboutus') }}" method="POST" >
                            @csrf
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
                                            <div class="row">

                                                <div class="col-md-3 py-2">
                                                    <label for="">{{ __('admin_local.Headline') }}</label>
                                                </div>
                                                <div class="col-md-7">
                                                    <input type="text" class="form-control" name="headline" id="headline" value="{{ $aboutus->headline }}">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3 py-2">
                                                    <label for="">{{ __('admin_local.Short Details') }}</label>
                                                </div>
                                                <div class="col-md-7">
                                                    <textarea class="form-control" name="short_details" id="short_details">{{ $aboutus->short_details }}</textarea>
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-md-3 py-2">
                                                    <label for="">{{ __('admin_local.About Us Points') }} {{ __('admin_local.If Any?') }}</label>
                                                </div>
                                                <div class="col-md-7">
                                                    @php
                                                        $points = $aboutus->points?json_decode($aboutus->points):[];
                                                    @endphp
                                                    <input type="text" class="form-control" name="points[]" id="points" value="{{ $points?$points[0]:'' }}">
                                                </div>
                                                <div class="col-md-1"><button type="button" id="append" class="btn btn-outline-primary py-2"><i class="fa fa-plus"></i></button></div>
                                            </div>
                                            <div id="append_new">
                                                @foreach ($points as $key=>$point)
                                                    @if ($key==0)
                                                        @php
                                                            continue;
                                                        @endphp
                                                    @endif
                                                    <div class="row mt-2">
                                                        <div class="col-md-3 py-2">

                                                        </div>
                                                        <div class="col-md-7">
                                                            <input type="text" class="form-control" name="points[]" id="points" value="{{ $point }}">
                                                        </div>
                                                        <div class="col-md-1"><button type="button" id="delete" class="btn btn-outline-danger py-2"><i class="fa fa-trash"></i></button></div>
                                                    </div>
                                                @endforeach
                                            </div>

                                            <div class="row mt-2">
                                                <div class="col-md-3 py-2">
                                                    <label for="">{{ __('admin_local.Button Text') }}</label>
                                                </div>
                                                <div class="col-md-7">
                                                    <input type="text" class="form-control" name="button_text" id="button_text" value="{{ $aboutus->button_text }}">
                                                </div>
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
                                                if(count($aboutus->translations)>0){

                                                    foreach ($aboutus->translations as $key => $translation) {

                                                        if($translation->locale==$lang->lang && $translation->key=='headline'){

                                                            $translate[$lang->lang]['headline'] = $translation->value;
                                                        }
                                                        if($translation->locale==$lang->lang && $translation->key=='short_details'){
                                                            $translate[$lang->lang]['short_details'] = $translation->value;
                                                        }
                                                        if($translation->locale==$lang->lang && $translation->key=='points'){
                                                            $translate[$lang->lang]['points'] = $translation->value;
                                                        }
                                                        if($translation->locale==$lang->lang && $translation->key=='button_text'){
                                                            $translate[$lang->lang]['button_text'] = $translation->value;
                                                        }
                                                    }

                                                }
                                            @endphp
                                            <div class="tab-pane fade" id="pills-{{ $lang->name }}" role="tabpanel"
                                                aria-labelledby="pills-{{ $lang->name }}-tab">
                                                <div class="row">

                                                    <div class="col-md-3 py-2">
                                                        <label for="">{{ __('admin_local.Headline') }} (
                                                        {{ $lang->name }} )</label>
                                                    </div>
                                                    <div class="col-md-7">
                                                        <input type="text" class="form-control" name="headline_{{ $lang->lang }}" id="headline" value="{{ isset($translate[$lang->lang]['headline'])?$translate[$lang->lang]['headline']:'' }}">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3 py-2">
                                                        <label for="">{{ __('admin_local.Short Details') }} (
                                                        {{ $lang->name }} )</label>
                                                    </div>
                                                    <div class="col-md-7">
                                                        <textarea class="form-control" name="short_details_{{ $lang->lang }}" id="short_details">{{ isset($translate[$lang->lang]['short_details'])?$translate[$lang->lang]['short_details']:'' }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="row mt-2">
                                                    <div class="col-md-3 py-2">
                                                        <label for="">{{ __('admin_local.About Us Points') }}(
                                                        {{ $lang->name }} ) {{ __('admin_local.If Any?') }} </label>
                                                    </div>
                                                    <div class="col-md-7">
                                                        @php
                                                            $points = isset($translate[$lang->lang]['points'])?json_decode($translate[$lang->lang]['points']):[];
                                                        @endphp
                                                        <input type="text" class="form-control" name="points_{{ $lang->lang }}[]" id="points" value="{{ $points?$points[0]:'' }}">
                                                    </div>
                                                    <div class="col-md-1"><button type="button" id="append_{{ $lang->lang }}" onclick="append_points('{{ $lang->lang }}')" class="btn btn-outline-primary py-2"><i class="fa fa-plus"></i></button></div>
                                                </div>
                                                <div id="append_new_{{ $lang->lang }}">
                                                    @foreach ($points as $key=>$point)
                                                        @if ($key==0)
                                                            @php
                                                                continue;
                                                            @endphp
                                                        @endif
                                                        <div class="row mt-2">
                                                            <div class="col-md-3 py-2">

                                                            </div>
                                                            <div class="col-md-7">
                                                                <input type="text" class="form-control" name="points_{{ $lang->lang }}[]" id="points" value="{{ $point }}">
                                                            </div>
                                                            <div class="col-md-1"><button type="button" id="delete" class="btn btn-outline-danger py-2"><i class="fa fa-trash"></i></button></div>
                                                        </div>
                                                    @endforeach
                                                </div>

                                                <div class="row mt-2">
                                                    <div class="col-md-3 py-2">
                                                        <label for="">{{ __('admin_local.Button Text') }} ( {{ $lang->name }} )</label>
                                                    </div>
                                                    <div class="col-md-7">
                                                        <input type="text" class="form-control" name="button_text_{{ $lang->lang }}" id="button_text" value="{{ isset($translate[$lang->lang]['button_text'])?$translate[$lang->lang]['button_text']:'' }}">
                                                    </div>
                                                </div>
                                            </div>

                                        @endforeach
                                            <div class="row">
                                                <div class="col-md-3 py-2">
                                                    <label for="">{{ __('admin_local.Number Of Experience') }}</label>
                                                </div>
                                                <div class="col-md-7">
                                                    <input type="text" class="form-control" name="number_of_experience" id="number_of_experience" value="{{ $aboutus->number_of_experience }}">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3 py-2">
                                                    <label for="">{{ __('admin_local.Image') }} 1 (714px x 447px)</label>
                                                </div>
                                                <div class="col-md-7">
                                                    <input type="file" class="form-control" name="image1" id="image1" onchange="document.getElementById('image1_preview').src = window.URL.createObjectURL(this.files[0])">
                                                </div>
                                                <div class="col-md-10 mx-auto">
                                                    <img src="{{ asset('public/'.$aboutus->image1) }}" alt="Image1" id="image1_preview" style="height:447px;width:714px">
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-md-3 py-2">
                                                    <label for="">{{ __('admin_local.Image') }} 2 (340px x 265px)</label>
                                                </div>
                                                <div class="col-md-7">
                                                    <input type="file" class="form-control" name="image2" id="image2" onchange="document.getElementById('image2_preview').src = window.URL.createObjectURL(this.files[0])" >
                                                </div>
                                                <div class="col-md-10 mx-auto">
                                                    <img src="{{ asset('public/'.$aboutus->image2) }}" alt="Image2" id="image2_preview" style="height:265px;width:340px">
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-md-3 py-2">

                                                </div>
                                                <div class="col-md-7">
                                                    <button type="submit" class="btn btn-primary" style="float:right;">{{ __('admin_local.Update') }}</button>
                                                </div>
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
                "emptyTable": "{{ __('admin_local.No size available in table') }}",
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
            `{{ __('admin_local.Once deleted, you will not be able to recover this size data') }}`;
        var delete_swal_cancel_text = `{{ __('admin_local.Delete request canceld successfully') }}`;
        var no_file = `{{ __('admin_local.No file') }}`;

        $(document).on('click','#append',function(){
            $('#append_new').append(`<div class="row mt-2">
                                        <div class="col-md-3 py-2">

                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control" name="points[]" id="points">
                                        </div>
                                        <div class="col-md-1"><button type="button" id="delete" class="btn btn-outline-danger py-2"><i class="fa fa-trash"></i></button></div>
                                    </div>`);
        })
        $(document).on('click','#delete',function(){
            $(this).closest('.row').remove();
        })

        function append_points(lang){
             $('#append_new_'+lang).append(`<div class="row mt-2">
                                                <div class="col-md-3 py-2">

                                                </div>
                                                <div class="col-md-7">
                                                    <input type="text" class="form-control" name="points_${lang}[]" id="points">
                                                </div>
                                                <div class="col-md-1"><button type="button" id="delete" class="btn btn-outline-danger py-2"><i class="fa fa-trash"></i></button></div>
                                            </div>`)
        }
    </script>

    <script src="{{ asset(env('ASSET_DIRECTORY').'/'.'admin/custom/settings/slider.js') }}"></script>
    {{-- <script src="{{ asset(env('ASSET_DIRECTORY').'/'.'inventory/custom/user/user_list.js') }}"></script> --}}
@endpush
