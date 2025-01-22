<?php

namespace App\Models\Admin\Course;

use App\Models\Admin;
use App\Models\Admin\Translation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseCategory extends Model
{
    use HasFactory;
    protected $table = 'course_categories';

    public function admin(){
        return $this->belongsTo(Admin::class,'category_added_by','id');
    }
    public function subCategory(){
        return $this->hasMany(CourseSubCategory::class,'category_id','id');
    }
    public function translations()
    {
        return $this->morphMany(Translation::class, 'translationable');
    }

    public function getCategoryNameAttribute($value){
        if (count($this->translations) > 0) {
            foreach ($this->translations as $translation) {
                if ($translation['key'] == 'category_name') {
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
