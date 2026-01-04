<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Governorate extends Model
{
    protected $fillable = ['name'];

    /**
     * المحافظات → الجامعات
     */
    public function universities(): HasMany
    {
        return $this->hasMany(University::class);
    }
}