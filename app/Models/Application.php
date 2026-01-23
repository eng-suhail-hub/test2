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
        'admission_cycle_id',
        'status',
        'completion_rate',
        'submitted_at',
        'reviewed_at',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'reviewed_at' => 'datetime',
    ];

    /* ================= Relations ================= */

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function admissionCycle(): BelongsTo
    {
        return $this->belongsTo(AdmissionCycle::class);
    }

    public function rejection(): HasOne
    {
        return $this->hasOne(ApplicationRejection::class);
    }

    public function attendanceSchedule(): HasOne
    {
        return $this->hasOne(VerificationAppointment::class);
    }

    /* ================= State Helpers ================= */

    public function markSubmitted(): void
    {
        $this->update([
            'status' => 'SUBMITTED',
            'submitted_at' => now()
        ]);
    }

    public function markPending(): void
    {
        $this->update(['status' => 'PENDING']);
    }

    public function markUnderReview(): void
    {
        $this->update(['status' => 'UNDER_REVIEW']);
    }

    public function markAccepted(): void
    {
        $this->update([
            'status' => 'ACCEPTED',
            'reviewed_at' => now()
        ]);
    }

    public function markRejected(): void
    {
        $this->update([
            'status' => 'REJECTED',
            'reviewed_at' => now()
        ]);
    }
}