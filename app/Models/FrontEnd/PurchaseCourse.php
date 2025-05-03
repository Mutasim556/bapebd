<?php

namespace App\Models\FrontEnd;

use App\Models\Admin\Course\Course;
use App\Models\Admin\Course\CourseBatch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseCourse extends Model
{
    use HasFactory;

    public function batch(){
        return $this->belongsTo(CourseBatch::class,'batch_id','id');
    }
}
