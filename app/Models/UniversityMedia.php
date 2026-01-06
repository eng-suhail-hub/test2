<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UniversityMedia extends Model
{
    protected $fillable = [
        'university_id',
        'type', // IMAGE | VIDEO
        'path',
        'order', // ترتيب العرض
    ];

    public function university(): BelongsTo
    {
        return $this->belongsTo(University::class);
    }
}