<?php

namespace App\Models\Admin;

use App\Models\Admin\Course\CourseInstructor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminProfileDetails extends Model
{
    use HasFactory;

    public function courses(){
        return $this->hasMany(CourseInstructor::class,'instructor_id','instructor_id');
    }
}
