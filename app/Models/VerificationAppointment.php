<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VerificationAppointment extends Model
{
    protected $fillable = [
        'application_id',
        'attendance_date',
        'attendance_time',
        'location',
        'instructions',
        'attendance_confirmed'
    ];
   
    protected $casts = [
        'attendance_date' => 'date',
        'attendance_time' => 'datetime:H:i',
        'attendance_confirmed' => 'boolean'
    ];
    
    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }
}