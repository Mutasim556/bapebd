<?php

namespace App\Models\Admin\Course;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseSubCategory extends Model
{
    use HasFactory;

    public function admin(){
        return $this->belongsTo(Admin::class,'sub_category_added_by','id');
    }

    public function category(){
        return $this->belongsTo(CourseCategory::class,'category_id','id');
    }
}
