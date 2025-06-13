<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Library\SslCommerz\SslCommerzNotification;
use App\Models\Admin\Course\Course;
use App\Models\Admin\Course\CourseCoupon;
use App\Models\FrontEnd\CourseCart;
use App\Models\FrontEnd\Purchase;
use App\Models\FrontEnd\PurchaseCourse;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function addCart(string $slug){

        $course = Course::where([['course_name_slug',$slug]])->select('id')->first();
        if(request()->type=='enroll'){
            CourseCart::where('user_id',Auth::user()->id)->delete();
        }
        // $cart = new CourseCart();
        // $cart->user_id = Auth::user()->id;
        // $cart->course_id = $course->id;
        // $cart->save();
        $check_purchase_request = PurchaseCourse::where([['course_id',$course->id],['status',0]])->first();
        if($check_purchase_request){
            return back()->with('cart_add_invalid',__("admin_local.You have aleady a purchase request of this course"));
        }
        CourseCart::updateOrInsert([
            'user_id'                =>  Auth::user()->id,
            'course_id'                   => $course->id,
        ],[
            'created_at'            => Carbon::now(),
            'updated_at'            => Carbon::now(),
        ]);
        if(request()->ajax()){
            return true;
        }else{
            if(request()->type=='enroll'){
                return to_route('frontend.course.viewCart');
            }else{
                return back()->with('cart_add_success',__("admin_local.Successfully added to the cart"));
            }
        }
    }

    public function deleteCart(string $slug){
        if(request()->ajax()){
            $course = Course::where([['course_name_slug',$slug]])->select('id')->first();
            $delete = CourseCart::where([['course_id',$course->id],['user_id',Auth::user()->id]])->delete();

            $cart_total = CourseCart::with('course')->where([['user_id',Auth::user()->id]])->get();
            $cart_count = count($cart_total);
            $subTotal = 0;
            foreach ($cart_total as $kcart=>$cart){
                $subTotal = $subTotal + ($cart->course->course_discount>0?$cart->course->course_discount_price:$cart->course->course_price);
            }
            return [
                'cart_count'=>$cart_count,
                'subTotal'=>floor($subTotal)." ".$cart->course->course_price_currency,
            ];
        }else{
            $course = Course::where([['course_name_slug',$slug]])->select('id')->first();
            $delete = CourseCart::where([['course_id',$course->id],['user_id',Auth::user()->id]])->delete();

            return back();
        }

    }

    public function viewCart(){
        $carts = CourseCart::with('course')->where([['user_id',Auth::user()->id]])->orderBy('id','DESC')->get();
        // dd(count($carts));
        foreach($carts as $kcart=>$cart){
            if($cart->course->course_type=='Live'){
                $course_batches =  \App\Models\Admin\Course\CourseBatch::where([['batch_status',1],['batch_delete',0],['course_id',$cart->course->id]])->whereDate('batch_start_date','>=',date('Y-m-d'))->get();
                if (count($course_batches)==0) {
                    $deleteCart = DB::table('course_carts')->where('course_id',$cart->course->id)->delete();
                    continue;
                }
            }
        }
        $carts = CourseCart::with('course')->where([['user_id',Auth::user()->id]])->orderBy('id','DESC')->get();
        return view('frontend.blade.cart.index',compact('carts'));
    }

    public function applyCoupon(Request $data){
        $check_coupon = CourseCoupon::with('applicableCourses')->where([['coupon',$data->coupon],['coupon_status',1],['coupon_delete',0]])->whereDate('coupon_start_date','<=',date('Y-m-d'))->whereDate('coupon_end_date','>=',date('Y-m-d'))->first();

        if($check_coupon){
            $applicable_courses = [];
            $coupon_deduction = 0;
            foreach($check_coupon->applicableCourses as $apc){
                $applicable_courses[]=$apc->course_id;
            }
            $cart_courses = CourseCart::with('course')->where([['user_id',Auth::user()->id]])->get();
            $subTotal = 0;
            foreach($cart_courses as $cart_course){
                $subTotal = floor($subTotal + ($cart_course->course->course_discount>0?$cart_course->course->course_discount_price:$cart_course->course->course_price));
                if(in_array($cart_course->course_id,$applicable_courses)){

                    if(str_replace(' ','_',strtolower($check_coupon->apply_type))=='discount_on_regular_price'){
                        if($check_coupon->coupon_discount_type=='Flat'){
                            $coupon_deduction = $coupon_deduction + $check_coupon->coupon_discount;
                        }else{
                            $discount = (($cart_course->course->course_price * $check_coupon->coupon_discount)/100);
                            $coupon_deduction = $coupon_deduction + (($check_coupon->has_maximum_discount&&$discount>$check_coupon->maximum_discount)?$check_coupon->maximum_discount:$discount);
                        }

                    }elseif(str_replace(' ','_',strtolower($check_coupon->apply_type))=='discount_on_discounted_price'){
                        if($check_coupon->coupon_discount_type=='Flat'){
                            $coupon_deduction = $coupon_deduction + $check_coupon->coupon_discount;
                        }else{
                            $discount = (($cart_course->course->course_discount_price * $check_coupon->coupon_discount)/100);
                            $coupon_deduction = $coupon_deduction + (($check_coupon->has_maximum_discount&&$discount>$check_coupon->maximum_discount)?$check_coupon->maximum_discount:$discount);
                        }
                    }elseif(str_replace(' ','_',strtolower($check_coupon->apply_type))=='discount_on_both'){
                        if($cart_course->course->course_discount>0){
                            if($check_coupon->coupon_discount_type=='Flat'){
                                $coupon_deduction = $coupon_deduction + $check_coupon->coupon_discount;
                            }else{
                                $discount = (($cart_course->course->course_discount_price * $check_coupon->coupon_discount)/100);
                                $coupon_deduction = $coupon_deduction + (($check_coupon->has_maximum_discount&&$discount>$check_coupon->maximum_discount)?$check_coupon->maximum_discount:$discount);
                            }
                        }else{
                            if($check_coupon->coupon_discount_type=='Flat'){
                                $coupon_deduction = $coupon_deduction + $check_coupon->coupon_discount;
                            }else{
                                $discount = (($cart_course->course->course_price * $check_coupon->coupon_discount)/100);
                                $coupon_deduction = $coupon_deduction + (($check_coupon->has_maximum_discount&&$discount>$check_coupon->maximum_discount)?$check_coupon->maximum_discount:$discount);
                            }
                        }

                    }
                }
            }
            if($coupon_deduction>0){
                return response([
                    'success_message'=>__("admin_local.Coupon applied"),
                    'coupon'=>$data->coupon,
                    'total_discount'=>$coupon_deduction,
                    'currency'=>$cart_course->course->course_price_currency,
                    'subTotal'=>$subTotal,
                ],200);
            }else{
                return response([
                    'invalid_message'=>__("admin_local.Invalid coupon"),
                    'coupon'=>$data->coupon,
                    'total_discount'=>$coupon_deduction,
                    'currency'=>$cart_course->course->course_price_currency,
                    'subTotal'=>$subTotal,
                ],404);
            }

        }else{
            $coupon_deduction = 0;
            $subTotal = 0;
            $cart_courses = CourseCart::with('course')->where([['user_id',Auth::user()->id]])->get();
            foreach($cart_courses as $cart_course){
                $subTotal = floor($subTotal + ($cart_course->course->course_discount>0?$cart_course->course->course_discount_price:$cart_course->course->course_price));
            }
            return response([
                'invalid_message'=>__("admin_local.Invalid coupon"),
                'coupon'=>$data->coupon,
                'total_discount'=>$coupon_deduction,
                'currency'=>$cart_course->course->course_price_currency,
                'subTotal'=>$subTotal,
            ],404);
        }
    }

    public function cartPayment(Request $data){
        // dd($data->all());

            if($data->applied_coupons){
                $check_coupon = CourseCoupon::with('applicableCourses')->where([['coupon',$data->applied_coupons],['coupon_status',1],['coupon_delete',0]])->whereDate('coupon_start_date','<=',date('Y-m-d'))->whereDate('coupon_end_date','>=',date('Y-m-d'))->first();
                if($check_coupon){
                    $applicable_courses = [];
                    $coupon_deduction = 0;
                    foreach($check_coupon->applicableCourses as $apc){
                        $applicable_courses[]=$apc->course_id;
                    }
                    $cart_courses = CourseCart::with('course')->where([['user_id',Auth::user()->id]])->get();
                    $subTotal = 0;
                    foreach($cart_courses as $cart_course){
                        $subTotal = floor($subTotal + ($cart_course->course->course_discount>0?$cart_course->course->course_discount_price:$cart_course->course->course_price));
                        if(in_array($cart_course->course_id,$applicable_courses)){

                            if(str_replace(' ','_',strtolower($check_coupon->apply_type))=='discount_on_regular_price'){
                                if($check_coupon->coupon_discount_type=='Flat'){
                                    $coupon_deduction = $coupon_deduction + $check_coupon->coupon_discount;
                                }else{
                                    $discount = (($cart_course->course->course_price * $check_coupon->coupon_discount)/100);
                                    $coupon_deduction = $coupon_deduction + (($check_coupon->has_maximum_discount&&$discount>$check_coupon->maximum_discount)?$check_coupon->maximum_discount:$discount);
                                }

                            }elseif(str_replace(' ','_',strtolower($check_coupon->apply_type))=='discount_on_discounted_price'){
                                if($check_coupon->coupon_discount_type=='Flat'){
                                    $coupon_deduction = $coupon_deduction + $check_coupon->coupon_discount;
                                }else{
                                    $discount = (($cart_course->course->course_discount_price * $check_coupon->coupon_discount)/100);
                                    $coupon_deduction = $coupon_deduction + (($check_coupon->has_maximum_discount&&$discount>$check_coupon->maximum_discount)?$check_coupon->maximum_discount:$discount);
                                }
                            }elseif(str_replace(' ','_',strtolower($check_coupon->apply_type))=='discount_on_both'){
                                if($cart_course->course->course_discount>0){
                                    if($check_coupon->coupon_discount_type=='Flat'){
                                        $coupon_deduction = $coupon_deduction + $check_coupon->coupon_discount;
                                    }else{
                                        $discount = (($cart_course->course->course_discount_price * $check_coupon->coupon_discount)/100);
                                        $coupon_deduction = $coupon_deduction + (($check_coupon->has_maximum_discount&&$discount>$check_coupon->maximum_discount)?$check_coupon->maximum_discount:$discount);
                                    }
                                }else{
                                    if($check_coupon->coupon_discount_type=='Flat'){
                                        $coupon_deduction = $coupon_deduction + $check_coupon->coupon_discount;
                                    }else{
                                        $discount = (($cart_course->course->course_price * $check_coupon->coupon_discount)/100);
                                        $coupon_deduction = $coupon_deduction + (($check_coupon->has_maximum_discount&&$discount>$check_coupon->maximum_discount)?$check_coupon->maximum_discount:$discount);
                                    }
                                }

                            }
                        }
                    }

                }else{
                    $coupon_deduction = 0;
                    $subTotal = 0;
                    $cart_courses = CourseCart::with('course')->where([['user_id',Auth::user()->id]])->get();
                    foreach($cart_courses as $cart_course){
                        $subTotal = floor($subTotal + ($cart_course->course->course_discount>0?$cart_course->course->course_discount_price:$cart_course->course->course_price));
                    }
                }
            }else{
                $cart_courses = CourseCart::with('course')->where([['user_id',Auth::user()->id]])->get();
                $subTotal = 0;
                $coupon_deduction = 0;
                foreach($cart_courses as $cart_course){
                    $subTotal = floor($subTotal + ($cart_course->course->course_discount>0?$cart_course->course->course_discount_price:$cart_course->course->course_price));
                }
            }
            // dd(request()->all());
            if($data->payment_mode=='sslcommerz'){
                $payAmount = $subTotal-$coupon_deduction;
                // dd($data->live_course_batch);
                $this->sslPay($payAmount,$data->live_course_batch?implode(',',$data->live_course_batch):'',$subTotal);

            }elseif($data->payment_mode=='manual_payment'){
                // dd($data->all());
                $data->validate([
                    'pay_option'=>'required',
                    'phone_number'=>'required',
                    'transaction_id'=>'required',
                ]);

                $payAmount = $subTotal-$coupon_deduction;

                $carts  = CourseCart::with('course')->where('user_id',Auth::user()->id)->get();

                $course_id = '';
                foreach($carts as $key=>$cart){
                    $course_id = $course_id.$cart->course_id;
                    if($key<count($carts)){
                        $course_id = $course_id."|";
                    }
                }

                $purchase = new Purchase();
                $purchase->courses = json_encode($course_id);
                $purchase->total_amount = $payAmount;
                $purchase->subtotal = $subTotal;
                $purchase->dicount_amount = $coupon_deduction;
                $purchase->payment_method = 'manual_payment';
                $purchase->payment_status = 0;
                $purchase->phone = $data->phone_number;
                $purchase->transaction_id = $data->transaction_id;
                $purchase->payment_option = $data->pay_option;
                $purchase->save();
                $live_count = 0;
                $live_batch = explode(',',$data->live_course_batch?implode(',',$data->live_course_batch):'');
                // dd($live_batch);
                foreach($carts as $key=>$cart){
                    $purchase_course = new PurchaseCourse();
                    $purchase_course->purchase_id = $purchase->id;
                    $purchase_course->user_id = Auth::user()->id;
                    $purchase_course->course_id = $cart->course_id;
                    $purchase_course->course_type = $cart->course->course_type;
                    if($purchase_course->course_type=='Live'){
                        $purchase_course->batch_id = $live_batch[$live_count]??'';
                        $live_count++;
                    }else{
                        $purchase_course->batch_id = null;
                    }

                    $purchase_course->status = 0;
                    $purchase_course->save();
                }
                if($cart->course->course_type=='Pre-recorded'){

                    $course_u = Course::findOrFail($cart->course_id);
                    $course_u->enrolled_count = $course_u->enrolled_count+1;
                    $course_u->save();
                }
                $carts  = CourseCart::with('course')->where('user_id',Auth::user()->id)->delete();

                return to_route('frontend.course.viewCart')->with('success_payment',__('admin_local.We have recived your purchase request.Please wait for purchase confirmation'));
            }


    }

    public function sslPay($payAmount,$formData,$subTotal){
        $transaction_id = uniqid();
        $post_data = array();
        $post_data['total_amount'] = $payAmount; # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = $transaction_id; // tran_id must be unique

        # CUSTOMER INFORMATION
        $post_data['cus_name'] =  Auth::user()->name;
        $post_data['cus_email'] =  Auth::user()->email;
        $post_data['cus_add1'] = 'xxxxxxx';
        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = "";
        $post_data['cus_state'] = "";
        $post_data['cus_postcode'] = "";
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = Auth::user()->phone;
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = "Store Test";
        $post_data['ship_add1'] = "Dhaka";
        $post_data['ship_add2'] = "Dhaka";
        $post_data['ship_city'] = "Dhaka";
        $post_data['ship_state'] = "Dhaka";
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_phone'] = "";
        $post_data['ship_country'] = "Bangladesh";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "Computer";
        $post_data['product_category'] = "Goods";
        $post_data['product_profile'] = "physical-goods";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = $formData;
        $post_data['value_b'] = $subTotal;
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";

        #Before  going to initiate the payment order status need to insert or update as Pending.

        $update_product = DB::table('orders')
            ->where('transaction_id', $transaction_id)
            ->updateOrInsert([
                'name' => Auth::user()->name,
                'email' => Auth::user()->email,
                'phone' => Auth::user()->phone,
                'amount' => $payAmount,
                'status' => 'Pending',
                'address' => 'xxxxxxx',
                'transaction_id' => $transaction_id,
                'currency' => 'BDT'
            ]);

                $sslc = new SslCommerzNotification();
                # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
                $payment_options = $sslc->makePayment($post_data, 'hosted');

                if (!is_array($payment_options)) {
                    print_r($payment_options);
                    $payment_options = array();
                }
    }

    public function success(Request $request)
    {
        echo "Transaction is Successful";

        $tran_id = $request->input('tran_id');
        $amount = $request->input('amount');
        $currency = $request->input('currency');

        $sslc = new SslCommerzNotification();

        #Check order status in order tabel against the transaction id or order id.
        $order_details = DB::table('orders')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'amount')->first();

        if ($order_details->status == 'Pending') {
            $validation = $sslc->orderValidate($request->all(), $tran_id, $amount, $currency);

            if ($validation) {
                /*
                That means IPN did not work or IPN URL was not set in your merchant panel. Here you need to update order status
                in order table as Processing or Complete.
                Here you can also sent sms or email for successfull transaction to customer
                */
                $update_product = DB::table('orders')
                    ->where('transaction_id', $tran_id)
                    ->update(['status' => 'Processing']);

                echo "<br >Transaction is successfully Completed";
            }
        } else if ($order_details->status == 'Processing' || $order_details->status == 'Complete') {
            /*
             That means through IPN Order status already updated. Now you can just show the customer that transaction is completed. No need to udate database.
             */
            echo "Transaction is successfully Completed";
        } else {
            #That means something wrong happened. You can redirect customer to your product page.
            echo "Invalid Transaction";
        }


    }

    public function fail(Request $request)
    {
        $tran_id = $request->input('tran_id');

        $order_details = DB::table('orders')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'amount')->first();

        if ($order_details->status == 'Pending') {
            $update_product = DB::table('orders')
                ->where('transaction_id', $tran_id)
                ->update(['status' => 'Failed']);
            echo "Transaction is Falied";
        } else if ($order_details->status == 'Processing' || $order_details->status == 'Complete') {
            echo "Transaction is already Successful";
        } else {
            echo "Transaction is Invalid";
        }

    }

    public function cancel(Request $request)
    {
        $tran_id = $request->input('tran_id');

        $order_details = DB::table('orders')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'amount')->first();

        if ($order_details->status == 'Pending') {
            $update_product = DB::table('orders')
                ->where('transaction_id', $tran_id)
                ->update(['status' => 'Canceled']);
            echo "Transaction is Cancel";
        } else if ($order_details->status == 'Processing' || $order_details->status == 'Complete') {
            echo "Transaction is already Successful";
        } else {
            echo "Transaction is Invalid";
        }


    }

    public function ipn(Request $request)
    {
        #Received all the payement information from the gateway
        if ($request->input('tran_id')) #Check transation id is posted or not.
        {

            $tran_id = $request->input('tran_id');

            #Check order status in order tabel against the transaction id or order id.
            $order_details = DB::table('orders')
                ->where('transaction_id', $tran_id)
                ->select('transaction_id', 'status', 'currency', 'amount')->first();

            if ($order_details->status == 'Pending') {
                $sslc = new SslCommerzNotification();
                $validation = $sslc->orderValidate($request->all(), $tran_id, $order_details->amount, $order_details->currency);
                if ($validation == TRUE) {
                    /*
                    That means IPN worked. Here you need to update order status
                    in order table as Processing or Complete.
                    Here you can also sent sms or email for successful transaction to customer
                    */
                    $update_product = DB::table('orders')
                        ->where('transaction_id', $tran_id)
                        ->update(['status' => 'Processing']);

                    echo "Transaction is successfully Completed";
                }
            } else if ($order_details->status == 'Processing' || $order_details->status == 'Complete') {

                #That means Order status already updated. No need to udate database.

                echo "Transaction is already successfully Completed";
            } else {
                #That means something wrong happened. You can redirect customer to your product page.

                echo "Invalid Transaction";
            }
        } else {
            echo "Invalid Data";
        }
    }
}
