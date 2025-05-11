@extends('frontend.shared.layouts.app')
@push('title')
    {{ __('admin_local.Cart') }}
@endpush
@section('content')
<div class="th-cart-wrapper  space-top space-extra-bottom">
    <div class="container">
        @if(count($carts)>0)
        <div class="woocommerce-notices-wrapper" >
            <div class="woocommerce-message">{{ __('admin_local.Shipping costs updated') }}</div>
        </div>
        <form method="post" action="{{ route('frontend.course.cartPayment') }}" id="course_purchase_form" class="woocommerce-cart-form">
            @csrf
            <table class="cart_table">
                <thead>
                    <tr>
                        <th class="cart-col-image">{{ __('admin_local.Image') }}</th>
                        <th class="cart-col-productname">{{ __('admin_local.Course Name') }}</th>
                        <th class="cart-col-price">{{ __('admin_local.Price') }}</th>
                        <th class="cart-col-quantity">{{ __('admin_local.Discount') }}</th>
                        <th class="cart-col-total">{{ __('admin_local.Discount Price') }}</th>
                        <th class="cart-col-remove">{{ __('admin_local.Remove') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $cartSubTotal = 0;
                        $liveCount = 0;
                    @endphp
                    @foreach ($carts as $kcart=>$cart)
                    @php
                        if($cart->course->course_status==0 || $cart->course->course_delete==1){
                                continue;
                        }
                        $cart_course_images = '';
                        $cart_course_images = $cart->course->course_images?explode(',',$cart->course->course_images):asset('public/bipebd/assets/img/course/course_1_1.png');

                        if($cart->course->course_type=='Live'){
                            $course_batches =  \App\Models\Admin\Course\CourseBatch::where([['batch_status',1],['batch_delete',0],['course_id',$cart->course->id]])->whereDate('batch_start_date','>=',date('Y-m-d'))->get();
                            if (count($course_batches)==0) {
                                $deleteCart = DB::table('course_carts')->where('course_id',$cart->course->id)->delete();
                                continue;
                            }
                        }
                    @endphp
                    <tr class="cart_item">
                        <td data-title="Product">
                            <a class="cart-productimage" href="{{ route('frontend.courses.single',$cart->course->course_name_slug) }}"><img width="91" height="91" src="{{ $cart->course->course_images?asset($cart_course_images[0]):$cart_course_images }}" alt="Image"></a>
                        </td>
                        <input type="hidden" name="cousre_slug[]" value="{{ encrypt($cart->course->course_name_slug) }}@if($cart->course->course_type=='Live')||{{ $liveCount }} @endif">
                        <td data-title="Name">
                            <a class="cart-productname" href="{{ route('frontend.courses.single',$cart->course->course_name_slug) }}">{{ $cart->course->course_name }}</a>
                            @if ($cart->course->course_type=='Live')
                            @php
                                $liveCount++;
                            @endphp
                            <select name="live_course_batch[]" id="live_course_batch" class="form-control" required>
                                <option value="">{{ __('admin_local.Select Batch') }}</option>
                                @foreach ($course_batches as $course_batch)
                                 <option value="{{ $course_batch->id }}">{{ $course_batch->batch_name }}</option>
                                @endforeach
                            </select>
                            <span class="err-mgs" id="live_course_batch_err"></span>
                            @endif
                        </td>
                        <td data-title="Price">
                            <span class="amount"><bdi>{{ $cart->course->course_price }} {{ $cart->course->course_price_currency }}</bdi></span>
                        </td>
                        @if( $cart->course->course_discount>0) <td data-title="Quantity">
                            @if ($cart->course->course_discount_type=='Flat')
                            <span class="amount text-uppercase" style="background-color: #F20F10;color:white;padding:3px 8px;border-radius:10px;font-size:12px;font-weight:600"><bdi>{{ $cart->course->course_discount_type }}  {{ $cart->course->course_discount }} {{ $cart->course->course_price_currency }} </bdi></span>
                            @else
                            <span class="amount text-uppercase" style="background-color: #F20F10;color:white;padding:3px 10px;border-radius:10px;font-size:12px;font-weight:600"><bdi>{{ $cart->course->course_discount }} % </bdi></span>
                            @endif

                        @else N/A @endif
                        </td>
                        <td data-title="Total">
                            <span class="amount"><bdi>{{ $cart->course->course_discount>0?$cart->course->course_discount_price:$cart->course->course_price }} {{ $cart->course->course_price_currency }}</bdi></span>
                        </td>
                        <td data-title="Remove">
                            <a onclick="del_from_cart('{{ $cart->course->course_name_slug }}')" href="#" class="remove"><i class="fal fa-trash-alt"></i></a>
                        </td>
                    </tr>
                    @php
                        $cartSubTotal = floor($cartSubTotal + ($cart->course->course_discount>0?$cart->course->course_discount_price:$cart->course->course_price))
                    @endphp
                    @endforeach

                    <tr class="button-tr">
                        <td colspan="6" class="actions">
                            <a href="shop.html" class="th-btn">{{ __('admin_local.Continue Purchase Course') }}</a>
                            <div class="th-cart-coupon">
                                <input type="text" class="form-control" placeholder="Coupon Code..." id="entered_coupon">
                                <button type="button" class="th-btn" id="entered_coupon_btn">{{ __('admin_local.Apply Coupon') }}</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="row justify-content-end">
                <div class="col-md-8 col-lg-7 col-xl-6">
                    <h2 class="h4 summary-title">{{ __('admin_local.Cart Totals') }}</h2>
                    <table class="cart_totals">
                        <tbody>
                            <tr>
                                <td>{{ __('admin_local.Cart Subtotal') }}</td>
                                <td data-title="Cart Subtotal">
                                    <span class="amount"><bdi>{{ $cartSubTotal }} {{ $cart->course->course_price_currency }}</span>
                                </td>
                            </tr>
                            <tr class="shipping">
                                <th>{{ __('admin_local.Payment Options') }}</th>
                                <td data-title="Shipping and Handling">
                                    <p class="form-row py-0">
                                        <select name="payment_mode" id="payment_mode" class="form-select" onchange="$(this).val()=='manual_payment'?manual_pay_option():$('#manual_pay_option').addClass('d-none')">
                                            <option value="" disabled>{{ __('admin_local.Select Payment Option') }}</option>
                                            <option value="manual_payment" @if($errors->any()) selected @endif>{{ __('admin_local.Manual Payment') }}</option>
                                            <option value="sslcommerz" @if(!$errors->any()) selected="selected" @endif>{{ __('admin_local.Sslcommerz') }}</option>
                                        </select>
                                        <span class="err-mgs" id="payment_mode_err"></span>
                                    </p>
                                    <script>
                                        function manual_pay_option(){
                                            $('#manual_pay_option').removeClass('d-none');
                                            $('[name=pay_option]').prop('required',true);
                                            $('[name=phone_number]').prop('required',true);
                                            $('[name=transaction_id]').prop('required',true);
                                        }
                                    </script>
                                    <div id="manual_pay_option" @if(!$errors->any()) class="d-none" @endif>
                                        <p class="form-row">
                                            <select class="form-select  @error('pay_option') is-invalid @enderror" name="pay_option">
                                                <option value="" selected disabled>{{ __('admin_local.Select Paid By') }}</option>
                                                <option value="Bkash">Bkash</option>
                                                <option value="Nagad">Nagad</option>
                                                <option value="Rocket">Rocket</option>
                                            </select>
                                            <span class="err-mgs" id="pay_option_id"></span>
                                            @error('pay_option')
                                                <span class="text-danger">{{ __('admin_local.Pay Option Required') }}</span>
                                            @enderror
                                        </p>
                                        <p>
                                            <input type="text" class="form-select @error('pay_option') is-invalid @enderror" name="phone_number" placeholder="{{ __('admin_local.Phone Number') }}">
                                            @error('phone_number')
                                                <span class="text-danger">{{ __('admin_local.Phone Number Required') }}</span>
                                            @enderror
                                        </p>
                                        <p>
                                            <input type="text" class="form-select @error('pay_option') is-invalid @enderror" name="transaction_id" onkeypress="$(this).val($(this).val().toUpperCase())" placeholder="{{ __('admin_local.Transaction ID') }}">
                                            @error('transaction_id')
                                                <span class="text-danger">{{ __('admin_local.Transaction ID Required') }}</span>
                                            @enderror
                                        </p>
                                    </div>
                                </td>
                            </tr>
                            <tr class="order-total">
                                <td>{{ __('admin_local.Applied Coupon') }}</td>
                                <td data-title="Total">
                                    <strong><span class="amount" id="applied_coupons"></span></strong>
                                    <input type="hidden" name="applied_coupons" >
                                </td>
                            </tr>
                            <tr class="order-total">
                                <td>{{ __('admin_local.Coupon Discount') }}</td>
                                <td data-title="Total">
                                    <strong><span class="amount" id="applied_coupon_discount"></span></strong>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr class="order-total">
                                <td>{{ __("admin_local.Total") }}</td>
                                <td data-title="Total">
                                    <strong><span class="amount" id="total_payable">{{ $cartSubTotal }} {{ $cart->course->course_price_currency }}</span></strong>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="wc-proceed-to-checkout mb-30" style="float:right">
                        <button type="submit" class="th-btn">{{ __('admin_local.Proceed to checkout') }}</button>
                    </div>
                </div>
            </div>
        </form>
        @else
        @php
            // dd('asdasdas b vasdas dasd asd');
        @endphp
        <div class="woocommerce-notices-wrapper" >
            <div class="woocommerce-message" style="background-color: #F20F10 !important;">{{ __('admin_local.No course found in your cart') }}</div>
        </div>
        @endif
    </div>
</div>
@endsection
@section('custom_js')
    <script>
        $(document).ready(function(){
            $('#entered_coupon_btn').attr('disabled',true);
        })
        $(document).on('keyup','#entered_coupon',function(){
            if($(this).val()!=''){
                $(this).val($(this).val().replace(/\s+/g, '').toUpperCase());
                $('#entered_coupon_btn').attr('disabled',false);
            }else{
                $('#entered_coupon_btn').attr('disabled',true);
            }
        });
        $(document).on('click','#entered_coupon_btn',function(){
            $.ajax({
                type: "get",
                url: "{{ url('course/apply-coupon') }}",
                data : {'coupon':$('#entered_coupon').val()},
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    if(data.success_message){
                        toastr.success(data.success_message,{timeOut:5000,showMethod:'slideDown'});
                    }
                    $('#applied_coupons').empty().append(`
                        <span class="amount text-uppercase" style="background-color: #F20F10;color:white;padding:3px 10px;border-radius:10px;font-size:12px;font-weight:600"><bdi>${data.coupon} </bdi></span>
                    `);
                    $("[name=applied_coupons]").val(`${data.coupon}`);
                    $('#applied_coupon_discount').empty().append(parseInt(data.total_discount)+` ${data.currency}`);
                    $('#total_payable').empty().append(parseInt(parseInt(data.subTotal)-parseInt(data.total_discount))+` ${data.currency}`);
                },
                error : function(err){
                    $('#applied_coupons').empty();
                    $('#applied_coupon_discount').empty();
                    $('#total_payable').empty().append(err.responseJSON.subTotal+` ${err.responseJSON.currency}`);
                    toastr.error(err.responseJSON.invalid_message,{timeOut:5000,showMethod:'slideDown'});
                }
            })
        })
    </script>
    <script>
        var obj = {};
    // If you want to pass some value from frontend, you can do like this, but be aware, this value can be modified by anyone, so it's not secure to pass total_amount, store_passwd etc from frontend.
    // obj.cus_name = $('#customer_name').val();
    // obj.cus_phone = $('#mobile').val();
    // obj.cus_email = $('#email').val();
    // obj.cus_addr1 = $('#address').val();

    // $('#sslczPayBtn').prop('postdata', obj);

    // (function (window, document) {
    //     var loader = function () {
    //         var script = document.createElement("script"), tag = document.getElementsByTagName("script")[0];
    //         // script.src = "https://seamless-epay.sslcommerz.com/embed.min.js?" + Math.random().toString(36).substring(7); // USE THIS FOR LIVE
    //         script.src = "https://sandbox.sslcommerz.com/embed.min.js?" + Math.random().toString(36).substring(7); // USE THIS FOR SANDBOX
    //         tag.parentNode.insertBefore(script, tag);
    //     };

    //     window.addEventListener ? window.addEventListener("load", loader, false) : window.attachEvent("onload", loader);
    // })(window, document);



        // $('#course_purchase_form').on('submit',function(e){
        //     e.preventDefault();
        //     $.ajax({
        //         type: "post",
        //         url: "{{ url('course/cart-payment') }}",
        //         data : $(this).serialize(),
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         },
        //         success: function (data) {

        //         },
        //         error : function(err){
        //             $('#applied_coupons').empty();
        //             $('#applied_coupon_discount').empty();
        //             $('#total_payable').empty().append(err.responseJSON.subTotal+` ${err.responseJSON.currency}`);
        //             toastr.error(err.responseJSON.invalid_message,{timeOut:5000,showMethod:'slideDown'});
        //         }
        //     })
        // })
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function del_from_cart(slugg){
            Swal.fire({
                title: '{{ __("admin_local.Warning") }}!',
                text: '{{ __("admin_local.Do you want to delete fron cart ?") }}',
                icon: 'error',
                confirmButtonText: '{{ __("admin_local.Ok") }}',
                showCancelButton: true,
                cancelButtonText: '{{ __("admin_local.Cancel") }}',
                confirmButtonColor: 'red',
                cancelButtonColor: 'green',
            }).then(function(){
                if (result.isConfirmed) {
                    window.location.replace("{{ url('course/delete-from-cart') }}"+"/"+slugg);
                }

            })
        }

    </script>
@endsection
