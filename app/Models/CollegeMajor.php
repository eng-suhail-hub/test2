<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{
    BelongsTo,
    BelongsToMany
};
use Illuminate\Database\Eloquent\Relations\MorphMany; //علاقة morph

class CollegeMajor extends Model
{
    protected $fillable = [
        'college_id',
        'major_id',
        'is_active',
    ];

    public function college()
    {
        return $this->belongsTo(College::class);
    }

    public function major()
    {
        return $this->belongsTo(Major::class);
    }

    

    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}
