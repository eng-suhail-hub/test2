<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudyType extends Model
{
    /**
     * GENERAL | PARALLEL | CLEARING
     */
    protected $fillable = [
        'code',
        'name',
        'description',
        'is_active',
    ];
}