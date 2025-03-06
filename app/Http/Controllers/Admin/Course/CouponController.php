<?php

namespace App\Http\Controllers\Admin\Course;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Course\CouponStoreRequest;
use App\Http\Requests\Admin\Course\CouponUpdateRequest;
use App\Models\Admin\Course\Course;
use App\Models\Admin\Course\CourseAppliedCoupon;
use App\Models\Admin\Course\CourseCoupon;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::with('subCategory')->where([['course_status',1],['course_delete',0]])->get();
        $coupons = CourseCoupon::where([['coupon_status',1],['coupon_delete',0]])->orderBy('coupon_status','DESC')->get();
        return view('backend.blade.course.coupon.index',compact('courses','coupons'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CouponStoreRequest $data)
    {
        $coupon = $data->store();
        if($coupon){
            $coupon = CourseCoupon::with('applicableCourses')->findOrFail($coupon);
            
            $coupon->validity = date('Y-m-d',strtotime($coupon->coupon_end_date))>date('Y-m-d')?'<span class="badge badge-success">'.__('admin_local.Valid').'</span>':'<span class="badge badge-danger">'.__('admin_local.Invalid').'</span>';
            // dd($coupon->validity);
            return response([
                'coupon' => $coupon,
                'title' => __('admin_local.Congratulations !'),
                'text' => __('admin_local.Coupon create successfully.'),
                'confirmButtonText' => __('admin_local.Ok'),
                'hasAnyPermission' => hasPermission(['course-coupon-update', 'course-coupon-delete']),
                'hasEditPermission' => hasPermission(['course-coupon-update']),
                'hasDeletePermission' => hasPermission(['course-coupon-delete']),
            ], 200);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // $applied_coupons = CourseAppliedCoupon::with('coupon')->where([['coupon_id',$id]])->get();
        // $applied_coupons->course = Course::where([['course_status',1],['course_delete',0]])->get();
        // dd($applied_coupons);
        $applied_coupons = CourseAppliedCoupon::with('course','coupon')->where([['coupon_id',$id]])->get();
        foreach($applied_coupons as $key=>$applied_coupon){
            if($applied_coupon->coupon->coupon_discount_type=='Flat'){
                if($applied_coupon->coupon->apply_type=="Discount on regular price"){
                    $discount = $applied_coupon->course->course_price-($applied_coupon->coupon->has_maximum_discount?($applied_coupon->coupon->coupon_discount>$applied_coupon->coupon->maximum_discount?$applied_coupon->coupon->maximum_discount:$applied_coupon->coupon->coupon_discount):$applied_coupon->coupon->coupon_discount);
                    $applied_coupons[$key]->coupon_applied_price = $discount;
                }elseif($applied_coupon->coupon->apply_type=="Discount on discounted price"){
                    $discount = $applied_coupon->course->course_discount_price-($applied_coupon->coupon->has_maximum_discount?($applied_coupon->coupon->coupon_discount>$applied_coupon->coupon->maximum_discount?$applied_coupon->coupon->maximum_discount:$applied_coupon->coupon->coupon_discount):$applied_coupon->coupon->coupon_discount);
                    $applied_coupons[$key]->coupon_applied_price = $discount;
                }else{
                    if($applied_coupon->course->course_discount>0){
                        $discount = $applied_coupon->course->course_discount_price-($applied_coupon->coupon->has_maximum_discount?($applied_coupon->coupon->coupon_discount>$applied_coupon->coupon->maximum_discount?$applied_coupon->coupon->maximum_discount:$applied_coupon->coupon->coupon_discount):$applied_coupon->coupon->coupon_discount);
                        $applied_coupons[$key]->coupon_applied_price = $discount;
                    }else{
                        $discount = $applied_coupon->course->course_price-($applied_coupon->coupon->has_maximum_discount?($applied_coupon->coupon->coupon_discount>$applied_coupon->coupon->maximum_discount?$applied_coupon->coupon->maximum_discount:$applied_coupon->coupon->coupon_discount):$applied_coupon->coupon->coupon_discount);
                        $applied_coupons[$key]->coupon_applied_price = $discount;
                    }
                }
            }else{
                
                if($applied_coupon->coupon->apply_type=="Discount on regular price"){
                    $dis_percent =  ($applied_coupon->course->course_price*$applied_coupon->coupon->coupon_discount)/100;
                    
                    $discount = $applied_coupon->course->course_price-($applied_coupon->coupon->has_maximum_discount?($dis_percent>$applied_coupon->coupon->maximum_discount?$applied_coupon->coupon->maximum_discount:$dis_percent):$dis_percent);
                    
                    $applied_coupons[$key]->coupon_applied_price = $discount;
                }elseif($applied_coupon->coupon->apply_type=="Discount on discounted price"){
                    $dis_percent =  ($applied_coupon->course->course_discount_price*$applied_coupon->coupon->coupon_discount)/100;
                    $discount = $applied_coupon->course->course_discount_price-($applied_coupon->coupon->has_maximum_discount?($dis_percent>$applied_coupon->coupon->maximum_discount?$applied_coupon->coupon->maximum_discount:$dis_percent):$dis_percent);
                    $applied_coupons[$key]->coupon_applied_price = $discount;
                }else{
                    if($applied_coupon->course->course_discount>0){
                        $dis_percent =  ($applied_coupon->course->course_discount_price*$applied_coupon->coupon->coupon_discount)/100;
                        $discount = $applied_coupon->course->course_discount_price-($applied_coupon->coupon->has_maximum_discount?($dis_percent>$applied_coupon->coupon->maximum_discount?$applied_coupon->coupon->maximum_discount:$dis_percent):$dis_percent);
                        $applied_coupons[$key]->coupon_applied_price = $discount;
                    }else{
                        $dis_percent =  ($applied_coupon->course->course_price*$applied_coupon->coupon->coupon_discount)/100;
                        $discount = $applied_coupon->course->course_price-($applied_coupon->coupon->has_maximum_discount?($dis_percent>$applied_coupon->coupon->maximum_discount?$applied_coupon->coupon->maximum_discount:$dis_percent):$dis_percent);
                        $applied_coupons[$key]->coupon_applied_price = $discount;
                    }
                }
            }
        }
        return $applied_coupons;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $coupon = CourseCoupon::where([['id',$id]])->first();
        $coupon->coupon_starts_date = date('Y-m-d',strtotime($coupon->coupon_start_date));
        $coupon->coupon_ends_date = date('Y-m-d',strtotime($coupon->coupon_end_date));
        $coupon->courses = CourseAppliedCoupon::with('course')->where([['coupon_id',$coupon->id]])->get();
        // dd($coupon);
        return $coupon;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CouponUpdateRequest $data, string $id)
    {
        $coupon = $data->update($id);
        if(date('Y-m-d',strtotime($coupon->coupon_end_date))>date('Y-m-d')){
            $coupon->validity = "<span class='badge badge-success'>".__('admin_local.Valid')."</span>";
        }else{
            $coupon->validity = "<span class='badge badge-danger'>".__('admin_local.Invalid')."</span>";
        }
        
        return response([
            'coupon' => $coupon,
            'title' => __('admin_local.Congratulations !'),
            'text' => __('admin_local.Coupon updated successfully.'),
            'confirmButtonText' => __('admin_local.Ok'),
            'hasAnyPermission' => hasPermission(['course-coupon-update', 'course-coupon-delete']),
            'hasEditPermission' => hasPermission(['course-coupon-update']),
            'hasDeletePermission' => hasPermission(['course-coupon-delete']),
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) :Response
    {
        $coupon = CourseCoupon::findOrFail($id);
        $coupon->coupon_delete=1;
        $coupon->updated_at=Carbon::now();
        $coupon->save();
        return response([
            'title'=>__('admin_local.Congratulations !'),
            'text'=>__('admin_local.Coupon deleted successfully.'),
            'confirmButtonText'=>__('admin_local.Ok'),
        ]);
    }

    public function updateStatus(Request $data){
        $coupon = CourseCoupon::findOrFail($data->id);
        $coupon->coupon_status=$data->status;
        $coupon->updated_at=Carbon::now();
        $coupon->save();
        return response($coupon);
    }
}
