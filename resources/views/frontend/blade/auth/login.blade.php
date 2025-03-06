@extends('frontend.shared.layouts.app')
@push('title')
    {{ __('admin_local.Login') }} / {{ __('admin_local.Register') }}
@endpush
@section('content')
<style>
    #login_form .border-danger{
        border:1px solid red !important;
    }
</style>
<div class="space" id="login-space">
    <div class="container py-0">
        <div class="row">
            <div class="col-xl-4 mx-auto px-0">
                <div class="contact-form-wrap px-3" data-bg-src="{{ asset('public/bipebd/assets/img/bg/contact_bg_1.png') }}">
                    
                    <form action="{{ route('user.attemptLogin') }}" class="{{ $type=='register'?'d-none':'' }}" method="POST" id="login_form">
                        <span class="sub-title text-center">{{ __('admin_local.Welcome Back ') }}!</span>
                        <h4 class="text-center">{{ __('admin_local.SignIn To') }} {{ env('COMPANY_NAME') }}</h4>
                        @csrf
                        @if (session()->get('banned'))
                        <div class="alert alert-warning alert-dismissible fade show text-center" role="alert">
                            <strong>{{ session()->get('banned') }}</strong>
                            <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close" style="border-radius: 10px;padding:0px 10px;border:0px;background:rgb(228, 185, 43)">
                              <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" class="form-control style-white" name="email" id="email" autocomplete="off" placeholder="Email Address / Phone*">
                                    <i class="fa-sharp-duotone fa-regular fa-laptop-mobile"></i>
                                    <span class="text-danger" id="email_err"></span>
                                </div>
                            </div>
                            <input type="hidden" name="page_url" value="{{ url()->current() }}">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="password" class="form-control style-white" name="password" id="password" autocomplete="off" placeholder="Your Password*">
                                    <i class="fa-sharp fa-solid fa-eye-slash" id="show_hide_pass"></i>
                                    <span class="text-danger" id="password_err"></span>
                                </div>
                            </div>
                            <div class="form-btn col-12 mt-10">
                                <button type="submit" class="th-btn py-3" style="float: right;">{{ __('admin_local.Sign In') }}<i class="fas fa-long-arrow-right ms-2"></i></button>
                            </div>
                        </div>
                    </form>
                    <form action="{{ route('user.attemptLogin') }}" class="{{ $type=='login'?'d-none':'' }}" method="POST" id="register_form">
                        <span class="sub-title text-center">{{ __('admin_local.Welcome') }}!</span>
                        <h4 class="text-center">{{ __('admin_local.SignUp To') }} {{ env('COMPANY_NAME') }}</h4>
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" class="form-control style-white" name="name" id="name" autocomplete="off" placeholder="User Name*">
                                    <i class="fa-solid fa-user"></i>
                                    <span class="text-danger err-mgs" id="name_err"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="email" class="form-control style-white" name="email" id="email" autocomplete="off" placeholder="Email Address*">
                                    <i class="fa-sharp-duotone fa-thin fa-envelope"></i>
                                    <span class="text-danger err-mgs" id="email_err"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" class="form-control style-white" name="phone" id="phone" autocomplete="off" placeholder="Phone Number*">
                                    <i class="fa-sharp fa-solid fa-mobile"></i>
                                    <span class="text-danger err-mgs" id="phone_err"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="password" class="form-control style-white" name="password" id="password" autocomplete="off" placeholder="Your Password*">
                                    <i class="fa-sharp fa-solid fa-eye-slash" id="show_hide_pass"></i>
                                    <span class="text-danger err-mgs" id="password_err"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="password" class="form-control style-white" name="confirm_password" id="confirm_password" autocomplete="off" placeholder="Confirm Password*">
                                    <i class="fa-sharp fa-solid fa-eye-slash" id="show_hide_cpass"></i>
                                    <span class="text-danger err-mgs" id="confirm_password_err"></span>
                                </div>
                            </div>
                            <div class="form-btn col-12 mt-10">
                                <button type="submit" class="th-btn py-3" style="float: right;">{{ __('admin_local.Sign Up') }}<i class="fas fa-long-arrow-right ms-2"></i></button>
                            </div>
                        </div>
                    </form>
                    <div class="row mt-3">
                        <div class="col-md-12 text-center {{ $type=='register'?'d-none':'' }}" id="sign_up_btn">
                            <strong>{{ __('admin_local.Dont have an account ?') }}</strong><a onclick="login_or_register('sign_up_btn','sign_in_btn','login_form','register_form')" href="#">{{ __('admin_local.Sign Up Now') }}</a>
                        </div>
                        <div class="col-md-12 text-center {{ $type=='login'?'d-none':'' }}" id="sign_in_btn">
                            <strong>{{ __('admin_local.Already have an account ?') }}</strong><a onclick="login_or_register('sign_in_btn','sign_up_btn','register_form','login_form')" href="#">{{ __('admin_local.Sign In Now') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('custom_js')
    <script>
        function login_or_register(x,y,z,s){
            $('#'+x).addClass('d-none')
            $('#'+z).addClass('d-none')
            $('#'+y).removeClass('d-none')
            $('#'+s).removeClass('d-none')
        }
        $('#show_hide_pass','#login_form').on("click",function(){
            if($('#password','#login_form').attr('type')=='password'){
                $('#password','#login_form').attr('type','text');
                $(this).removeClass('fa-sharp fa-solid fa-eye-slash');
                $(this).addClass('fa-sharp fa-solid fa-eye');
            }else{
                $('#password','#login_form').attr('type',"password");
                $(this).removeClass('fa-sharp fa-solid fa-eye');
                $(this).addClass('fa-sharp fa-solid fa-eye-slash');
            }
        });
        $('#show_hide_pass','#register_form').on("click",function(){
            if($('#password','#register_form').attr('type')=='password'){
                $('#password','#register_form').attr('type','text');
                $(this).removeClass('fa-sharp fa-solid fa-eye-slash');
                $(this).addClass('fa-sharp fa-solid fa-eye');
            }else{
                $('#password','#register_form').attr('type',"password");
                $(this).removeClass('fa-sharp fa-solid fa-eye');
                $(this).addClass('fa-sharp fa-solid fa-eye-slash');
            }
        });
        $('#show_hide_cpass','#register_form').on("click",function(){
            if($('#confirm_password','#register_form').attr('type')=='password'){
                $('#confirm_password','#register_form').attr('type','text');
                $(this).removeClass('fa-sharp fa-solid fa-eye-slash');
                $(this).addClass('fa-sharp fa-solid fa-eye');
            }else{
                $('#confirm_password','#register_form').attr('type',"password");
                $(this).removeClass('fa-sharp fa-solid fa-eye');
                $(this).addClass('fa-sharp fa-solid fa-eye-slash');
            }
        });
        $('#login_form').on('submit',function(e){
            e.preventDefault();
            let fData =  $(this).serialize();
            $('button[type=submit]', this).html("{{ __('admin_local.Please wait') }}"+ '....');
            $('button[type=submit]', this).addClass('disabled');
            $.ajax({
                type: "POST",
                url: "{{ route('user.attemptLogin') }}",
                dataType: 'JSON',
                data : fData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    $('button[type=submit]', '#login_form').html("{{ __('admin_local.Sign In') }}"+` <i class="fas fa-long-arrow-right ms-2"></i>`);
                    $('button[type=submit]', '#login_form').removeClass('disabled');
                    if(data.login==false){
                        $('#email_err','#login_form').empty().append(data.message);
                        $('#email','#login_form').addClass('border-danger');
                        $('#password','#login_form').addClass('border-danger');
                    }else{
                        $('#email','#login_form').addClass('border-danger');
                        $('#password','#login_form').addClass('border-danger');
                        window.location.replace(data.redirect_url);
                    }
                },
                error : function(err){
                    $('button[type=submit]', '#login_form').html("{{ __('admin_local.Sign In') }}"+` <i class="fas fa-long-arrow-right ms-2"></i>`);
                    $('button[type=submit]', '#login_form').removeClass('disabled');
                    if (err.status === 403) {
                        var err_message = err.responseJSON.message.split("(");
                        swal({
                            icon: "warning",
                            title: "Warning !",
                            text: err_message[0],
                            confirmButtonText: "Ok",
                        }).then(function () {
                            $('button[type=button]', '##login_form').click();
                        });

                    }

                    $('#login_form .err-mgs').each(function (id, val) {
                        $(this).prev('input').removeClass('border-danger border-danger')
                        $(this).prev('textarea').removeClass('border-danger border-danger')
                        $(this).prev('span').find('.select2-selection--single').attr('id', '')
                        $(this).empty();
                    })
                    $.each(err.responseJSON.errors, function (idx, val) {
                        // console.log('#login_form #'+idx);
                        var exp = idx.replace('.', '_');
                        var exp2 = exp.replace('_0', '');

                        $('#login_form #' + exp).addClass('border-danger border-danger')
                        $('#login_form #' + exp2).addClass('border-danger border-danger')
                        $('#login_form #' + exp).next('span').find('.select2-selection--single').attr('id', 'invalid-selec2')
                        $('#login_form #' + exp).next('.err-mgs').empty().append(val);

                        $('#login_form #' + exp + "_err").empty().append(val);
                    })
                }
            })
        })

        $('#register_form').on('submit',function(e){
            e.preventDefault();
            let fData =  $(this).serialize();
            $('button[type=submit]', this).html("{{ __('admin_local.Please wait') }}"+ '....');
            $('button[type=submit]', this).addClass('disabled');
            $.ajax({
                type: "POST",
                url: "{{ route('user.register') }}",
                dataType: 'JSON',
                data : fData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    $('button[type=submit]', '#register_form').html("{{ __('admin_local.Sign Up ') }}"+` <i class="fas fa-long-arrow-right ms-2"></i>`);
                    $('button[type=submit]', '#register_form').removeClass('disabled');
                    if(data.login){
                        window.location.replace(data.redirect_url);
                    }else{
                        alert('Login Failed');
                    }
                },
                error : function(err){
                    $('button[type=submit]', '#register_form').html("{{ __('admin_local.Sign Up ') }}"+` <i class="fas fa-long-arrow-right ms-2"></i>`);
                    $('button[type=submit]', '#register_form').removeClass('disabled');
                    if (err.status === 403) {
                        var err_message = err.responseJSON.message.split("(");
                        swal({
                            icon: "warning",
                            title: "Warning !",
                            text: err_message[0],
                            confirmButtonText: "Ok",
                        }).then(function () {
                            $('button[type=button]', '##register_form').click();
                        });

                    }

                    $('#register_form .err-mgs').each(function (id, val) {
                        $(this).prev('input').removeClass('border-danger border-danger')
                        $(this).prev('textarea').removeClass('border-danger border-danger')
                        $(this).prev('span').find('.select2-selection--single').attr('id', '')
                        $(this).empty();
                    })
                    $.each(err.responseJSON.errors, function (idx, val) {
                        // console.log('#register_form #'+idx);
                        var exp = idx.replace('.', '_');
                        var exp2 = exp.replace('_0', '');

                        $('#register_form #' + exp).addClass('border-danger border-danger')
                        $('#register_form #' + exp2).addClass('border-danger border-danger')
                        $('#register_form #' + exp).next('span').find('.select2-selection--single').attr('id', 'invalid-selec2')
                        $('#register_form #' + exp).next('.err-mgs').empty().append(val);

                        $('#register_form #' + exp + "_err").empty().append(val);
                    })
                }
            })
        })
    </script>
@endsection