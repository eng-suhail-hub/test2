<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdmissionCycle extends Model
{
    protected $fillable = [
        'university_id',
        'college_id',
        'major_id',
        'study_type_id',
        'start_at',
        'end_at',
        'seats',
        'is_active',
    ];

    public function university(): BelongsTo
    {
        return $this->belongsTo(University::class);
    }

    public function college(): BelongsTo
    {
        return $this->belongsTo(College::class);
    }

    public function major(): BelongsTo
    {
        return $this->belongsTo(Major::class);
    }

    public function studyType(): BelongsTo
    {
        return $this->belongsTo(StudyType::class);
    }
}