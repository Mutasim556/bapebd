<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Admin\Course\Course;
use App\Models\Admin\Course\CourseCoupon;
use App\Models\FrontEnd\CourseCart;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function addCart(string $slug){
        $course = Course::where([['course_name_slug',$slug]])->select('id')->first();
        // $cart = new CourseCart();
        // $cart->user_id = Auth::user()->id;
        // $cart->course_id = $course->id;
        // $cart->save();
        CourseCart::updateOrInsert([
            'user_id'                =>  Auth::user()->id,
            'course_id'                   => $course->id,
        ],[
            'created_at'            => Carbon::now(),
            'updated_at'            => Carbon::now(),
        ]);
        return back()->with('cart_add_success',__("admin_local.Successfully added to the cart"));
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
        $carts = CourseCart::with('course')->where([['user_id',Auth::user()->id]])->get();
        // dd(count($carts));
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
        if(request()->ajax()){
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
                    return response([
                        'invalid_message'=>__("admin_local.Invalid coupon"),
                        'coupon'=>$data->coupon,
                        'total_discount'=>$coupon_deduction,
                        'currency'=>$cart_course->course->course_price_currency,
                        'subTotal'=>$subTotal,
                    ],404);
                }
            }else{

            }
            
        }
    }
}
