<?php

namespace App\Models\Admin\Course;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseInstructor extends Model
{
    use HasFactory;

    public function instructor(){
        return $this->belongsTo(Admin::class,'instructor_id','id');
    }
}
