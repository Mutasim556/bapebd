<?php

namespace App\Models\FrontEnd;

use App\Models\Admin;
use App\Models\Admin\Course\CourseCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerMessage extends Model
{
    use HasFactory;

    public function subjectDetails(){
        return $this->belongsTo(CourseCategory::class,'subject','id');
    }

    public function repliedBy(){
        return $this->belongsTo(Admin::class,'replied_by','id');
    }
}
