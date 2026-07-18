<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GradingScale extends Model
{
    use HasFactory;

    protected $fillable = ['school_id', 'curriculum_id', 'grade_letter', 'min_percentage', 'max_percentage', 'description', 'grade_points'];

    protected $casts = [
        'min_percentage' => 'integer',
        'max_percentage' => 'integer',
        'grade_points' => 'integer',
    ];

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function curriculum(): BelongsTo
    {
        return $this->belongsTo(Curriculum::class);
    }
}
