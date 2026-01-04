<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Requirement extends Model
{
    protected $fillable = [
        'code',
        'name',
        'type',
        'operator',
        'value',
        'is_active',
    ];

    public function assignments(): HasMany
    {
        return $this->hasMany(RequirementAssignment::class);
    }
}