<?php

namespace App\Models\Admin\Course;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseCoupon extends Model
{
    use HasFactory;
    // protected $casts = [
    //     'coupon_start_date' => 'datetime:Y-m-d',
    //     'coupon_end_date' => 'datetime:Y-m-d',
    // ];

    protected function couponStartDate(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => date('d-M-Y',strtotime($value)),
        );
    }

    protected function couponEndDate(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => date('d-M-Y',strtotime($value)),
        );
    }

    protected function applyType(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ucfirst(str_replace('_',' ',$value)),
        );
    }
    

    public function applicableCourses(){
        return $this->hasMany(CourseAppliedCoupon::class,'coupon_id','id');
    }
}
