<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Comment extends Model
{
    use HasFactory;

    public function translations()
    {
        return $this->morphMany(Translation::class, 'translationable');
    }
    public function getCommentAttribute($value){
        if (count($this->translations) > 0) {
            foreach ($this->translations as $translation) {
                if ($translation['key'] == 'comment') {
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
