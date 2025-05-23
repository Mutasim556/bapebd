<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class HomeAboutus extends Model
{
    use HasFactory;

    public function translations()
    {
        return $this->morphMany(Translation::class, 'translationable');
    }
    public function getHeadlineAttribute($value){
        if (count($this->translations) > 0) {
            foreach ($this->translations as $translation) {
                if ($translation['key'] == 'headline') {
                    return $translation['value'];
                }
            }
        }

        return $value;
    }
    public function getShortDetailsAttribute($value){
        if (count($this->translations) > 0) {
            foreach ($this->translations as $translation) {
                if ($translation['key'] == 'short_details') {
                    return $translation['value'];
                }
            }
        }

        return $value;
    }
    public function getPointsAttribute($value){
        if (count($this->translations) > 0) {
            foreach ($this->translations as $translation) {
                if ($translation['key'] == 'points') {
                    return $translation['value'];
                }
            }
        }

        return $value;
    }
    public function getButtonTextAttribute($value){
        if (count($this->translations) > 0) {
            foreach ($this->translations as $translation) {
                if ($translation['key'] == 'button_text') {
                    return $translation['value'];
                }
            }
        }

        return $value;
    }
    //
    protected static function booted()
    {
        static::addGlobalScope('translate', function (Builder $builder) {
            $builder->with(['translations' => function ($query) {
                return $query->where([['locale',app()->getLocale()]]);
            }]);
        });
    }
}
