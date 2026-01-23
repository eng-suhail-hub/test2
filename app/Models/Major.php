<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Major extends Model
{
    protected $fillable = ['name', 'code', 'is_active'];

    /**
     * التخصص ↔ الكليات
     */
    public function colleges(): BelongsToMany
    {
        return $this->belongsToMany(College::class);
    }
}