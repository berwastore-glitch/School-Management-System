<?php

namespace App\Traits;

trait NeedsSchool
{
    public function getSchoolId(): ?int
    {
        return config('app.current_school_id');
    }

    public function scopeBySchool($query)
    {
        if ($schoolId = $this->getSchoolId()) {
            $query->where('school_id', $schoolId);
        }

        return $query;
    }
}
