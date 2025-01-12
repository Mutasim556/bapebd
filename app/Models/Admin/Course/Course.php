<?php

namespace App\Models\Admin\Course;

use App\Models\Admin;
use App\Models\Admin\Translation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $table = 'courses';

    public function admin(){
        return $this->belongsTo(Admin::class,'course_added_by','id');
    }

    public function instructor(){
        return $this->belongsTo(Admin::class,'instructor_id','id');
    }

    public function translations()
    {
        return $this->morphMany(Translation::class, 'translationable');
    }

    public function getCourseNameAttribute($value){
        if (count($this->translations) > 0) {
            foreach ($this->translations as $translation) {
                if ($translation['key'] == 'course_name') {
                    return $translation['value'];
                }
            }
        }

        return $value;
    }

    public function getCourseHeadlineAttribute($value){
        if (count($this->translations) > 0) {
            foreach ($this->translations as $translation) {
                if ($translation['key'] == 'course_headline') {
                    return $translation['value'];
                }
            }
        }

        return $value;
    }

    public function getCourseDetailsAttribute($value){
        if (count($this->translations) > 0) {
            foreach ($this->translations as $translation) {
                if ($translation['key'] == 'course_details') {
                    return $translation['value'];
                }
            }
        }

        return $value;
    }

    protected static function booted()
    {
        static::addGlobalScope('translate', function (Builder $builder) {
            $builder->with(['translations' => function ($query) {
                return $query->where([['locale',app()->getLocale()]]);
            }]);
        });
    }
}
