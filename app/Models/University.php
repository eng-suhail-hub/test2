<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{
    BelongsTo,
    HasMany,
    BelongsToMany
};

class University extends Model
{
    protected $fillable = [
        'name',
        'code',
        'governorate_id',
        'logo_path',
        'front_image',
        'background_image',
        'type',
        'students_count',
        'description',
        'is_active',
    ];

    /**
     * الجامعة → المحافظة
     */
   public function governorate(): BelongsTo
    {
        return $this->belongsTo(Governorate::class);
    }

    /**
     * الجامعة → الكليات
     */
    public function colleges(): HasMany
    {
        return $this->hasMany(College::class);
    }

    /**
     * الجامعة → وسائط (صور / فيديو)
     */
    public function media(): HasMany
    {
        return $this->hasMany(UniversityMedia::class);
    }

    /**
     * الجامعة → مدراء الجامعات
     */
    public function admins(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_university')
            ->withTimestamps();

    }

    /**
     * الجامعة → دورات القبول
     */
    public function admissionCycles(): HasMany
    {
        return $this->hasMany(AdmissionCycle::class);
    }
}