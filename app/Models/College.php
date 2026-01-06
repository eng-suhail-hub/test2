<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{
    BelongsTo,
    BelongsToMany
};

class College extends Model
{
    protected $fillable = [
        'university_id',
        'name',
    ];

    public function university(): BelongsTo
    {
        return $this->belongsTo(University::class);
    }

    /**
     * الكلية ↔ التخصصات (many-to-many)
     */
    public function majors(): BelongsToMany
    {
        return $this->belongsToMany(Major::class);
    }
}