<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * RequirementAssignment
 *
 * يمثل تطبيق فعلي لقاعدة شرط:
 * - يحدد القيمة المطلوبة
 * - السياق (System / University / College / Major)
 * - نوع الدراسة (StudyType)
 * - الأولوية
 */
class RequirementAssignment extends Model
{

    protected $fillable = [
        'requirement_rule_id',
        'context_type',
        'context_id',
        'study_type_id',
        'is_required',
        'priority',
        'is_active',
    ];

    protected $casts = [
        'expected_value' => 'array', // JSON → array
        'is_required' => 'boolean',
        'is_active' => 'boolean',
        'priority' => 'integer',
    ];

    /**
     * القاعدة المرتبطة
     */
    public function rule(): BelongsTo
    {
        return $this->belongsTo(RequirementRule::class, 'requirement_rule_id');
    }
    
    public function values()
{
    return $this->hasMany(
        RequirementAssignmentValue::class,
        'requirement_assignment_id'
    );
}

    /**
     * نوع الدراسة (GENERAL / PARALLEL / CLEARING ...)
     * nullable => ينطبق على جميع الأنواع
     */
    public function studyType(): BelongsTo
    {
        return $this->belongsTo(StudyType::class);
    }
    
    
    /**
     * للعلاقات مع كل الجداول باستخدام morph
     */
    public function context() {
        return $this->morphTo();
    }
    
    /**
     * الجامعة (إذا كان السياق UNIVERSITY)
     */
    /**
     
    public function university(): BelongsTo
    {
        return $this->belongsTo(University::class, 'context_id')
            ->where('context_type', 'UNIVERSITY');
    }
**/
    /**
     * الكلية (إذا كان السياق COLLEGE)
     */
 /*   public function college(): BelongsTo
    {
        return $this->belongsTo(College::class, 'context_id')
            ->where('context_type', 'COLLEGE');
    }*/

    /**
     * التخصص (إذا كان السياق MAJOR)
     */
  /*  public function major(): BelongsTo
    {
        return $this->belongsTo(Major::class, 'context_id')
            ->where('context_type', 'MAJOR');
    }
     */
    /**
     * Helper: هل هذا الشرط مفعل؟
     */
    public function isActive(): bool
    {
        return $this->is_active;
    }

    /**
     * Helper: هل الشرط إجباري؟
     */
    public function isRequired(): bool
    {
        return $this->is_required;
    }
}