<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{
    BelongsTo,
    HasOne
};

class Application extends Model
{
    protected $fillable = [
        'student_id',
        'university_id',
        'college_id',
        'major_id',
        'study_type_id',
        'status',
        'submitted_at',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function rejection(): HasOne
    {
        return $this->hasOne(ApplicationRejection::class);
    }

    public function verificationAppointment(): HasOne
    {
        return $this->hasOne(VerificationAppointment::class);
    }
}