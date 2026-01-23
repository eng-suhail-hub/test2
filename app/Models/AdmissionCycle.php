<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{
    MorphTo,
    MorphMany,
    HasMany,
    BelongsTo
};

class AdmissionCycle extends Model
{
    protected $fillable = [
        'name',
        'starts_at',
        'ends_at',
        'capacity',
        'study_type_id',
        'applicable_type',
        'applicable_id',
        'is_open',
        'allow_pending',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at'   => 'datetime',
    ];

    public function applicable(): MorphTo
    {
        return $this->morphTo();
    }

    public function studyType(): BelongsTo
    {
        return $this->belongsTo(StudyType::class);
    }

    public function requirementAssignments(): MorphMany
    {
        return $this->morphMany(
            RequirementAssignment::class,
            'context'
        );
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    // منطق الأعمال
    public function hasCapacity(): bool
    {
        return $this->applications()
            ->whereIn('status', ['ACCEPTED', 'VERIFIED'])
            ->count() < $this->capacity;
    }

    public function isOpen(): bool
    {
        now()->between($this->starts_at, $this->ends_at);
    }
}