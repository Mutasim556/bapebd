<?php

namespace App\Models\FrontEnd;

use App\Models\Admin\Course\Course;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseCart extends Model
{
    use HasFactory;

    public function course(){
        return $this->belongsTo(Course::class,'course_id','id');
    }
}
