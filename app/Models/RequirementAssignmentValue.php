<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\RequirementAssignment;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RequirementAssignmentValue extends Model
{

    protected $fillable = [
        'value',
    ];

    /**
     * Cast القيمة إلى array تلقائيًا
     * (حتى لو كانت رقم أو string)
     */
    protected $casts = [
        'value' => 'array',
    ];

    /**
     * العلاقة مع RequirementAssignment
     */
    public function assignment(): BelongsTo
    {
        return $this->belongsTo(
            RequirementAssignment::class
        );
    }
}
