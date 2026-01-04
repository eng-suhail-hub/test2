<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SecondaryEducation extends Model
{
    protected $fillable = [
        'student_id',
        'school_name',
        'school_governorate_id',
        'certificate_type',
        'grade',
        'graduation_year',
        'certificate_file_path',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function schoolGovernorate(): BelongsTo
    {
        return $this->belongsTo(Governorate::class, 'school_governorate_id');
    }
}