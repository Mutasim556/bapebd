<?php

namespace App\Http\Requests\Admin\Course;

use App\Models\Admin\Course\CourseAppliedCoupon;
use App\Models\Admin\Course\CourseCoupon;
use Illuminate\Foundation\Http\FormRequest;

class CouponStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'coupon_code'=>'required|unique:course_coupons,coupon',
            'coupon_discount'=>'required',
            'coupon_discount_type'=>'required',
            'start_date'=>'required',
            'end_date'=>'required',
            'can_apply'=>'required',
            // 'course'=>'required',
            'discount_apply_type'=>'required',
            'minimum_price'=>'required_if:has_minimum_price,1',
            'maximum_discount'=>'required_if:has_maximum_discount,1',
        ];
    }

    public function messages(): array
    {
        return [
            'coupon_code.required'=>__('admin_local.Coupon code required'),
            'coupon_code.unique'=>__('admin_local.Coupon code already used'),
            'coupon_discount.required'=>__('admin_local.Coupon discount required'),
            'coupon_discount_type.required'=>__('admin_local.Coupon discount type required'),
            'start_date.required'=>__('admin_local.Coupon start date type required'),
            'end_date.required'=>__('admin_local.Coupon end date type required'),
            'can_apply.required'=>__('admin_local.Can apply required'),
            'course.required'=>__('admin_local.At least one course required'),
            'discount_apply_type.required'=>__('admin_local.Coupon discount apply type required'),
            'minimum_price.required_if'=>__('admin_local.Minimum apply price required'),
            'maximum_discount.required_if'=>__('admin_local.Maximum discount required'),
        ];
    }

    public function store(){
        // dd($this->all());
        $coupon = new CourseCoupon();
        $coupon->coupon = $this->coupon_code;
        $coupon->coupon_start_date = $this->start_date;
        $coupon->coupon_end_date = $this->end_date;
        $coupon->can_apply = $this->can_apply;
        $coupon->apply_type = $this->discount_apply_type;
        $coupon->has_minimum_price_for_apply = $this->has_minimum_price?1:0;
        $coupon->minimum_price_for_apply = $this->minimum_price;
        $coupon->coupon_discount = $this->coupon_discount;
        $coupon->coupon_discount_type = $this->coupon_discount_type;
        $coupon->has_maximum_discount = $this->has_maximum_discount?1:0;
        $coupon->maximum_discount = $this->maximum_discount;
        $coupon->coupon_details = $this->coupon_details;
        $coupon->created_by = LoggedAdmin()->id;
        $coupon->applicable_for = $this->course?1:0;
        $coupon->save();
        
        if($this->course){
            foreach($this->course as $key=>$val){
                $coupon_course = new CourseAppliedCoupon();
                $coupon_course->course_id = $val;
                $coupon_course->coupon_id = $coupon->id;
                $coupon_course->coupon_code = $this->coupon_code;
                $coupon_course->created_by = LoggedAdmin()->id;
                $coupon_course->save();
            }
        }
        

        return $coupon->id;
    }
}
