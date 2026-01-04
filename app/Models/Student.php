<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{
    BelongsTo,
    HasMany,
    HasOne
};

class Student extends Model
{
    protected $fillable = [
        'user_id',
        'full_name',
        'national_id',
        'birth_date',
        'birth_governorate_id',
        'phone',
        'has_applied_before',
    ];

    /**
     * الطالب → حساب المستخدم
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * الطالب → محافظة الميلاد
     */
    public function birthGovernorate(): BelongsTo
    {
        return $this->belongsTo(Governorate::class, 'birth_governorate_id');
    }

    /**
     * الطالب → بيانات الثانوية
     */
    public function secondaryEducation(): HasOne
    {
        return $this->hasOne(SecondaryEducation::class);
    }

    /**
     * الطالب → طلبات التقديم
     */
    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }
}