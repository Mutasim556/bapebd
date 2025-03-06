<?php

namespace App\Models\Admin\Course;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseVideo extends Model
{
    use HasFactory;

    public function instructor(){
        return $this->hasOne(CourseInstructor::class,'course_id','id');
    }

    public function getInstructorDetailsAttribute(){
        $instructorDetails = Admin::where('id',$this->instructor->first()->instructor_id)->select('email','name','phone')->first();
        return $instructorDetails;
    }
}
