<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RequirementAssignment extends Model
{
    protected $fillable = [
        'requirement_id',
        'university_id',
        'college_id',
        'major_id',
        'study_type_id',
        'admission_cycle_id',
        'is_mandatory',
        'priority',
    ];

    public function requirement(): BelongsTo
    {
        return $this->belongsTo(Requirement::class);
    }
}