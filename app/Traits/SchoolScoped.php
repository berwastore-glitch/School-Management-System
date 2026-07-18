<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

trait SchoolScoped
{
    public static function bootSchoolScoped(): void
    {
        static::creating(function (Model $model) {
            if (is_null($model->school_id) && config('app.current_school_id')) {
                $model->school_id = config('app.current_school_id');
            }
        });
    }

    public function scopeForSchool(Builder $query, ?int $schoolId = null): Builder
    {
        $schoolId = $schoolId ?? config('app.current_school_id');

        if ($schoolId) {
            return $query->where('school_id', $schoolId);
        }

        return $query;
    }

    public static function forCurrentSchool(): Builder
    {
        $schoolId = config('app.current_school_id');

        if ($schoolId) {
            return static::where('school_id', $schoolId);
        }

        return static::query();
    }
}
