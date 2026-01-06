<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VerificationAppointment extends Model
{
    protected $fillable = [
        'application_id',
        'appointment_at',
        'location',
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }
}