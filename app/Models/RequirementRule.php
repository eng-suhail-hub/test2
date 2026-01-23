<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * RequirementRule
 *
 * يمثل تعريف مجرد لقاعدة شرط:
 * - لا يحتوي أي قيمة
 * - يحدد فقط:
 *   - الكيان المستهدف (Student, Application, SecondaryEducation)
 *   - الحقل المستهدف
 *   - نوع المقارنة (operator)
 *   - نوع القيمة المتوقعة
 */
class RequirementRule extends Model
{

    protected $fillable = [
        'code',
        'name',
        'description',
        'target_type',
        'target_field',
        'operator',
        'value_type',
        'is_global',
        'is_active',
    ];

    protected $casts = [
        'is_global' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Assignments التي تستخدم هذه القاعدة
     *
     * rule -> many assignments
     */
    public function assignments(): HasMany
    {
        return $this->hasMany(RequirementAssignment::class);
    }

    /**
     * Helper: هل هذه القاعدة مفعلة؟
     */
    public function isActive(): bool
    {
        return $this->is_active;
    }

    /**
     * Helper: هل هذه القاعدة عامة على النظام؟
     */
    public function isGlobal(): bool
    {
        return $this->is_global;
    }
}