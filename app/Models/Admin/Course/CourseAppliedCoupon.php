<?php

namespace App\Models\Admin\Course;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseAppliedCoupon extends Model
{
    use HasFactory;

    public function course(){
        return $this->belongsTo(Course::class,'course_id','id');
    }

    public function coupon(){
        return $this->belongsTo(CourseCoupon::class,'coupon_id','id');
    }
}
