<?php

namespace App\Models;

use App\Traits\SchoolScoped;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Fee extends Model
{
    use HasFactory, SchoolScoped;

    protected $fillable = ['student_id', 'fee_type', 'amount', 'due_date', 'paid_date', 'payment_method', 'payment_status', 'transaction_id', 'remark', 'school_id'];

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}
